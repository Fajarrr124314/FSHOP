<div class="admin-dashboard-wrapper" style="padding: 6rem 2rem 4rem; min-height: 90vh;">
    <div class="admin-layout" style="display: flex; gap: 2rem; max-width: 1400px; margin: 0 auto; align-items: flex-start;">
        
        <!-- Sidebar Kiri Mengambang (Floating Sidebar) -->
        <aside class="admin-sidebar glass-card" style="width: 280px; padding: 2rem; position: sticky; top: 100px; flex-shrink: 0; display: flex; flex-direction: column; gap: 2rem; z-index: 10;">
            <div style="text-align: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                <div class="gaming-badge-header" style="margin-bottom: 0.5rem; justify-content: center; display: inline-flex;">
                    <span class="pulse-dot"></span> SECURE ADMIN
                </div>
                <h3 style="margin: 0; font-family: var(--font-heading); color: var(--text-primary); font-size: 1.25rem;">
                    FSHOP <span class="neon-text-cyan">PANEL</span>
                </h3>
            </div>
            
            <nav class="admin-nav" style="display: flex; flex-direction: column; gap: 0.8rem;">
                <button class="admin-sidebar-tab-btn {{ $activeTab === 'orders' ? 'active' : '' }}" 
                        wire:click="setTab('orders')"
                        style="display: flex; align-items: center; gap: 0.8rem; width: 100%; padding: 0.9rem 1.2rem; border-radius: 12px; border: 1px solid transparent; background: transparent; color: var(--text-secondary); font-family: var(--font-body); font-weight: 600; cursor: pointer; text-align: left;">
                    <i class="fa-solid fa-list-check" style="font-size: 1.1rem; width: 20px;"></i> Pesanan Pelanggan
                </button>
                <button class="admin-sidebar-tab-btn {{ $activeTab === 'services' ? 'active' : '' }}" 
                        wire:click="setTab('services')"
                        style="display: flex; align-items: center; gap: 0.8rem; width: 100%; padding: 0.9rem 1.2rem; border-radius: 12px; border: 1px solid transparent; background: transparent; color: var(--text-secondary); font-family: var(--font-body); font-weight: 600; cursor: pointer; text-align: left;">
                    <i class="fa-solid fa-laptop-code" style="font-size: 1.1rem; width: 20px;"></i> Layanan Jasa
                </button>
                <button class="admin-sidebar-tab-btn {{ $activeTab === 'games' ? 'active' : '' }}" 
                        wire:click="setTab('games')"
                        style="display: flex; align-items: center; gap: 0.8rem; width: 100%; padding: 0.9rem 1.2rem; border-radius: 12px; border: 1px solid transparent; background: transparent; color: var(--text-secondary); font-family: var(--font-body); font-weight: 600; cursor: pointer; text-align: left;">
                    <i class="fa-solid fa-gamepad" style="font-size: 1.1rem; width: 20px;"></i> Game &amp; PPOB
                </button>
            </nav>
            
            <div style="margin-top: auto; border-top: 1px solid var(--border-color); padding-top: 1.5rem; text-align: center;">
                <a href="{{ route('home') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; font-size: 0.85rem;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Toko
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main-content" style="flex: 1; display: flex; flex-direction: column; gap: 2rem; width: 100%;">
            <!-- Header banner -->
            <div class="glass-card" style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);">
                        <i class="fa-solid fa-user-gear text-cyan"></i> ADMIN <span class="neon-text-cyan">DASHBOARD</span>
                    </h2>
                    <p style="margin: 0.2rem 0 0; font-size: 0.85rem; color: var(--text-secondary);">Kelola data transaksi pesanan serta katalog FSHOP.</p>
                </div>
                <div style="font-size: 0.85rem; color: var(--text-muted); background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 8px;">
                    Role: <span style="color: var(--primary-color); font-weight: bold;">Administrator</span>
                </div>
            </div>

        <!-- Tab 1: Orders log -->
        @if($activeTab === 'orders')
            <div class="glass-card" style="padding: 2rem; overflow-x: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                        <h3 style="margin: 0; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-receipt text-cyan"></i> Daftar Transaksi Invoices</h3>
                        <button wire:click="checkDokuPayments" class="btn" style="background: #e74c3c; color: white; padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.85rem; font-weight: bold; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.2s;" onmouseover="this.style.background='#c0392b'" onmouseout="this.style.background='#e74c3c'">
                            <i class="fa-solid fa-arrows-rotate"></i> Cek Status Pembayaran
                        </button>
                    </div>
                    @if(session()->has('order_success'))
                        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem;">
                            {{ session('order_success') }}
                        </div>
                    @endif
                </div>

                @if($orders->isEmpty())
                    <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                        <i class="fa-solid fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada transaksi pesanan yang terekam di database.</p>
                    </div>
                @else
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>No. WhatsApp</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-bold" style="color: var(--accent-color);">{{ $order->id }}</td>
                                    <td style="font-size: 0.8rem; color: var(--text-secondary);">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" style="color: #2ecc71; text-decoration: none;">
                                            <i class="fa-brands fa-whatsapp"></i> {{ $order->customer_phone }}
                                        </a>
                                    </td>
                                    <td style="font-size: 0.8rem;">
                                        @foreach($order->items as $item)
                                            <div style="margin-bottom: 0.3rem;">
                                                <strong>{{ $item['title'] }}</strong> 
                                                @if(isset($item['package_name']) && $item['package_name'])
                                                    ({{ $item['package_name'] }})
                                                @endif
                                                @if(isset($item['qty'])) x{{ $item['qty'] }} @endif
                                                @if(isset($item['meta']))
                                                    <div style="color: var(--text-muted); font-size: 0.75rem; padding-left: 0.4rem;">
                                                        @foreach($item['meta'] as $k => $v)
                                                            <span>{{ $k }}: {{ $v }} | </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="text-bold" style="color: var(--text-primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge-role {{ $order->payment_method === 'doku' ? 'badge-admin' : 'badge-customer' }}">
                                            {{ strtoupper($order->payment_method) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="status-toggle-btn {{ $order->payment_status === 'paid' ? 'paid' : 'pending' }}" wire:click="togglePaymentStatus('{{ $order->id }}')" title="Klik untuk ubah status">
                                            {{ strtoupper($order->payment_status) }}
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn-delete-row" wire:click="deleteOrder('{{ $order->id }}')" onclick="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')" title="Hapus Invoices">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endif

        <!-- Tab 2: Manage Services -->
        @if($activeTab === 'services')
            <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
                
                <!-- Add Service Form -->
                <div class="glass-card" style="padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-plus text-cyan"></i> {{ $isEditingService ? 'Edit Layanan Jasa' : 'Tambah Layanan Jasa Baru' }}</h3>
                    
                    @if(session()->has('service_success'))
                        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.5rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            {{ session('service_success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="{{ $isEditingService ? 'updateService' : 'addService' }}" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">ID Slug Unik (e.g. <code>custom-saas</code>)</label>
                            <input type="text" class="form-input" wire:model="s_id" required placeholder="Slug huruf kecil & tanda hubung" {{ $isEditingService ? 'disabled' : '' }}>
                            @error('s_id') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori Layanan</label>
                            <select class="form-select" wire:model="s_category">
                                <option value="web">Web Dev &amp; Portfolio</option>
                                <option value="mobile">Mobile Apps</option>
                                <option value="design">Desain Poster &amp; Banner</option>
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Nama Layanan / Title</label>
                            <input type="text" class="form-input" wire:model="s_title" required placeholder="Masukkan judul layanan">
                            @error('s_title') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; border: 1px solid var(--border-color); padding: 1rem; border-radius: 8px; background: rgba(0,0,0,0.15);">
                            <div>
                                <label class="form-label">Upload Gambar Baru (Custom)</label>
                                <input type="file" class="form-input" wire:model="s_image_file" accept="image/*" style="padding: 0.4rem;">
                                <div wire:loading wire:target="s_image_file" style="color: var(--primary-color); font-size: 0.8rem; margin-top: 0.2rem;"><i class="fa-solid fa-spinner fa-spin"></i> Mengunggah file...</div>
                                @error('s_image_file') <span style="color: #e74c3c; font-size: 0.75rem; display: block;">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">Atau URL Gambar Banner</label>
                                <input type="text" class="form-input" wire:model="s_image" placeholder="URL Gambar Unsplash" :disabled="$s_image_file ? true : false">
                                @error('s_image') <span style="color: #e74c3c; font-size: 0.75rem; display: block;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea class="form-textarea" rows="2" wire:model="s_short_desc" required placeholder="Jelaskan gambaran singkat layanan..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Estimasi Harga (e.g. <code>Mulai Rp 250.000</code>)</label>
                            <input type="text" class="form-input" wire:model="s_price" required placeholder="Mulai Rp xxx">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tag badges (Pisahkan dengan Koma, e.g. <code>Laravel, Livewire</code>)</label>
                            <input type="text" class="form-input" wire:model="s_tags" placeholder="Tag1, Tag2, Tag3">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Fitur / Keunggulan (Satu fitur per baris / enter)</label>
                            <textarea class="form-textarea" rows="3" wire:model="s_features" placeholder="Fitur keunggulan 1&#10;Fitur keunggulan 2&#10;Fitur keunggulan 3"></textarea>
                        </div>

                        <div style="grid-column: span 2; margin-top: 1rem; display: flex; gap: 1rem;">
                            <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem;">
                                <i class="fa-solid fa-circle-check"></i> {{ $isEditingService ? 'Simpan Perubahan' : 'Tambah Layanan Jasa' }}
                            </button>
                            @if($isEditingService)
                                <button type="button" class="btn btn-outline" wire:click="cancelEditService" style="padding: 0.8rem 2rem;">
                                    Batal
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Existing Services List -->
                <div class="glass-card" style="padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-layer-group text-cyan"></i> Daftar Layanan Aktif</h3>
                    
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Tags</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $srv)
                                <tr>
                                    <td><span class="badge-role badge-customer">{{ strtoupper($srv->category) }}</span></td>
                                    <td class="text-bold" style="color: var(--text-primary);">{{ $srv->title }}</td>
                                    <td style="color: var(--accent-color);">{{ $srv->price }}</td>
                                    <td style="font-size: 0.8rem;">
                                        @foreach($srv->tags as $tag)
                                            <span style="background: rgba(255,255,255,0.06); padding: 0.15rem 0.4rem; border-radius: 4px; margin-right: 0.2rem;">{{ $tag }}</span>
                                        @endforeach
                                    </td>
                                    <td style="display: flex; gap: 0.5rem; align-items: center;">
                                        <!-- Edit button -->
                                        <button class="theme-toggle" wire:click="editService('{{ $srv->id }}')" title="Edit Layanan" style="border-radius: var(--radius-sm); border-color: var(--border-color); background: rgba(255,255,255,0.05); color: var(--text-primary); cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <!-- Delete button -->
                                        <button class="btn-delete-row" wire:click="deleteService('{{ $srv->id }}')" onclick="return confirm('Hapus layanan {{ $srv->title }}?')" title="Hapus Layanan">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @endif

        <!-- Tab 3: Games and Top-up packages -->
        @if($activeTab === 'games')
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
                <!-- Add Game Form -->
                <div class="glass-card" style="padding: 2rem; height: fit-content;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-plus text-cyan"></i> {{ $isEditingGame ? 'Edit Produk Game / PPOB' : 'Tambah Produk Game / PPOB' }}</h3>
                    
                    @if(session()->has('game_success'))
                        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.5rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            {{ session('game_success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="addGame">
                        <div class="form-group">
                            <label class="form-label">ID Slug Unik (e.g. <code>mlbb</code>, <code>freefire</code>)</label>
                            <input type="text" class="form-input" wire:model="g_id" required placeholder="Slug game">
                            @error('g_id') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" wire:model="g_category">
                                <option value="mobile">Mobile Games</option>
                                <option value="pc">PC Games</option>
                                <option value="ppob">Pulsa &amp; PLN</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Judul Game / Layanan</label>
                            <input type="text" class="form-input" wire:model="g_title" required placeholder="e.g. Mobile Legends">
                            @error('g_title') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Publisher</label>
                            <input type="text" class="form-input" wire:model="g_publisher" required placeholder="e.g. Moonton">
                            @error('g_publisher') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">URL Gambar Banner</label>
                            <input type="text" class="form-input" wire:model="g_image" required placeholder="URL Gambar Unsplash">
                            @error('g_image') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Badge Promo (nullable, e.g. <code>HOT</code>, <code>PROMO</code>)</label>
                            <input type="text" class="form-input" wire:model="g_badge" placeholder="kosongkan jika tidak ada">
                        </div>

                        <div class="form-group" style="margin: 1rem 0;">
                            <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" wire:model.live="g_has_zone"> Game Menggunakan Zone ID? (e.g. MLBB)
                            </label>
                        </div>

                        @if($g_has_zone)
                            <div class="form-group">
                                <label class="form-label">Placeholder Petunjuk Zone ID</label>
                                <input type="text" class="form-input" wire:model="g_zone_placeholder" placeholder="Contoh: Zone ID (4-5 Digit)">
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                            <i class="fa-solid fa-circle-check"></i> Daftarkan Game
                        </button>
                    </form>
                </div>

                <!-- Add Package Nominal Form -->
                <div class="glass-card" style="padding: 2rem; height: fit-content;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-gem text-cyan"></i> Tambah Nominal / Paket Harga</h3>
                    
                    @if(session()->has('pkg_success'))
                        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.5rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            {{ session('pkg_success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="addPackage">
                        <div class="form-group">
                            <label class="form-label">Pilih Produk Game</label>
                            <select class="form-select" wire:model="pkg_game_id" required>
                                <option value="">-- Pilih Game --</option>
                                @foreach($games as $gm)
                                    <option value="{{ $gm->id }}">{{ $gm->title }}</option>
                                @endforeach
                            </select>
                            @error('pkg_game_id') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">ID Paket Unik (e.g. <code>ml-86</code>, <code>val-475</code>)</label>
                            <input type="text" class="form-input" wire:model="pkg_id" required placeholder="Package ID unique slug">
                            @error('pkg_id') <span style="color: #e74c3c; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Paket (e.g. <code>86 Diamonds (78+8 Bonus)</code>)</label>
                            <input type="text" class="form-input" wire:model="pkg_name" required placeholder="Masukkan nama paket nominal">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga Jual (e.g. <code>Rp 20.000</code>)</label>
                            <input type="text" class="form-input" wire:model="pkg_price" required placeholder="Rp xx.xxx">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga Coret Asli (nullable, e.g. <code>Rp 23.000</code>)</label>
                            <input type="text" class="form-input" wire:model="pkg_original" placeholder="Untuk promo diskon">
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                            <i class="fa-solid fa-circle-check"></i> Tambah Nominal Paket
                        </button>
                    </form>
                </div>

                <!-- Existing Games list with Packages list -->
                <div class="glass-card" style="grid-column: span 2; padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-family: var(--font-heading); color: var(--text-primary);"><i class="fa-solid fa-gamepad text-cyan"></i> Katalog Game &amp; Paket Nominal Aktif</h3>
                    
                    @foreach($games as $gm)
                        <div class="game-management-section glass-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(0,0,0,0.15); border-color: rgba(255,255,255,0.06);">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
                                <div>
                                    <h4 style="margin: 0; font-size: 1.15rem; color: var(--text-primary);">{{ $gm->title }} <span style="font-weight: normal; font-size: 0.8rem; color: var(--text-secondary);">by {{ $gm->publisher }}</span></h4>
                                    <span class="badge-role badge-customer" style="font-size: 0.65rem;">{{ strtoupper($gm->category) }}</span>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <!-- Edit Game button -->
                                    <button class="btn btn-outline btn-sm" wire:click="editGame('{{ $gm->id }}')" style="border-color: var(--border-color); color: var(--text-primary); cursor: pointer;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <!-- Delete Game button -->
                                    <button class="btn btn-outline btn-sm" wire:click="deleteGame('{{ $gm->id }}')" onclick="return confirm('Hapus game {{ $gm->title }} dan seluruh paket nominalnya?')" style="border-color: rgba(231, 76, 60, 0.4); color: #e74c3c; cursor: pointer;">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.8rem;">
                                @forelse($gm->packages as $pkg)
                                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 0.6rem 0.8rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="font-size: 0.8rem; font-weight: bold; color: var(--text-primary);">{{ $pkg->name }}</div>
                                            <div style="font-size: 0.85rem; color: var(--accent-color); font-weight: bold;">{{ $pkg->price }}</div>
                                        </div>
                                        <button wire:click="deletePackage('{{ $pkg->id }}')" onclick="return confirm('Hapus nominal {{ $pkg->name }}?')" style="background: none; border: none; color: #e74c3c; cursor: pointer; opacity: 0.7; font-size: 0.95rem;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                @empty
                                    <div style="grid-column: span 3; font-size: 0.8rem; color: var(--text-muted);">Belum ada nominal paket untuk game ini.</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif
        </main>
    </div>
</div>
