<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $apiKey;
    protected $secretKey;
    protected $senderId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.nextsms.key');
        $this->secretKey = config('services.nextsms.secret');
        $this->senderId = config('services.nextsms.sender_id', 'NEXTSMS');
        $this->baseUrl = config('services.nextsms.base_url');
    }

    /**
     * Send a single SMS message.
     *
     * @param string $phoneNumber Formatted number (e.g. 255712345678)
     * @param string $message The message content
     * @return array Response data
     */
    public function sendSms(string $phoneNumber, string $message)
    {
        // Ensure phone number starts with country code without '+'
        $phoneNumber = ltrim($phoneNumber, '+');

        try {
            $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
                ->timeout(3) // 3 seconds timeout for response
                ->connectTimeout(2) // 2 seconds to establish connection
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/single', [
                    'from' => $this->senderId,
                    'to' => $phoneNumber,
                    'text' => $message,
                ]);

            if ($response->successful()) {
                Log::info('SMS Sent successfully', [
                    'to' => $phoneNumber,
                    'response' => $response->json()
                ]);
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('SMS delivery failed', [
                'to' => $phoneNumber,
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Gateway returned error: ' . ($response->json()['message'] ?? 'Unknown error')
            ];

        } catch (\Exception $e) {
            Log::error('SMS connection error', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Service exception: ' . $e->getMessage()
            ];
        }
    }
}
