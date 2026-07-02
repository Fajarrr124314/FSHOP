<?php

namespace App\Livewire\Widgets;

use Livewire\Component;

class AstroBotChat extends Component
{
    public $isOpen = false;
    public $userMessage = '';
    public $messages = [];

    public function mount()
    {
        $this->messages = [
            ['sender' => 'bot', 'text' => 'Halo 🧑‍🚀 Saya AstroBot asisten virtual FSHOP! Ada yang bisa saya bantu terkait layanan web, mobile, poster, atau portofolio?']
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage($customQuery = null)
    {
        $text = $customQuery ?: $this->userMessage;
        if (empty(trim($text))) return;

        $this->messages[] = ['sender' => 'user', 'text' => $text];
        $this->userMessage = '';

        // Generate Bot Reply
        $reply = $this->getBotResponse($text);
        $this->messages[] = ['sender' => 'bot', 'text' => $reply];
    }

    private function getBotResponse($query)
    {
        $q = strtolower($query);
        if (str_contains($q, 'web') || str_contains($q, 'website')) {
            return 'Jasa Pembuatan Web FSHOP mulai dari Rp 350.000! Menggunakan framework Laravel / Livewire yang super cepat, SEO friendly, dan tampilan glassmorphic modern.';
        } elseif (str_contains($q, 'poster') || str_contains($q, 'banner') || str_contains($q, 'desain')) {
            return 'Desain Poster & Banner mulai dari Rp 35.000! File HD siap cetak (PDF/PNG/PSD) dengan pengerjaan kilat 1x24 jam.';
        } elseif (str_contains($q, 'portofolio') || str_contains($q, 'karya') || str_contains($q, 'contoh')) {
            return 'Anda bisa melihat Portofolio Showcase kami langsung di halaman utama (Landing Page) untuk mengintip hasil karya digital terbaik yang telah selesai kami kerjakan!';
        } elseif (str_contains($q, 'cv') || str_contains($q, 'gratis')) {
            return 'Anda bisa menggunakan fitur CV Generator Gratis kami langsung di menu "CV Gratis" pada header atas website ini!';
        } elseif (str_contains($q, 'kontak') || str_contains($q, 'wa') || str_contains($q, 'pesan')) {
            return 'Silakan hubungi WhatsApp resmi kami di 0895806317711 atau klik tombol WhatsApp di pojok kanan bawah.';
        } else {
            return 'Terima kasih telah bertanya! Anda bisa langsung konsultasi gratis via WhatsApp Admin FSHOP di 0895806317711 untuk respon cepat.';
        }
    }

    public function render()
    {
        return view('livewire.widgets.astro-bot-chat');
    }
}
