<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Game;
use App\Models\GamePackage;

class ShopCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Services
        $services = [
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
                'id' => 'portfolio-dev',
                'category' => 'web',
                'title' => 'Jasa Pembuatan Web Portofolio',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80',
                'short_desc' => 'Desain & pembuatan website portofolio pribadi, resume online, atau profile instansi dengan tampilan interaktif modern.',
                'price' => 'Mulai Rp 150.000',
                'tags' => ['ATS Friendly', 'Responsive Design', 'Hosting Gratis'],
                'features' => [
                    'Desain UI Kustom (Figma / Web)',
                    'Integrasi Domain Custom & Hosting Selamanya',
                    'Optimasi SEO Google Search Console',
                    'Kecepatan Load Ultra Cepat (100% Core Web Vitals)'
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

        foreach ($services as $srv) {
            Service::updateOrCreate(['id' => $srv['id']], $srv);
        }

        // Seed Games & PPOB
        $gamesData = [
            [
                'game' => [
                    'id' => 'mlbb',
                    'category' => 'mobile',
                    'title' => 'Mobile Legends',
                    'publisher' => 'Moonton',
                    'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'POPULAR',
                    'has_zone' => true,
                    'zone_placeholder' => 'Zone ID (4-5 Digit)'
                ],
                'packages' => [
                    ['id' => 'ml-wdp', 'name' => 'Weekly Diamond Pass', 'price' => 'Rp 27.500', 'original' => 'Rp 32.000'],
                    ['id' => 'ml-86', 'name' => '86 Diamonds (78+8 Bonus)', 'price' => 'Rp 20.000', 'original' => 'Rp 23.000'],
                    ['id' => 'ml-172', 'name' => '172 Diamonds', 'price' => 'Rp 40.000', 'original' => 'Rp 45.000'],
                    ['id' => 'ml-257', 'name' => '257 Diamonds', 'price' => 'Rp 60.000', 'original' => 'Rp 68.000'],
                    ['id' => 'ml-344', 'name' => '344 Diamonds', 'price' => 'Rp 80.000', 'original' => 'Rp 90.000'],
                    ['id' => 'ml-706', 'name' => '706 Diamonds', 'price' => 'Rp 160.000', 'original' => 'Rp 180.000'],
                    ['id' => 'ml-starlight', 'name' => 'Starlight Member Card', 'price' => 'Rp 135.000', 'original' => 'Rp 150.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'freefire',
                    'category' => 'mobile',
                    'title' => 'Free Fire',
                    'publisher' => 'Garena',
                    'image' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'HOT',
                    'has_zone' => false,
                    'zone_placeholder' => ''
                ],
                'packages' => [
                    ['id' => 'ff-70', 'name' => '70 Diamonds', 'price' => 'Rp 10.000', 'original' => 'Rp 12.000'],
                    ['id' => 'ff-140', 'name' => '140 Diamonds', 'price' => 'Rp 19.500', 'original' => 'Rp 23.000'],
                    ['id' => 'ff-355', 'name' => '355 Diamonds', 'price' => 'Rp 48.000', 'original' => 'Rp 55.000'],
                    ['id' => 'ff-720', 'name' => '720 Diamonds', 'price' => 'Rp 95.000', 'original' => 'Rp 110.000'],
                    ['id' => 'ff-member-w', 'name' => 'Member Mingguan', 'price' => 'Rp 30.000', 'original' => 'Rp 35.000'],
                    ['id' => 'ff-member-m', 'name' => 'Member Bulanan', 'price' => 'Rp 120.000', 'original' => 'Rp 140.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'pubgm',
                    'category' => 'mobile',
                    'title' => 'PUBG Mobile',
                    'publisher' => 'Tencent Games',
                    'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'PROMO',
                    'has_zone' => false,
                    'zone_placeholder' => ''
                ],
                'packages' => [
                    ['id' => 'pubg-60', 'name' => '60 UC', 'price' => 'Rp 14.500', 'original' => 'Rp 17.000'],
                    ['id' => 'pubg-325', 'name' => '325 UC', 'price' => 'Rp 72.000', 'original' => 'Rp 80.000'],
                    ['id' => 'pubg-660', 'name' => '660 UC', 'price' => 'Rp 143.000', 'original' => 'Rp 160.000'],
                    ['id' => 'pubg-1800', 'name' => '1800 UC', 'price' => 'Rp 350.000', 'original' => 'Rp 390.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'valorant',
                    'category' => 'pc',
                    'title' => 'Valorant',
                    'publisher' => 'Riot Games',
                    'image' => 'https://images.unsplash.com/photo-1560253023-3ec5d502959f?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'PC GAMING',
                    'has_zone' => false,
                    'zone_placeholder' => 'Riot ID + Tagline (#SEA)'
                ],
                'packages' => [
                    ['id' => 'val-475', 'name' => '475 VP', 'price' => 'Rp 55.000', 'original' => 'Rp 60.000'],
                    ['id' => 'val-1000', 'name' => '1000 VP', 'price' => 'Rp 110.000', 'original' => 'Rp 120.000'],
                    ['id' => 'val-2050', 'name' => '2050 VP', 'price' => 'Rp 220.000', 'original' => 'Rp 240.000'],
                    ['id' => 'val-3650', 'name' => '3650 VP', 'price' => 'Rp 380.000', 'original' => 'Rp 410.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'genshin',
                    'category' => 'mobile',
                    'title' => 'Genshin Impact',
                    'publisher' => 'HoYoverse',
                    'image' => 'https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'BEST SELLER',
                    'has_zone' => true,
                    'zone_placeholder' => 'Server (Asia/America/Europe)'
                ],
                'packages' => [
                    ['id' => 'gi-welkin', 'name' => 'Blessing of the Welkin Moon', 'price' => 'Rp 68.000', 'original' => 'Rp 79.000'],
                    ['id' => 'gi-60', 'name' => '60 Genesis Crystals', 'price' => 'Rp 14.000', 'original' => 'Rp 16.000'],
                    ['id' => 'gi-300', 'name' => '300+30 Genesis Crystals', 'price' => 'Rp 68.000', 'original' => 'Rp 79.000'],
                    ['id' => 'gi-980', 'name' => '980+110 Genesis Crystals', 'price' => 'Rp 210.000', 'original' => 'Rp 239.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'pln',
                    'category' => 'ppob',
                    'title' => 'Token PLN / Listrik',
                    'publisher' => 'PT PLN (Persero)',
                    'image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'PPOB 24H',
                    'has_zone' => false,
                    'zone_placeholder' => 'ID Pelanggan / No Meter'
                ],
                'packages' => [
                    ['id' => 'pln-20', 'name' => 'Token PLN Rp 20.000', 'price' => 'Rp 20.500', 'original' => 'Rp 22.000'],
                    ['id' => 'pln-50', 'name' => 'Token PLN Rp 50.000', 'price' => 'Rp 50.500', 'original' => 'Rp 52.000'],
                    ['id' => 'pln-100', 'name' => 'Token PLN Rp 100.000', 'price' => 'Rp 100.500', 'original' => 'Rp 102.000'],
                    ['id' => 'pln-200', 'name' => 'Token PLN Rp 200.000', 'price' => 'Rp 200.500', 'original' => 'Rp 203.000']
                ]
            ],
            [
                'game' => [
                    'id' => 'pulsa',
                    'category' => 'ppob',
                    'title' => 'Pulsa & Paket Data',
                    'publisher' => 'All Operator',
                    'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80',
                    'badge' => 'INSTANT',
                    'has_zone' => false,
                    'zone_placeholder' => 'Nomor HP'
                ],
                'packages' => [
                    ['id' => 'pulsa-10', 'name' => 'Pulsa Regular 10.000', 'price' => 'Rp 10.800', 'original' => 'Rp 12.000'],
                    ['id' => 'pulsa-25', 'name' => 'Pulsa Regular 25.000', 'price' => 'Rp 25.500', 'original' => 'Rp 27.000'],
                    ['id' => 'pulsa-50', 'name' => 'Pulsa Regular 50.000', 'price' => 'Rp 50.300', 'original' => 'Rp 52.000'],
                    ['id' => 'pulsa-100', 'name' => 'Pulsa Regular 100.000', 'price' => 'Rp 99.500', 'original' => 'Rp 102.000']
                ]
            ]
        ];

        foreach ($gamesData as $gData) {
            $gameModel = Game::updateOrCreate(['id' => $gData['game']['id']], $gData['game']);
            
            foreach ($gData['packages'] as $pkg) {
                GamePackage::updateOrCreate(
                    ['id' => $pkg['id']],
                    [
                        'game_id' => $gameModel->id,
                        'name' => $pkg['name'],
                        'price' => $pkg['price'],
                        'original' => $pkg['original'] ?? null
                    ]
                );
            }
        }
    }
}
