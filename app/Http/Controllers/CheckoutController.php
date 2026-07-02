<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Redirect to the official DOKU Payment page.
     */
    public function pay($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', ['orderId' => $order->id]);
        }

        // Generate official DOKU Payment page URL and redirect (cached for 1 hour to prevent regeneration)
        try {
            $doku = new DokuService();
            $payUrl = \Illuminate\Support\Facades\Cache::remember("order_doku_url_{$order->id}", 3600, function() use ($doku, $order) {
                return $doku->getCheckoutUrl($order);
            });

            if ($payUrl) {
                return redirect()->away($payUrl);
            }
        } catch (\Exception $e) {
            \Log::error('Doku Pay page API error: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('error', 'Gagal terhubung ke DOKU Gateway.');
    }

    /**
     * Render the success order confirmation page.
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        $pendingIds = session('pending_order_ids', []);
        if (!in_array($order->id, $pendingIds)) {
            $pendingIds[] = $order->id;
            session(['pending_order_ids' => $pendingIds]);
        }
        session(['latest_order_id' => $order->id]);
        return redirect()->route('home');
    }

    /**
     * Handle official webhook notifications from DOKU.
     */
    public function webhook(Request $request)
    {
        $clientId = $request->header('Client-Id');
        $requestId = $request->header('Request-Id');
        $requestTimestamp = $request->header('Request-Timestamp');
        $receivedSignature = $request->header('Signature');
        $bypassSignature = env('DOKU_BYPASS_SIGNATURE', false);

        // Fallback: If Doku headers are missing, treat as simulated mock client checkout
        if ($bypassSignature || !$clientId || !$receivedSignature) {
            $invoiceNumber = $request->input('order.invoice_number') ?? $request->input('invoice_number');
            $status = $request->input('transaction.status') ?? $request->input('status');

            if ($invoiceNumber) {
                $order = Order::find($invoiceNumber);
                if ($order && (strtoupper($status) === 'SUCCESS' || $status === 'paid')) {
                    $order->update(['payment_status' => 'paid']);
                    return response()->json(['message' => 'Payment recorded successfully (Simulation)'], 200);
                }
            }
            return response()->json(['message' => 'Order not found or invalid status (Simulation)'], 400);
        }
        
        $requestBody = $request->getContent();
        $secretKey = env('DOKU_SECRET_KEY');
        
        $digest = base64_encode(hash('sha256', $requestBody, true));
        $targetPath = $request->getPathInfo(); // e.g. /checkout/doku-webhook
        
        $signatureComponent = "Client-Id:" . $clientId . "\n" .
                             "Request-Id:" . $requestId . "\n" .
                             "Request-Timestamp:" . $requestTimestamp . "\n" .
                             "Request-Target:" . $targetPath . "\n" .
                             "Digest:" . $digest;
                             
        $computedSignature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $signatureComponent, $secretKey, true));

        if (hash_equals($computedSignature, (string)$receivedSignature)) {
            $invoiceNumber = $request->input('order.invoice_number') ?? $request->input('invoice_number');
            $status = $request->input('transaction.status') ?? $request->input('status');

            if ($invoiceNumber) {
                $order = Order::find($invoiceNumber);
                if ($order && (strtoupper($status) === 'SUCCESS' || $status === 'paid')) {
                    $order->update(['payment_status' => 'paid']);
                    return response()->json(['message' => 'Payment recorded successfully'], 200);
                }
            }
            return response()->json(['message' => 'Order not found or invalid status'], 400);
        }

        \Log::warning('DOKU Webhook signature mismatch', [
            'received' => $receivedSignature,
            'computed' => $computedSignature
        ]);

        return response()->json(['message' => 'Invalid webhook signature'], 401);
    }

    /**
     * Process cart checkout client-side submission.
     */
    public function processCart(Request $request)
    {
        $items = $request->input('items', []);
        if (empty($items)) {
            return response()->json(['message' => 'Keranjang belanja Anda kosong!'], 400);
        }

        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += ((int)$item['price_raw'] * ($item['qty'] ?? 1));
        }

        $orderId = 'FSHOP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Read customer details from request or cart items
        $customerName = auth()->check() ? auth()->user()->name : 'Guest Customer';
        $customerPhone = $request->input('customer_phone') ?: '0895806317711';

        foreach ($items as $item) {
            if (!empty($item['customer_name'])) {
                $customerName = $item['customer_name'];
            }
            if (!empty($item['customer_phone']) && empty($request->input('customer_phone'))) {
                $customerPhone = $item['customer_phone'];
            }
        }

        // Create database order
        $order = Order::create([
            'id' => $orderId,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'type' => 'cart',
            'items' => $items,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'payment_method' => 'doku',
        ]);

        // Return instant pay loading route (takes 0ms network lag for external API)
        return response()->json(['url' => route('checkout.pay', ['orderId' => $orderId])]);
    }

    /**
     * Process direct service checkout client-side submission.
     */
    public function processDirectService(Request $request)
    {
        $serviceId = $request->input('service_id');
        $customerName = $request->input('customer_name');
        $customerPhone = $request->input('customer_phone');
        $deadline = $request->input('deadline');
        $notes = $request->input('notes');

        $service = \App\Models\Service::find($serviceId);
        if (!$service) {
            return response()->json(['message' => 'Layanan tidak ditemukan!'], 404);
        }

        $priceRaw = (int)preg_replace('/[^0-9]/', '', $service->price);
        $orderId = 'FSHOP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Create database order
        $order = Order::create([
            'id' => $orderId,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'type' => 'service',
            'items' => [
                [
                    'id' => $service->id,
                    'type' => 'service',
                    'title' => $service->title,
                    'image' => $service->image,
                    'price_raw' => $priceRaw,
                    'price' => $service->price,
                    'qty' => 1,
                    'meta' => [
                        'prioritas' => $deadline,
                        'catatan' => $notes ?: '-'
                    ]
                ]
            ],
            'total_price' => $priceRaw,
            'payment_status' => 'pending',
            'payment_method' => 'doku'
        ]);

        return response()->json(['url' => route('checkout.pay', ['orderId' => $orderId])]);
    }

    /**
     * Process direct topup checkout client-side submission.
     */
    public function processDirectTopup(Request $request)
    {
        $packageId = $request->input('package_id');
        $userId = $request->input('user_id');
        $zoneId = $request->input('zone_id');
        $nickname = $request->input('nickname');

        $package = \App\Models\GamePackage::find($packageId);
        if (!$package) {
            return response()->json(['message' => 'Paket topup tidak ditemukan!'], 404);
        }

        $game = $package->game;
        if (!$game) {
            return response()->json(['message' => 'Game tidak ditemukan!'], 404);
        }

        $priceRaw = (int)preg_replace('/[^0-9]/', '', $package->price);
        $orderId = 'FSHOP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $idInfo = "User ID: " . $userId;
        if ($zoneId) {
            $idInfo .= " (Zone " . $zoneId . ")";
        }
        $idInfo .= " | Nickname: " . $nickname;

        // Create database order
        $order = Order::create([
            'id' => $orderId,
            'customer_name' => auth()->check() ? auth()->user()->name : 'Guest Customer',
            'customer_phone' => '0895806317711', // default fallback
            'type' => 'topup',
            'items' => [
                [
                    'id' => $package->id,
                    'type' => 'topup',
                    'title' => $game->title,
                    'package_name' => $package->name,
                    'image' => $game->image,
                    'price_raw' => $priceRaw,
                    'price' => $package->price,
                    'qty' => 1,
                    'meta' => [
                        'game_account' => $idInfo
                    ]
                ]
            ],
            'total_price' => $priceRaw,
            'payment_status' => 'pending',
            'payment_method' => 'doku'
        ]);

        return response()->json(['url' => route('checkout.pay', ['orderId' => $orderId])]);
    }
}
