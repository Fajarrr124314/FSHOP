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
    public $s_image_file = null; // for custom file upload
    public $s_short_desc = '';
    public $s_price = '';
    public $s_tags = ''; // comma-separated
    public $s_features = ''; // newlines-separated

    // Service edit state
    public $isEditingService = false;
    public $editingServiceId = '';

    // Game form state
    public $g_id = '';
    public $g_category = 'mobile';
    public $g_title = '';
    public $g_publisher = '';
    public $g_image = '';
    public $g_image_file = null; // for custom file upload
    public $g_badge = '';
    public $g_has_zone = false;
    public $g_zone_placeholder = '';

    // Game edit state
    public $isEditingGame = false;
    public $editingGameId = '';

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

    public function checkDokuPayments()
    {
        $pendingOrders = Order::where('payment_status', 'pending')
                             ->where('payment_method', 'doku')
                             ->get();

        if ($pendingOrders->isEmpty()) {
            session()->flash('order_success', "Tidak ada pembayaran pending dengan metode DOKU.");
            return;
        }

        $doku = new \App\Services\DokuService();
        $updatedCount = 0;

        foreach ($pendingOrders as $order) {
            $status = $doku->checkStatus($order->id);
            if ($status && (strtoupper($status) === 'SUCCESS' || $status === 'PAID')) {
                $order->update(['payment_status' => 'paid']);
                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            session()->flash('order_success', "{$updatedCount} transaksi berhasil diverifikasi PAID dari DOKU!");
        } else {
            session()->flash('order_success', "Cek status selesai. Semua transaksi DOKU masih pending.");
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
        $rules = [
            's_id' => 'required|alpha_dash|unique:services,id',
            's_title' => 'required|min:5',
            's_short_desc' => 'required',
            's_price' => 'required',
        ];

        if (!$this->s_image_file) {
            $rules['s_image'] = 'required|url';
        } else {
            $rules['s_image_file'] = 'image|max:2048'; // max 2MB
        }

        $this->validate($rules, [
            's_id.required' => 'ID Slug wajib diisi.',
            's_id.unique' => 'ID Slug sudah digunakan oleh layanan lain.',
            's_image.required' => 'Image URL wajib diisi jika tidak mengunggah file.',
            's_image.url' => 'Image harus berupa URL yang valid.',
            's_image_file.image' => 'File harus berupa gambar.',
        ]);

        if ($this->s_image_file) {
            $path = $this->s_image_file->store('products', 'public');
            $this->s_image = asset('storage/' . $path);
        }

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

        $this->reset(['s_id', 's_title', 's_image', 's_image_file', 's_short_desc', 's_price', 's_tags', 's_features']);
        session()->flash('service_success', 'Layanan jasa baru berhasil ditambahkan!');
    }

    public function editService($id)
    {
        $service = Service::findOrFail($id);
        $this->editingServiceId = $service->id;
        $this->s_id = $service->id;
        $this->s_category = $service->category;
        $this->s_title = $service->title;
        $this->s_image = $service->image;
        $this->s_short_desc = $service->short_desc;
        $this->s_price = $service->price;
        $this->s_tags = is_array($service->tags) ? implode(', ', $service->tags) : '';
        $this->s_features = is_array($service->features) ? implode("\n", $service->features) : '';
        $this->s_image_file = null;
        
        $this->isEditingService = true;
    }

    public function updateService()
    {
        $rules = [
            's_title' => 'required|min:5',
            's_short_desc' => 'required',
            's_price' => 'required',
        ];

        if ($this->s_image_file) {
            $rules['s_image_file'] = 'image|max:2048';
        }

        $this->validate($rules, [
            's_image_file.image' => 'File harus berupa gambar.',
        ]);

        if ($this->s_image_file) {
            $path = $this->s_image_file->store('products', 'public');
            $this->s_image = asset('storage/' . $path);
        }

        $service = Service::findOrFail($this->editingServiceId);
        $tagsArray = array_map('trim', explode(',', $this->s_tags));
        $featuresArray = array_filter(array_map('trim', explode("\n", $this->s_features)));

        $service->update([
            'category' => $this->s_category,
            'title' => $this->s_title,
            'image' => $this->s_image,
            'short_desc' => $this->s_short_desc,
            'price' => $this->s_price,
            'tags' => $tagsArray,
            'features' => $featuresArray,
        ]);

        $this->cancelEditService();
        session()->flash('service_success', 'Layanan Jasa berhasil diperbarui!');
    }

    public function cancelEditService()
    {
        $this->reset(['s_id', 's_title', 's_image', 's_image_file', 's_short_desc', 's_price', 's_tags', 's_features', 'isEditingService', 'editingServiceId']);
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
        $rules = [
            'g_id' => 'required|alpha_dash|unique:games,id',
            'g_title' => 'required|min:3',
            'g_publisher' => 'required',
        ];

        if (!$this->g_image_file) {
            $rules['g_image'] = 'required|url';
        } else {
            $rules['g_image_file'] = 'image|max:2048';
        }

        $this->validate($rules, [
            'g_id.required' => 'ID Slug wajib diisi.',
            'g_id.unique' => 'ID Slug sudah digunakan.',
            'g_image.required' => 'Image URL wajib diisi jika tidak mengunggah file.',
            'g_image.url' => 'Image harus berupa URL valid.',
            'g_image_file.image' => 'File harus berupa gambar.',
        ]);

        if ($this->g_image_file) {
            $path = $this->g_image_file->store('products', 'public');
            $this->g_image = asset('storage/' . $path);
        }

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

        $this->reset(['g_id', 'g_title', 'g_publisher', 'g_image', 'g_image_file', 'g_badge', 'g_has_zone', 'g_zone_placeholder']);
        session()->flash('game_success', 'Produk game/PPOB baru berhasil ditambahkan!');
    }

    public function editGame($id)
    {
        $game = Game::findOrFail($id);
        $this->editingGameId = $game->id;
        $this->g_id = $game->id;
        $this->g_category = $game->category;
        $this->g_title = $game->title;
        $this->g_publisher = $game->publisher;
        $this->g_image = $game->image;
        $this->g_badge = $game->badge ?: '';
        $this->g_has_zone = (bool)$game->has_zone;
        $this->g_zone_placeholder = $game->zone_placeholder ?: '';
        $this->g_image_file = null;

        $this->isEditingGame = true;
    }

    public function updateGame()
    {
        $rules = [
            'g_title' => 'required|min:3',
            'g_publisher' => 'required',
        ];

        if ($this->g_image_file) {
            $rules['g_image_file'] = 'image|max:2048';
        }

        $this->validate($rules, [
            'g_image_file.image' => 'File harus berupa gambar.',
        ]);

        if ($this->g_image_file) {
            $path = $this->g_image_file->store('products', 'public');
            $this->g_image = asset('storage/' . $path);
        }

        $game = Game::findOrFail($this->editingGameId);
        $game->update([
            'category' => $this->g_category,
            'title' => $this->g_title,
            'publisher' => $this->g_publisher,
            'image' => $this->g_image,
            'badge' => $this->g_badge ?: null,
            'has_zone' => $this->g_has_zone,
            'zone_placeholder' => $this->g_has_zone ? $this->g_zone_placeholder : null,
        ]);

        $this->cancelEditGame();
        session()->flash('game_success', 'Produk game berhasil diperbarui!');
    }

    public function cancelEditGame()
    {
        $this->reset(['g_id', 'g_title', 'g_publisher', 'g_image', 'g_image_file', 'g_badge', 'g_has_zone', 'g_zone_placeholder', 'isEditingGame', 'editingGameId']);
    }

    public function deleteGame($gameId)
    {
        $game = Game::find($gameId);
        if ($game) {
            $game->delete(); // cascades package deletions via db structure
            session()->flash('game_success', 'Produk game & semua paket nominalnya berhasil dihapus.');
        }
    }

    /* ==========================================
       Nominal Packages Section
       ========================================== */
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
