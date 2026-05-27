<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));
        
        $shipping = 15000; // Flat rate for Dar es Salaam
        $vat = $subtotal * 0.18;
        $total = $subtotal + $shipping + $vat;

        return view('checkout.checkout', compact('cartItems', 'subtotal', 'shipping', 'vat', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'payment_phone_number' => 'required_if:payment_method,mpesa,tigopesa,airtelmoney',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'delivery_notes' => 'nullable|string'
        ]);

        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $subtotal = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));
            
            $total = $subtotal + 15000 + ($subtotal * 0.18);

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => auth()->user()->name,
                'phone' => $request->delivery_phone ?? auth()->user()->phone ?? '',
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'delivery_notes' => $request->delivery_notes,
                'delivery_status' => 'pending'
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            // Mongike API Integration for Mobile Money
            if (in_array($request->payment_method, ['mpesa', 'tigopesa', 'airtelmoney'])) {
                $formattedPhone = $this->formatPhoneNumber($request->payment_phone_number);
                
                $apiKey = env('MONGIKE_API_KEY');
                if (!$apiKey) {
                    throw new \Exception('Payment system not configured. Missing MONGIKE_API_KEY in .env');
                }

                $paymentData = [
                    'order_id' => 'ORD-' . $order->id . '-' . time(),
                    'amount' => $total,
                    'buyer_phone' => $formattedPhone,
                    'buyer_name' => auth()->user()->name,
                    'buyer_email' => auth()->user()->email,
                    'fee_payer' => env('MONGIKE_FEE_PAYER', 'MERCHANT'),
                ];

                Log::info('Initiating Mongike Payment', ['payload' => $paymentData]);

                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post(env('MONGIKE_BASE_URL') . '/payments/mobile-money/tanzania', $paymentData);

                Log::info('Mongike Response', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                if ($response->failed()) {
                    $errorMsg = $response->json()['message'] ?? 'Unknown gateway error';
                    throw new \Exception('Payment initiation failed: ' . $errorMsg);
                }

                // Save Mongike Payment ID as reference
                $mongikeData = $response->json()['data'] ?? [];
                if (isset($mongikeData['id'])) {
                    $order->update(['payment_reference' => $mongikeData['id']]);
                }
            }

            // Award Loyalty Points (100 TZS = 1 Point)
            $earnedPoints = floor($total / 100);
            $user = auth()->user();
            
            \App\Models\LoyaltyTransaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'points' => $earnedPoints,
                'type' => 'earned',
                'description' => "Earned from Order #SB-" . str_pad($order->id, 5, '0', STR_PAD_LEFT)
            ]);

            $user->loyalty_points += $earnedPoints;
            $user->loyalty_level = $user->calculateLoyaltyLevel();
            $user->save();

            DB::commit();
            session()->forget('cart');

            $trackingId = 'SB-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            return redirect()->route('customer.orders')->with('success', "Order [{$trackingId}] placed successfully! Please check your phone for the STK push and enter your PIN.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function verifyPaymentStatus(Order $order)
    {
        if (!$order->payment_reference) {
            return back()->with('error', 'No payment reference found for this order.');
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => env('MONGIKE_API_KEY'),
            ])->timeout(30)->get(env('MONGIKE_BASE_URL') . '/payments/' . $order->payment_reference);

            if ($response->successful()) {
                $status = $response->json()['data']['status'] ?? 'pending';
                
                if ($status === 'SUCCESS' || $status === 'successful' || $status === 'completed') {
                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                    return back()->with('success', 'Payment confirmed! Your order is now being processed.');
                }

                return back()->with('info', 'Payment is still ' . $status . '. Please ensure you have entered your PIN on your phone.');
            }

            return back()->with('error', 'Could not verify payment status at this time. Please try again later.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error verifying status: ' . $e->getMessage());
        }
    }

    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If it starts with 0, replace with 255
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }

        // If it starts with +, treat carefully (preg_replace already removed it)
        // If it's 9 digits (e.g. 712...), prepend 255
        if (strlen($phone) === 9) {
            $phone = '255' . $phone;
        }

        return $phone;
    }
}
