<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    private $systemPrompt = <<<PROMPT
# MASTER PROMPT — AI SKINCARE ANALYSIS & PRODUCT RECOMMENDATION FEATURE FOR NIFFER COSMETIC SYSTEM

You are the official intelligent skincare and beauty AI assistant for Niffer Cosmetic Tanzania.

Your role is to professionally analyze customer skin concerns and recommend the most suitable beauty and skincare products based on the user's skin type, symptoms, and skincare needs.

Your mission is to help customers:
* understand their skin concerns
* receive professional skincare guidance
* choose suitable cosmetic products
* build healthy skincare routines
* improve beauty confidence
* shop confidently from Niffer Cosmetic

---

## AI BEHAVIOR
* Respond professionally, elegant, and luxurious.
* Use supportive language and provide organized answers.
* Prioritize healthy skincare and build customer trust.
* Never insult appearance or recommend dangerous products/bleaching.
* NEVER claim to be a doctor. Advise seeing a dermatologist for serious or painful conditions.

---

## SKIN ANALYSIS LOGIC
When a customer explains a skin concern:
STEP 1: Identify skin type, symptoms, severity, and irritation level.
STEP 2: Explain the possible skincare cause professionally.
STEP 3: Recommend the best matching products from Niffer Cosmetic.
STEP 4: Explain why the products are suitable.
STEP 5: Provide a clear Morning and Night routine with important tips.

---

## RESPONSE FORMAT (MANDATORY)
Always respond using this professional structure:

Skin Concern: [Explain concern professionally]
Possible Cause: [Short explanation]

Recommended Products:
* Product 1
* Product 2

Why These Products Help: [Professional explanation]

Morning Routine:
1. [Step 1]
2. [Step 2]

Night Routine:
1. [Step 1]
2. [Step 2]

Important Tips:
* Tip 1
* Tip 2

---

## COMPANY & FOUNDER INFORMATION
Company Name: Niffer Cosmetic Tanzania
Founder: Jenifer Jovin Bilikwija (Known as Niffer).
Biography: Jenifer Jovin Bilikwija is a Tanzanian cosmetics entrepreneur and founder associated with Niffer Cosmetic Tanzania. She is recognized for beauty entrepreneurship, skincare promotion, perfumes, and building the Niffer brand.
Mission: To improve beauty confidence and healthy skincare through quality cosmetic products and customer care.

---

