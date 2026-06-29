<?php

namespace App\Livewire\Topup;

use Livewire\Component;

class TopupList extends Component
{
    public $activeTab = 'all';
    public $selectedGame = null;
    public $selectedPackage = null;
    public $userId = '';
    public $zoneId = '';

    public function selectGame($gameId)
    {
        $games = $this->getGames();
        foreach ($games as $game) {
            if ($game['id'] === $gameId) {
                $this->selectedGame = $game;
                $this->selectedPackage = $game['packages'][0] ?? null;
                $this->userId = '';
                $this->zoneId = '';
                break;
            }
        }
    }

    public function selectPackage($packageId)
    {
        if (!$this->selectedGame) return;
        foreach ($this->selectedGame['packages'] as $pkg) {
            if ($pkg['id'] === $packageId) {
                $this->selectedPackage = $pkg;
                break;
            }
        }
    }

    public function closeGameModal()
    {
        $this->selectedGame = null;
        $this->selectedPackage = null;
    }

    public function checkoutWa()
    {
        if (!$this->selectedGame || !$this->selectedPackage) return;

        $gameName = $this->selectedGame['title'];
        $pkgName = $this->selectedPackage['name'];
        $pkgPrice = $this->selectedPackage['price'];

        $idInfo = "User ID: " . ($this->userId ?: '-');
        if ($this->selectedGame['has_zone']) {
            $idInfo .= " (Zone " . ($this->zoneId ?: '-') . ")";
        }

        $text = "Halo Admin FSHOP! 🎮 Saya ingin Top-Up Game / PPOB:\n\n"
              . "• *Layanan*: {$gameName}\n"
              . "• *Paket*: {$pkgName}\n"
              . "• *{$idInfo}*\n"
              . "• *Total Harga*: {$pkgPrice}\n\n"
              . "Mohon info rekening / QRIS untuk pembayarannya ya min. Terima kasih!";

        $encodedText = urlencode($text);
        $waUrl = "https://wa.me/62895806317711?text={$encodedText}";

        $this->dispatch('open-url', url: $waUrl);
    }

