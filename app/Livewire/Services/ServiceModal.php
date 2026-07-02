<?php

namespace App\Livewire\Services;

use App\Models\Service;
use App\Models\Order;
use App\Services\DokuService;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class ServiceModal extends Component
{
    public $isOpen = false;
    public $service = null;
    
    // Checkout fields
    public $customerName = '';
    public $customerPhone = '';
    public $deadline = 'Santai (3-5 Hari)';
    public $notes = '';

    protected $listeners = ['showServiceModal' => 'openModal'];

    public function mount()
    {
        if (auth()->check()) {
            $this->customerName = auth()->user()->name;
        }
    }

    #[On('showServiceModal')]
    public function openModal($serviceId)
    {
        $this->service = Service::find($serviceId);
        
        if (auth()->check()) {
            $this->customerName = auth()->user()->name;
        } else {
            $this->customerName = '';
        }
        $this->customerPhone = '';
        $this->deadline = 'Santai (3-5 Hari)';
        $this->notes = '';
        
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatch('closeServiceModal');
    }

    /**
     * Add this service to the global shopping cart session.
     */
    public function addToCart()
    {
        if (!$this->service) return;

        $this->validateForm();

        $cartItem = [
            'id' => $this->service->id,
            'type' => 'service',
            'title' => $this->service->title,
            'image' => $this->service->image,
            'price_raw' => $this->getNumericPrice($this->service->price),
            'price' => $this->service->price,
            'meta' => [
                'prioritas' => $this->deadline,
                'catatan' => $this->notes ?: '-'
            ],
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone
        ];

        $this->dispatch('addToCart', item: $cartItem);
        $this->closeModal();
    }

    /**
     * Checkout directly via DOKU gateway.
     */
    public function processDokuOrder()
    {
        if (!$this->service) return;

        $this->validateForm();

        $priceRaw = $this->getNumericPrice($this->service->price);
        $orderId = 'FSHOP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'id' => $orderId,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'type' => 'service',
            'items' => [
                [
                    'id' => $this->service->id,
                    'type' => 'service',
                    'title' => $this->service->title,
                    'image' => $this->service->image,
                    'price_raw' => $priceRaw,
                    'price' => $this->service->price,
                    'qty' => 1,
                    'meta' => [
                        'prioritas' => $this->deadline,
                        'catatan' => $this->notes ?: '-'
                    ]
                ]
            ],
            'total_price' => $priceRaw,
            'payment_status' => 'pending',
            'payment_method' => 'doku'
        ]);

        $this->closeModal();

        $this->dispatch('openPaymentUrl', url: route('checkout.pay', ['orderId' => $orderId]));
    }


    protected function validateForm()
    {
        $this->validate([
            'customerName' => 'required|min:3',
            'customerPhone' => 'required|numeric|digits_between:9,14',
        ], [
            'customerName.required' => 'Nama lengkap wajib diisi.',
            'customerPhone.required' => 'Nomor WhatsApp wajib diisi.',
            'customerPhone.numeric' => 'Nomor WhatsApp harus berupa angka.',
        ]);
    }

    protected function getNumericPrice($priceStr)
    {
        // Extract numbers from e.g. "Mulai Rp 350.000" or "Rp 350.000"
        $clean = preg_replace('/[^0-9]/', '', $priceStr);
        return (int)$clean ?: 0;
    }

    public function render()
    {
        return view('livewire.services.service-modal');
    }
}