## ADVANCED FEATURE GOAL
Your goal is to become an intelligent beauty consultant that strengthens trust in Niffer Cosmetic Tanzania through premium customer experience and expert skin analysis.
PROMPT;

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return response()->json(['error' => 'AI service is currently unavailable.'], 500);
        }

        // Fetch System Knowledge
        $products = \App\Models\Product::all(['name', 'brand', 'price', 'description', 'stock_quantity']);
        $user = auth()->user();
        $isAdmin = $user && ($user->hasRole('admin') || $user->hasRole('super-admin'));

        $productContext = "AVAILABLE PRODUCTS IN Niffer Cosmetic STORE:\n";
        foreach ($products as $p) {
            $productContext .= "- {$p->name} by {$p->brand}. Price: " . number_format($p->price) . " TZS. Stock: {$p->stock_quantity}. Description: {$p->description}\n";
        }

        $systemFeatureContext = "SYSTEM INTELLIGENCE & FUNCTIONALITIES:\n";
        
        if ($isAdmin) {
            $systemFeatureContext .= "- ADMIN CONTEXT: You are assisting an administrator ({$user->name}).\n";
            $systemFeatureContext .= "- Inventory: Total items in stock across the collection is " . $products->sum('stock_quantity') . ".\n";
            $systemFeatureContext .= "- ERP Features: The system includes Shift Management, Staff Transfers, and HR Analytics. Assist with ERP navigation if asked.\n";
            $systemFeatureContext .= "- Expert Guidance: Provide business insights and professional skincare advice for them to relay to clients.\n";
            $systemFeatureContext .= "- Loyalty Management: The system has a 4-tier loyalty engine (Silver/Gold/Platinum/Diamond) with campaign multipliers, event ticketing, and referral bonuses.\n";
        } else {
            $systemFeatureContext .= "- CUSTOMER CONTEXT: You are assisting a valued customer or guest.\n";
            if ($user) {
                $systemFeatureContext .= "- User Rewards: {$user->name} has " . number_format($user->loyalty_points) . " loyalty points and is a '{$user->loyalty_level}' member.\n";
            }
            $systemFeatureContext .= "- Loyalty System: Niffer operates a 4-tier Beauty Rewards program:\n";
            $systemFeatureContext .= "  * Silver (0-999 pts): Basic beauty advice, Monthly newsletter\n";
            $systemFeatureContext .= "  * Gold (1,000-4,999 pts): Birthday gifts, 5% discount on all items\n";
            $systemFeatureContext .= "  * Platinum (5,000-9,999 pts): Free home delivery, VIP workshops, 10% discount\n";
            $systemFeatureContext .= "  * Diamond (10,000+ pts): Personal beauty consultant, 15% discount, Private launch events\n";
            $systemFeatureContext .= "- Referral Program: Customers earn 500 bonus points for each friend they refer.\n";
            $systemFeatureContext .= "- Beauty Events: Niffer hosts exclusive skincare workshops and beauty events with QR-coded tickets.\n";
            $systemFeatureContext .= "- Order Tracking: Customers can track orders on the 'Track My Order' page.\n";
            $systemFeatureContext .= "- Personal Care: Focus on recommending products based on their specific concerns and building a routine.\n";
        }

        $fullSystemPrompt = $this->systemPrompt . "\n\n" . $systemFeatureContext . "\n" . $productContext;

        try {
            $response = Http::timeout(20)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . trim($apiKey), [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $fullSystemPrompt]
                    ]
                ],
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $userMessage]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return response()->json(['reply' => $data['candidates'][0]['content']['parts'][0]['text']]);
                }
            }
            throw new \Exception("API Error: " . ($response->body() ?: 'Unknown error'));

        } catch (\Exception $e) {
            Log::warning('AI Service Issue: ' . $e->getMessage());
            return $this->getFallbackResponse($userMessage, $user, $products);
        }
    }

    private function getFallbackResponse($userMessage, $user, $products)
    {
        $input = strtolower($userMessage);
        
        // Brand & Founder Info (Priority)
        if (strpos($input, 'niffer') !== false || strpos($input, 'founder') !== false || strpos($input, 'who is') !== false) {
            return response()->json(['reply' => "Jenifer Jovin Bilikwija is the esteemed founder and visionary behind Niffer Cosmetic Tanzania. As a leading cosmetics entrepreneur, she has dedicated her career to redefining beauty standards through high-quality skincare, fragrances, and wellness products. Under her leadership, Niffer Cosmetic has become a symbol of excellence and confidence for customers across Tanzania."]);
        }

        // Basic Greetings
        if (strpos($input, 'mambo') !== false || strpos($input, 'hi') !== false || strpos($input, 'hello') !== false) {
            return response()->json(['reply' => "Greetings, " . $user->name . ". I am your Niffer Beauty Consultant. It is a pleasure to assist you today. I can provide details regarding our " . $products->count() . " active product collections, your accumulated " . number_format($user->loyalty_points) . " loyalty points, or assist with tracking your recent orders. How may I elevate your beauty journey?"]);
        }

        // Order Tracking
        if (strpos($input, 'order') !== false || strpos($input, 'track') !== false) {
            return response()->json(['reply' => "To monitor your order's progress, please provide your Order ID on our 'Track Order' portal. Our records indicate you currently have " . $user->orders()->count() . " active or past orders associated with your profile. I am here to ensure your products arrive perfectly."]);
        }

        // Loyalty Points
        if (strpos($input, 'points') !== false || strpos($input, 'loyalty') !== false) {
            return response()->json(['reply' => "You currently hold a prestigious " . $user->loyalty_level . " membership status with " . number_format($user->loyalty_points) . " loyalty points. These points are a testament to your commitment to quality skincare. Continue your journey with us to unlock exclusive executive rewards."]);
        }

        // Out of Scope
         if (strpos($input, 'president') !== false || strpos($input, 'math') !== false || strpos($input, 'code') !== false) {
            return response()->json(['reply' => "As a dedicated Niffer Beauty Assistant, I specialize exclusively in professional skincare, cosmetics, and wellness guidance. I invite you to explore our collections for any beauty-related inquiries."]);
        }

        // Default Generic Fallback
        return response()->json(['reply' => "Welcome, " . $user->name . ". I am your dedicated Niffer Beauty Consultant. I am currently refreshing our global beauty database to provide you with the most up-to-date analysis. In the meantime, I can immediately assist you with your loyalty rewards, order history, or brand-specific information. How can I serve you today?"]);
    }
}
