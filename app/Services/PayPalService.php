<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class PayPalService
{
    private function baseUrl(): string
    {
        return config('services.paypal.mode') === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    }

    private function token(): string
    {
        return Http::asForm()->withBasicAuth((string) config('services.paypal.client_id'), (string) config('services.paypal.client_secret'))->timeout(10)->connectTimeout(3)->retry([100, 500])->post($this->baseUrl().'/v1/oauth2/token', ['grant_type' => 'client_credentials'])->throw()->json('access_token');
    }

    private function client(): PendingRequest
    {
        return Http::withToken($this->token())->acceptJson()->timeout(15)->connectTimeout(3)->retry([100, 500]);
    }

    public function createOrder(string $amount, string $currency, string $reference): array
    {
        return $this->client()->post($this->baseUrl().'/v2/checkout/orders', ['intent' => 'CAPTURE', 'purchase_units' => [['reference_id' => $reference, 'amount' => ['currency_code' => $currency, 'value' => $amount]]], 'application_context' => ['return_url' => route('paypal.return'), 'cancel_url' => route('paypal.cancel')]])->throw()->json();
    }

    public function capture(string $orderId): array
    {
        return $this->client()->post($this->baseUrl()."/v2/checkout/orders/{$orderId}/capture")->throw()->json();
    }

    public function sendPayout(string $email, string $amount, string $currency, string $reference): array
    {
        return $this->client()->post($this->baseUrl().'/v1/payments/payouts', [
            'sender_batch_header' => ['sender_batch_id' => $reference, 'email_subject' => 'Votre gain Businos Line'],
            'items' => [[
                'recipient_type' => 'EMAIL',
                'receiver' => $email,
                'sender_item_id' => $reference,
                'amount' => ['currency' => $currency, 'value' => $amount],
            ]],
        ])->throw()->json();
    }

    public function verifyWebhook(array $headers, array $event): bool
    {
        $response = $this->client()->post($this->baseUrl().'/v1/notifications/verify-webhook-signature', ['auth_algo' => $headers['paypal-auth-algo'] ?? null, 'cert_url' => $headers['paypal-cert-url'] ?? null, 'transmission_id' => $headers['paypal-transmission-id'] ?? null, 'transmission_sig' => $headers['paypal-transmission-sig'] ?? null, 'transmission_time' => $headers['paypal-transmission-time'] ?? null, 'webhook_id' => config('services.paypal.webhook_id'), 'webhook_event' => $event]);

        return $response->successful() && $response->json('verification_status') === 'SUCCESS';
    }
}
