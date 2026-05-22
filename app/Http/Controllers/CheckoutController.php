<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'vat', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'phone_number' => 'required_if:payment_method,mpesa,tigopesa,airtelmoney'
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
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_address' => $request->address,
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

            DB::commit();
            session()->forget('cart');

            return redirect()->route('customer.orders')->with('success', 'Order placed successfully! Please complete payment via ' . strtoupper($request->payment_method));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
