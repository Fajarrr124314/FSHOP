<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Service;
use App\Models\Game;
use App\Models\GamePackage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{
    use WithFileUploads;

    public $activeTab = 'orders'; // orders, services, games

    // Service form state
    public $s_id = '';
    public $s_category = 'web';
    public $s_title = '';
    public $s_image = '';
    public $s_short_desc = '';
    public $s_price = '';
    public $s_tags = ''; // comma-separated
    public $s_features = ''; // newlines-separated

    // Game form state
    public $g_id = '';
    public $g_category = 'mobile';
    public $g_title = '';
    public $g_publisher = '';
    public $g_image = '';
    public $g_badge = '';
    public $g_has_zone = false;
    public $g_zone_placeholder = '';

    // Package form state
    public $pkg_game_id = '';
    public $pkg_id = '';
    public $pkg_name = '';
    public $pkg_price = '';
    public $pkg_original = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    /* ==========================================
       Orders Section
       ========================================== */
    public function togglePaymentStatus($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $newStatus = $order->payment_status === 'paid' ? 'pending' : 'paid';
            $order->update(['payment_status' => $newStatus]);
            session()->flash('order_success', "Status pembayaran invoice {$orderId} diubah menjadi " . strtoupper($newStatus));
        }
    }

    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->delete();
            session()->flash('order_success', "Pesanan {$orderId} berhasil dihapus.");
        }
    }

    /* ==========================================
       Services Section
       ========================================== */
    public function addService()
    {
        $this->validate([
            's_id' => 'required|alpha_dash|unique:services,id',
            's_title' => 'required|min:5',
            's_image' => 'required|url',
            's_short_desc' => 'required',
            's_price' => 'required',
        ], [
            's_id.required' => 'ID Slug wajib diisi.',
            's_id.unique' => 'ID Slug sudah digunakan oleh layanan lain.',
            's_image.url' => 'Image harus berupa URL yang valid (e.g. Unsplash).',
        ]);

        $tagsArray = array_map('trim', explode(',', $this->s_tags));
        $featuresArray = array_filter(array_map('trim', explode("\n", $this->s_features)));

        Service::create([
            'id' => $this->s_id,
            'category' => $this->s_category,
            'title' => $this->s_title,
            'image' => $this->s_image,
            'short_desc' => $this->s_short_desc,
            'price' => $this->s_price,
            'tags' => $tagsArray,
            'features' => $featuresArray,
        ]);

        // Reset form
        $this->reset(['s_id', 's_title', 's_image', 's_short_desc', 's_price', 's_tags', 's_features']);
        session()->flash('service_success', 'Layanan jasa baru berhasil ditambahkan!');
    }

    public function deleteService($serviceId)
    {
        $service = Service::find($serviceId);
        if ($service) {
            $service->delete();
            session()->flash('service_success', 'Layanan Jasa berhasil dihapus.');
        }
    }

    /* ==========================================
       Games & Packages Section
       ========================================== */
    public function addGame()
    {
        $this->validate([
            'g_id' => 'required|alpha_dash|unique:games,id',
            'g_title' => 'required|min:3',
            'g_publisher' => 'required',
            'g_image' => 'required|url',
        ], [
            'g_id.required' => 'ID Slug wajib diisi.',
            'g_id.unique' => 'ID Slug sudah digunakan.',
            'g_image.url' => 'Image harus berupa URL valid.',
        ]);

        Game::create([
            'id' => $this->g_id,
            'category' => $this->g_category,
            'title' => $this->g_title,
            'publisher' => $this->g_publisher,
            'image' => $this->g_image,
            'badge' => $this->g_badge ?: null,
            'has_zone' => $this->g_has_zone,
            'zone_placeholder' => $this->g_has_zone ? $this->g_zone_placeholder : null,
        ]);

        $this->reset(['g_id', 'g_title', 'g_publisher', 'g_image', 'g_badge', 'g_has_zone', 'g_zone_placeholder']);
        session()->flash('game_success', 'Produk game/PPOB baru berhasil ditambahkan!');
    }

    public function deleteGame($gameId)
    {
        $game = Game::find($gameId);
        if ($game) {
            $game->delete(); // cascades package deletions via db structure
            session()->flash('game_success', 'Produk game & semua paket nominalnya berhasil dihapus.');
        }
    }

    public function addPackage()
    {
        $this->validate([
            'pkg_game_id' => 'required|exists:games,id',
            'pkg_id' => 'required|alpha_dash|unique:game_packages,id',
            'pkg_name' => 'required',
            'pkg_price' => 'required',
        ], [
            'pkg_id.required' => 'ID Nominal wajib diisi.',
            'pkg_id.unique' => 'ID Nominal ini sudah digunakan.',
        ]);

        GamePackage::create([
            'id' => $this->pkg_id,
            'game_id' => $this->pkg_game_id,
            'name' => $this->pkg_name,
            'price' => $this->pkg_price,
            'original' => $this->pkg_original ?: null,
        ]);

        $this->reset(['pkg_id', 'pkg_name', 'pkg_price', 'pkg_original']);
        session()->flash('pkg_success', 'Nominal paket baru berhasil ditambahkan!');
    }

    public function deletePackage($packageId)
    {
        $pkg = GamePackage::find($packageId);
        if ($pkg) {
            $pkg->delete();
            session()->flash('pkg_success', 'Nominal paket berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'orders' => Order::orderBy('created_at', 'desc')->get(),
            'services' => Service::all(),
            'games' => Game::with('packages')->get(),
        ])->layout('components.layouts.app'); // Extend standard layout
    }
}
