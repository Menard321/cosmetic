<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    private $systemPrompt = <<<PROMPT
You are "Beauty AI", a professional skincare and cosmetic assistant.

Your role is strictly limited to providing accurate, safe, and helpful information about:
- Skin problems (acne, dryness, oily skin, pigmentation, eczema, dark spots, etc.)
- Cosmetic and skincare products
- Beauty routines (morning and night skincare routines)
- Cosmetic ingredients and their effects
- Product recommendations based on skin type
- General skincare and beauty guidance

STRICT RULES:
1. You MUST ONLY answer questions related to skincare, cosmetics, beauty, and skin health.
2. If a user asks anything outside this scope (e.g. politics, coding, hacking, math, general knowledge, relationships, etc.), respond exactly:
   "I only provide assistance related to skincare, cosmetics, and skin health topics."
3. Do NOT provide medical diagnoses. Always give general skincare advice and recommend a dermatologist for serious conditions.
4. Do NOT claim real-world experience or personal identity.
5. Do not provide unsafe, harmful, or extreme product advice.
6. Always prioritize safe and gentle skincare recommendations.

RESPONSE STYLE:
- Clear, simple, and helpful explanations
- Use bullet points when necessary
- Be professional like a skincare consultant or beauty advisor
- Suggest general product types (e.g. "gentle cleanser", "salicylic acid toner")

CONTEXT AWARENESS:
If user skin data or product database is provided, use it to personalize answers.

GOAL:
Help users improve their skin health, understand cosmetic products, and build safe skincare routines effectively.
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
        $products = \App\Models\Product::where('is_active', true)->get(['name', 'brand', 'price', 'description', 'stock_quantity']);
        $categories = \App\Models\Category::all(['name']);
        $user = auth()->user();

        $productContext = "AVAILABLE PRODUCTS IN ANGELS BEAUTY STORE:\n";
        foreach ($products as $p) {
            $productContext .= "- {$p->name} by {$p->brand}. Price: " . number_format($p->price) . " TZS. Stock: {$p->stock_quantity}. Description: {$p->description}\n";
        }

        $systemFeatureContext = "SYSTEM FUNCTIONALITIES:\n";
        $systemFeatureContext .= "- Loyalty Points: Users earn 1 point for every 100 TZS spent. Current user ({$user->name}) has " . number_format($user->loyalty_points) . " points and is a '{$user->loyalty_level}' member.\n";
        $systemFeatureContext .= "- Order Tracking: Users can track orders via the 'Track My Order' page using their Order ID.\n";
        $systemFeatureContext .= "- Consultations: Users can book professional beauty consultations through the portal.\n";

        $fullSystemPrompt = $this->systemPrompt . "\n\n" . $systemFeatureContext . "\n" . $productContext;

        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . trim($apiKey), [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $fullSystemPrompt]
                    ]
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $userMessage]
                        ]
                    ]
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
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json(['reply' => $reply]);
                }
            }

            // Fallback for when API fails (e.g. invalid/fake API key or rate limit)
            Log::warning('Gemini API failed, using local fallback.');
            
            $input = strtolower($userMessage);
            $fallbackReply = "I'm " . $user->name . "'s Beauty AI assistant. I can help you with your " . number_format($user->loyalty_points) . " loyalty points, track your orders, or recommend products like our " . ($products->first()->name ?? 'latest scents') . ". How can I help with your beauty journey?";
            
            if (strpos($input, 'mambo') !== false || strpos($input, 'hi') !== false || strpos($input, 'hello') !== false) {
                $fallbackReply = "Hello! 👋 I'm your Beauty AI. I know all about our " . $products->count() . " products, your " . number_format($user->loyalty_points) . " loyalty points, and how to track your orders. What beauty help do you need?";
            } else if (strpos($input, 'order') !== false || strpos($input, 'track') !== false) {
                $fallbackReply = "You can track your order using your Order ID on our 'Track Order' page. I can also see that you have " . $user->orders()->count() . " orders in our system!";
            } else if (strpos($input, 'points') !== false || strpos($input, 'loyalty') !== false) {
                $fallbackReply = "You currently have " . number_format($user->loyalty_points) . " loyalty points! You are a " . $user->loyalty_level . " member. Keep shopping to reach the next tier!";
            } else if (strpos($input, 'president') !== false || strpos($input, 'math') !== false || strpos($input, 'code') !== false) {
                $fallbackReply = "I only provide assistance related to skincare, cosmetics, and skin health topics within the Angels Beauty system.";
            }

            return response()->json(['reply' => $fallbackReply]);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request. Please try again.'], 500);
        }
    }
}
