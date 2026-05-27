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

        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . trim($apiKey), [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $this->systemPrompt]
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
            Log::warning('Gemini API failed, using local fallback. Google Error: ' . $response->body());
            
            $input = strtolower($userMessage);
            $fallbackReply = "I specialize in skincare and beauty! For a glowing complexion, I recommend a gentle cleanser followed by a hydrating serum. How else can I assist you with your personalized Tynorosa beauty routine?";
            
            if (strpos($input, 'mambo') !== false || strpos($input, 'hi') !== false || strpos($input, 'hello') !== false) {
                $fallbackReply = "Hello! 👋 I'm your Beauty AI. I'm here to answer any questions about skincare, healthy habits, or cosmetic ingredients. What's on your mind?";
            } else if (strpos($input, 'acne') !== false || strpos($input, 'pimple') !== false) {
                $fallbackReply = "For acne-prone skin, I recommend looking for products with **Salicylic Acid** or **Benzoyl Peroxide**. They help unclog pores and reduce inflammation. Always remember to use a non-comedogenic moisturizer!";
            } else if (strpos($input, 'dry') !== false) {
                $fallbackReply = "Dry skin loves hydration! Try incorporating a **Hyaluronic Acid** serum and a rich ceramide cream in your routine. Drink plenty of water as well.";
            } else if (strpos($input, 'president') !== false || strpos($input, 'math') !== false || strpos($input, 'code') !== false) {
                $fallbackReply = "I only provide assistance related to skincare, cosmetics, and skin health topics.";
            }

            return response()->json(['reply' => $fallbackReply]);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request. Please try again.'], 500);
        }
    }
}
