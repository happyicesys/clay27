<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HitPayService
{
    protected $apiKey;
    protected $salt;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.hitpay.api_key');
        $this->salt = config('services.hitpay.salt');
        $this->baseUrl = config('services.hitpay.is_production')
            ? 'https://api.hit-pay.com/v1'
            : 'https://api.sandbox.hit-pay.com/v1';
    }

    public function createPaymentRequest($amount, $currency, $reference, $redirectUrl, $webhookUrl, $email, $name)
    {
        // Mock implementation for now if no keys
        if (empty($this->apiKey)) {
            return [
                'url' => $redirectUrl . '?status=completed&reference=' . $reference,
                'id' => 'mock_' . uniqid(),
            ];
        }

        $response = Http::withHeaders([
            'X-BUSINESS-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded',
            'X-Requested-With' => 'XMLHttpRequest',
        ])->post($this->baseUrl . '/payment-requests', [
                    'amount' => $amount,
                    'currency' => $currency,
                    'reference_number' => $reference,
                    'redirect_url' => $redirectUrl,
                    'webhook' => $webhookUrl,
                    'email' => $email,
                    'name' => $name,
                ]);

        return $response->json();
    }
}
