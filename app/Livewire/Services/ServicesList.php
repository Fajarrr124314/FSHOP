<?php

namespace App\Livewire\Services;

use Livewire\Component;

class ServicesList extends Component
{
    public $activeFilter = 'all';
    public $selectedService = null;

    protected $listeners = ['closeServiceModal' => 'resetSelectedService'];

    public function setFilter($category)
    {
        $this->activeFilter = $category;
    }

    public function openDetail($serviceId)
    {
        $services = $this->getServices();
        foreach ($services as $service) {
            if ($service['id'] === $serviceId) {
                $this->selectedService = $service;
                $this->dispatch('showServiceModal', service: $service);
                break;
            }
        }
    }

    public function resetSelectedService()
    {
        $this->selectedService = null;
    }

    public function getServices()
    {
        return [
            [
                'id' => 'web-dev',
                'category' => 'web',
                'title' => 'Jasa Pembuatan Web',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Website custom responsive (SaaS, E-commerce, Portal Berita, Company Profile) dengan backend modern & cepat.',
                'price' => 'Mulai Rp 350.000',
                'tags' => ['Laravel', 'Livewire', 'Vue/React', 'SEO Ready', 'Fast Loading'],
                'features' => [
                    'Desain UI/UX Glassmorphism Premium',
                    'Integrasi Database & RESTful API',
                    'Gratis Domain & Hosting Setup (Opsional)',
                    'Optimasi Kecepatan & SEO Google',
                    'Dukungan Garansi Maintenance 30 Hari'
                ]
            ],
            [
                'id' => 'mobile-app',
                'category' => 'mobile',
                'title' => 'Aplikasi Mobile (Android & iOS)',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Pengembangan aplikasi smartphone native/cross-platform dengan performa tinggi & UI modern.',
                'price' => 'Mulai Rp 500.000',
                'tags' => ['Flutter', 'React Native', 'Android Studio', 'Push Notif'],
                'features' => [
                    'Multiplatform (Android APK/AAB & iOS AppStore)',
                    'Desain Antarmuka Sleek & Intuitive',
                    'Integrasi Payment Gateway & Firebase Live Database',
                    'Full Source Code & Dokumentasi Teratur'
                ]
            ],
            [
                'id' => 'landing-portfolio',
                'category' => 'web',
                'title' => 'Landing Page / Portfolio',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Halaman promosi produk / CV personal yang memukau dengan konversi tinggi & animasi interaktif.',
                'price' => 'Mulai Rp 150.000',
                'tags' => ['High Conversion', 'Space Animation', 'WhatsApp Link'],
                'features' => [
                    'Animasi Particle Space & Smooth Scroll',
                    'Sangat Ringan (Load Time under 1s)',
                    'Form Ordering Direct WhatsApp Interaktif',
                    'Integrasi Social Media & Google Maps'
                ]
            ],
            [
                'id' => 'poster-design',
                'category' => 'design',
                'title' => 'Jasa Design Poster',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Poster promosi event, seminar, flyer feeds Instagram dengan estetika modern & eye-catching.',
                'price' => 'Mulai Rp 35.000',
                'tags' => ['HD Export', 'Canva/Photoshop', 'Revisi Sepuasnya'],
                'features' => [
                    'File Output HD Print-Ready (PDF, PNG, JPG)',
                    'Source File editable (PSD / AI / Canva)',
                    'Pengerjaan Kilat (1-24 Jam)',
                    'Bebas Konsultasi Konsep Warna & Typo'
                ]
            ],
            [
                'id' => 'banner-design',
                'category' => 'design',
                'title' => 'Jasa Poster Banner',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Banner Spanduk outdoor/indoor, header marketplace, maupun digital web banner promosi.',
                'price' => 'Mulai Rp 50.000',
                'tags' => ['Cetak High-Res', 'Spanduk Outdoor', 'Custom Dimension'],
                'features' => [
                    'Custom Dimensi (Ukuran Meteran / Pixel)',
                    'Warna Tajam CMYK untuk Hasil Cetak Maksimal',
                    'Vektor & Ilustrasi Custom Sleek',
                    'Garansi Revisi Sampai Puas'
                ]
            ],
            [
                'id' => 'assignment-task',
                'category' => 'tugas',
                'title' => 'Jasa Tugas & Coding Help',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Bantuan penyelesaian tugas pemrograman (PHP, Python, HTML/CSS, SQL), makalah, & pembuatan laporan.',
                'price' => 'Mulai Rp 25.000',
                'tags' => ['Coding Helper', 'Makalah/Paper', 'Garansi Nilai A'],
                'features' => [
                    'Bantuan Pemrograman (Python, PHP, Java, JS, C++)',
                    'Struktur Database SQL / ERD Design',
                    'Formatting Makalah / Jurnal Bebas Plagiarisme',
                    'Penjelasan Kodingan Sampai Paham (Penjelasan Script)'
                ]
            ],
            [
                'id' => 'ui-ux-design',
                'category' => 'design',
                'title' => 'Jasa Design UI/UX Figma',
                'image' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Perancangan Wireframe, Mockup, dan Prototype interaktif untuk aplikasi web & mobile.',
                'price' => 'Mulai Rp 100.000',
                'tags' => ['Figma Link', 'Interactive Prototype', 'Design System'],
                'features' => [
                    'File Figma Komplit dengan Design System & UI Components',
                    'Clickable Prototype untuk Presentasi',
                    'Autolayout & Responsif Grid System'
                ]
            ]
        ];
    }

    public function render()
    {
        $allServices = $this->getServices();
        $filteredServices = array_filter($allServices, function ($service) {
            if ($this->activeFilter === 'all') return true;
            return $service['category'] === $this->activeFilter;
        });

        return view('livewire.services.services-list', [
            'services' => $filteredServices
        ]);
    }
}
