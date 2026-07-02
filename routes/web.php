<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Services\ServicesList;
use App\Livewire\Topup\TopupList;
use App\Livewire\CvGenerator\FreeCvMaker;
use App\Livewire\CoverLetter\CoverLetterGenerator;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/services', ServicesList::class)->name('services');
Route::get('/topup', TopupList::class)->name('topup');
Route::get('/cv-maker', FreeCvMaker::class)->name('cv-maker');
Route::get('/cover-letter', CoverLetterGenerator::class)->name('cover-letter');

// Google Authentication Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Simulated Auth Routes for local development
Route::get('/auth/mock', [AuthController::class, 'showMockLogin'])->name('auth.mock-view');
Route::get('/auth/mock-login/{profile}', [AuthController::class, 'handleMockLogin'])->name('auth.mock-login');

// Checkout & Payments Routes
Route::get('/checkout/pay/{orderId}', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/checkout/doku-webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');
Route::post('/checkout/process-cart', [CheckoutController::class, 'processCart'])->name('checkout.process-cart');
Route::post('/checkout/process-direct-service', [CheckoutController::class, 'processDirectService'])->name('checkout.process-direct-service');
Route::post('/checkout/process-direct-topup', [CheckoutController::class, 'processDirectTopup'])->name('checkout.process-direct-topup');

// Admin Protected Dashboard
Route::get('/admin', AdminDashboard::class)->middleware(['web', 'admin'])->name('admin.dashboard');

// Session manager for latest order
Route::get('/checkout/clear-order/{orderId}', function($orderId) {
    $pendingIds = session('pending_order_ids', []);
    $pendingIds = array_diff($pendingIds, [$orderId]);
    session(['pending_order_ids' => $pendingIds]);
    if (session('latest_order_id') === $orderId) {
        session()->forget('latest_order_id');
    }
    return redirect()->back();
})->name('checkout.clear-order');