    public function getGames()
    {
        return [
            [
                'id' => 'mlbb',
                'category' => 'mobile',
                'title' => 'Mobile Legends',
                'publisher' => 'Moonton',
                'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=600&q=80',
                'badge' => 'POPULAR',
                'has_zone' => true,
                'zone_placeholder' => 'Zone ID (4-5 Digit)',
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
                'id' => 'freefire',
                'category' => 'mobile',
                'title' => 'Free Fire',
                'publisher' => 'Garena',
                'image' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&w=600&q=80',
                'badge' => 'HOT',
                'has_zone' => false,
                'zone_placeholder' => '',
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
                'id' => 'pubgm',
                'category' => 'mobile',
                'title' => 'PUBG Mobile',
                'publisher' => 'Tencent Games',
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PROMO',
                'has_zone' => false,
                'zone_placeholder' => '',
                'packages' => [
                    ['id' => 'pubg-60', 'name' => '60 UC', 'price' => 'Rp 14.500', 'original' => 'Rp 17.000'],
                    ['id' => 'pubg-325', 'name' => '325 UC', 'price' => 'Rp 72.000', 'original' => 'Rp 80.000'],
                    ['id' => 'pubg-660', 'name' => '660 UC', 'price' => 'Rp 143.000', 'original' => 'Rp 160.000'],
                    ['id' => 'pubg-1800', 'name' => '1800 UC', 'price' => 'Rp 350.000', 'original' => 'Rp 390.000']
                ]
            ],
            [
                'id' => 'valorant',
                'category' => 'pc',
                'title' => 'Valorant',
                'publisher' => 'Riot Games',
                'image' => 'https://images.unsplash.com/photo-1560253023-3ec5d502959f?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PC GAMING',
                'has_zone' => false,
                'zone_placeholder' => 'Riot ID + Tagline (#SEA)',
                'packages' => [
                    ['id' => 'val-475', 'name' => '475 VP', 'price' => 'Rp 55.000', 'original' => 'Rp 60.000'],
                    ['id' => 'val-1000', 'name' => '1000 VP', 'price' => 'Rp 110.000', 'original' => 'Rp 120.000'],
                    ['id' => 'val-2050', 'name' => '2050 VP', 'price' => 'Rp 220.000', 'original' => 'Rp 240.000'],
                    ['id' => 'val-3650', 'name' => '3650 VP', 'price' => 'Rp 380.000', 'original' => 'Rp 410.000']
                ]
            ],
            [
                'id' => 'genshin',
                'category' => 'mobile',
                'title' => 'Genshin Impact',
                'publisher' => 'HoYoverse',
                'image' => 'https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?auto=format&fit=crop&w=600&q=80',
                'badge' => 'BEST SELLER',
                'has_zone' => true,
                'zone_placeholder' => 'Server (Asia/America/Europe)',
                'packages' => [
                    ['id' => 'gi-welkin', 'name' => 'Blessing of the Welkin Moon', 'price' => 'Rp 68.000', 'original' => 'Rp 79.000'],
                    ['id' => 'gi-60', 'name' => '60 Genesis Crystals', 'price' => 'Rp 14.000', 'original' => 'Rp 16.000'],
                    ['id' => 'gi-300', 'name' => '300+30 Genesis Crystals', 'price' => 'Rp 68.000', 'original' => 'Rp 79.000'],
                    ['id' => 'gi-980', 'name' => '980+110 Genesis Crystals', 'price' => 'Rp 210.000', 'original' => 'Rp 239.000']
                ]
            ],
            [
                'id' => 'pln',
                'category' => 'ppob',
                'title' => 'Token PLN / Listrik',
                'publisher' => 'PT PLN (Persero)',
                'image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PPOB 24H',
                'has_zone' => false,
                'zone_placeholder' => 'ID Pelanggan / No Meter',
                'packages' => [
                    ['id' => 'pln-20', 'name' => 'Token PLN Rp 20.000', 'price' => 'Rp 20.500', 'original' => 'Rp 22.000'],
                    ['id' => 'pln-50', 'name' => 'Token PLN Rp 50.000', 'price' => 'Rp 50.500', 'original' => 'Rp 52.000'],
                    ['id' => 'pln-100', 'name' => 'Token PLN Rp 100.000', 'price' => 'Rp 100.500', 'original' => 'Rp 102.000'],
                    ['id' => 'pln-200', 'name' => 'Token PLN Rp 200.000', 'price' => 'Rp 200.500', 'original' => 'Rp 203.000']
                ]
            ],
            [
                'id' => 'pulsa',
                'category' => 'ppob',
                'title' => 'Pulsa & Paket Data',
                'publisher' => 'All Operator',
                'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80',
                'badge' => 'INSTANT',
                'has_zone' => false,
                'zone_placeholder' => 'Nomor HP (Telkomsel/Indosat/XL/Axis/Tri)',
                'packages' => [
                    ['id' => 'pulsa-10', 'name' => 'Pulsa Regular 10.000', 'price' => 'Rp 10.800', 'original' => 'Rp 12.000'],
                    ['id' => 'pulsa-25', 'name' => 'Pulsa Regular 25.000', 'price' => 'Rp 25.500', 'original' => 'Rp 27.000'],
                    ['id' => 'pulsa-50', 'name' => 'Pulsa Regular 50.000', 'price' => 'Rp 50.300', 'original' => 'Rp 52.000'],
                    ['id' => 'pulsa-100', 'name' => 'Pulsa Regular 100.000', 'price' => 'Rp 99.500', 'original' => 'Rp 102.000']
                ]
            ]
        ];
    }

    public function render()
    {
        $allGames = $this->getGames();
        $filtered = array_filter($allGames, function($g) {
            if ($this->activeTab === 'all') return true;
            return $g['category'] === $this->activeTab;
        });

        return view('livewire.topup.topup-list', [
            'games' => $filtered
        ]);
    }
}
