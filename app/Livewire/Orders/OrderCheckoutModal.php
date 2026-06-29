<?php

namespace App\Livewire\Orders;

use Livewire\Component;

class OrderCheckoutModal extends Component
{
    public $isOpen = false;
    public $serviceId = '';
    public $serviceTitle = '';
    public $customerName = '';
    public $customerPhone = '';
    public $deadline = 'Santai (3-5 Hari)';
    public $notes = '';

    protected $listeners = ['openOrderCheckout' => 'showCheckout'];

    public function showCheckout($serviceId, $serviceTitle)
    {
        $this->serviceId = $serviceId;
        $this->serviceTitle = $serviceTitle;
        $this->isOpen = true;
    }

    public function closeCheckout()
    {
        $this->isOpen = false;
    }

    public function processWhatsAppOrder()
    {
        $adminPhone = '62895806317711';
        $message = "*HALO FSHOP DIGITAL AGENCY!* 🚀\n\n";
        $message .= "Saya ingin memesan layanan digital berikut:\n";
        $message .= "📌 *Layanan:* " . $this->serviceTitle . "\n";
        $message .= "👤 *Nama:* " . ($this->customerName ?: '-') . "\n";
        $message .= "📱 *No. WA:* " . ($this->customerPhone ?: '-') . "\n";
        $message .= "⏱️ *Tenggat Waktu:* " . $this->deadline . "\n";
        $message .= "📝 *Catatan Detail:* " . ($this->notes ?: 'Tidak ada catatan khusus') . "\n\n";
        $message .= "Mohon informasi total biaya dan estimasi waktu pengerjaan. Terima kasih!";

        $encodedUrl = "https://wa.me/" . $adminPhone . "?text=" . urlencode($message);

        $this->dispatch('openUrlInNewTab', url: $encodedUrl);
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.orders.order-checkout-modal');
    }
}
