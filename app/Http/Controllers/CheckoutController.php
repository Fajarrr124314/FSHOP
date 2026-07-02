<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Render the simulated DOKU Payment page.
     */
    public function pay($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', ['orderId' => $order->id]);
        }

        // Generate Doku Payment Session URL and redirect away
        try {
            $doku = new DokuService();
            $payUrl = $doku->getCheckoutUrl($order);

            // If it returned a real Doku checkout session URL, redirect immediately
            if ($payUrl && (str_contains($payUrl, 'doku.com') || str_contains($payUrl, 'sandbox.doku'))) {
                return redirect()->away($payUrl);
            }
        } catch (\Exception $e) {
            \Log::error('Doku Pay page API error: ' . $e->getMessage());
        }

        return view('checkout.doku_mock', compact('order'));
    }

    /**
     * Render the success order confirmation page.
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }

    /**
     * Handle webhook simulation / notifications.
     */
    public function webhook(Request $request)
    {
        // Simple notification validator (DOKU webhook payload mock)
        $invoiceNumber = $request->input('order.invoice_number') ?? $request->input('invoice_number');
        $status = $request->input('transaction.status') ?? $request->input('status');

        if ($invoiceNumber) {
            $order = Order::find($invoiceNumber);
            if ($order && ($status === 'SUCCESS' || $status === 'paid')) {
                $order->update(['payment_status' => 'paid']);
                return response()->json(['message' => 'Payment recorded successfully'], 200);
            }
        }

        return response()->json(['message' => 'Invalid transaction data'], 400);
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

        // Read customer details from cart items if present
        $customerName = auth()->check() ? auth()->user()->name : 'Guest Customer';
        $customerPhone = '0895806317711'; // fallback

        foreach ($items as $item) {
            if (!empty($item['customer_name'])) {
                $customerName = $item['customer_name'];
            }
            if (!empty($item['customer_phone'])) {
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
