<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function brandStory()
    {
        return view('pages.brand-story');
    }

    public function storeLocator()
    {
        return view('pages.store-locator');
    }

    public function mpesaGuide()
    {
        return view('pages.mpesa-guide');
    }

    public function shippingPolicy()
    {
        return view('pages.shipping-policy');
    }

    public function returnPolicy()
    {
        return view('pages.policy-base', ['title' => 'Return & Exchange Policy']);
    }

    public function privacyPolicy()
    {
        return view('pages.policy-base', ['title' => 'Privacy & Security Policy']);
    }

    public function contactUs()
    {
        return view('pages.policy-base', ['title' => 'Contact Silk Beauty Support']);
    }

    public function trackOrder()
    {
        return view('pages.track-order');
    }

    public function trackOrderSearch(Request $request)
    {
        $code = $request->input('tracking_code');
        
        // Pattern: SB-XXXXX (extract digits)
        if (preg_match('/SB-(\d+)/i', $code, $matches)) {
            $orderId = (int)$matches[1];
        } else {
            // Try if they just entered numbers
            $orderId = (int)preg_replace('/[^0-9]/', '', $code);
        }

        $order = \App\Models\Order::find($orderId);

        if (!$order) {
            return back()->with('error', "No order found for tracking code: {$code}. Please verify and try again.")->withInput();
        }

        return view('pages.track-order', compact('order'));
    }
}
