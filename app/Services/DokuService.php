<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DokuService
{
    protected $clientId;
    protected $secretKey;
    protected $sharedKey;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = env('DOKU_CLIENT_ID');
        $this->secretKey = env('DOKU_SECRET_KEY');
        $this->sharedKey = env('DOKU_SHARED_KEY');
        $this->isProduction = env('DOKU_ENVIRONMENT') === 'production';
        $this->baseUrl = $this->isProduction ? 'https://api.doku.com' : 'https://api-sandbox.doku.com';
    }

    /**
     * Generate checkout URL for the order.
     */
    public function getCheckoutUrl(Order $order): ?string
    {
        // If DOKU is not configured, return null
        if (empty($this->clientId) || empty($this->secretKey)) {
            return null;
        }

        try {
            $requestId = (string) Str::uuid();
            $dateTime = gmdate('Y-m-d\TH:i:s\Z');
            $targetPath = '/checkout/v1/payment';
            
            // Format order items for DOKU
            $lineItems = [];
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'name' => $item['title'] . (isset($item['package_name']) && $item['package_name'] ? ' - ' . $item['package_name'] : ''),
                    'price' => (int) $item['price_raw'],
                    'quantity' => (int) ($item['qty'] ?? 1),
                ];
            }

            // Format phone to DOKU 62xxx standard
            $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            if (!str_starts_with($phone, '62')) {
                $phone = '62' . $phone;
            }

            $payload = [
                'order' => [
                    'invoice_number' => $order->id,
                    'amount' => (int) $order->total_price,
                    'currency' => 'IDR',
                    'line_items' => $lineItems,
                    'callback_url' => route('checkout.success', ['orderId' => $order->id]),
                    'auto_redirect' => true,
                ],
                'payment' => [
                    'payment_due_date' => 60
                ],
                'customer' => [
                    'name' => $order->customer_name,
                    'phone' => $phone,
                    'email' => 'customer@fshop.space', // Fallback email for DOKU requirements
                ]
            ];

            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $signature = $this->generateSignature($requestId, $dateTime, $targetPath, $jsonPayload);

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $dateTime,
                'Signature' => 'HMACSHA256=' . $signature,
                'Content-Type' => 'application/json',
            ])->withBody($jsonPayload, 'application/json')->post($this->baseUrl . $targetPath);

            if ($response->successful() && isset($response->json()['response']['payment']['url'])) {
                // Update DOKU invoice reference
                $order->update([
                    'doku_invoice_id' => $response->json()['response']['payment']['invoice_number'] ?? null
                ]);
                return $response->json()['response']['payment']['url'];
            }

            // Log error
            \Log::error('DOKU API payment token creation failed.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            \Log::error('DOKU Payment integration exception.', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check transaction status from DOKU.
     */
    public function checkStatus(string $invoiceNumber): ?string
    {
        if (empty($this->clientId) || empty($this->secretKey)) {
            return null;
        }

        try {
            $requestId = (string) Str::uuid();
            $dateTime = gmdate('Y-m-d\TH:i:s\Z');
            $targetPath = '/orders/v1/status';
            
            $payload = [
                'order' => [
                    'invoice_number' => $invoiceNumber
                ]
            ];

            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $digest = base64_encode(hash('sha256', $jsonPayload, true));
            
            $signatureComponent = "Client-Id:" . $this->clientId . "\n" .
                                 "Request-Id:" . $requestId . "\n" .
                                 "Request-Timestamp:" . $dateTime . "\n" .
                                 "Request-Target:" . $targetPath . "\n" .
                                 "Digest:" . $digest;

            $signature = base64_encode(hash_hmac('sha256', $signatureComponent, $this->secretKey, true));

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $dateTime,
                'Signature' => 'HMACSHA256=' . $signature,
                'Content-Type' => 'application/json',
            ])->withBody($jsonPayload, 'application/json')->post($this->baseUrl . $targetPath);

            if ($response->successful()) {
                $data = $response->json();
                $status = $data['transaction']['status'] ?? $data['order']['status'] ?? null;
                if ($status) {
                    return strtoupper($status);
                }
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('DOKU status check exception.', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Generate HMAC-SHA256 signature for DOKU REST API authentication.
     */
    protected function generateSignature(string $requestId, string $dateTime, string $targetPath, string $body): string
    {
        $digest = base64_encode(hash('sha256', $body, true));
        
        $signatureComponent = "Client-Id:" . $this->clientId . "\n" .
                             "Request-Id:" . $requestId . "\n" .
                             "Request-Timestamp:" . $dateTime . "\n" .
                             "Request-Target:" . $targetPath . "\n" .
                             "Digest:" . $digest;

        return base64_encode(hash_hmac('sha256', $signatureComponent, $this->secretKey, true));
    }
}
