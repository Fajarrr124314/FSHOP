<section id="topup" class="gaming-section" x-data="topupComponent()">
    <div class="section-container">
        <div class="section-header text-center" style="margin-bottom: 2.5rem;">
            <div class="gaming-badge-header">
                <span class="pulse-dot"></span> NEON GAMING &amp; PPOB CENTER
            </div>
            <h2 class="gaming-title">
                <i class="fa-solid fa-gamepad neon-icon"></i> TOP-UP GAME <span class="neon-text-cyan">&amp; VOUCHER</span>
            </h2>
            <p class="section-subtitle">
                Isi ulang Diamond Mobile Legends, Free Fire, UC PUBG, VP Valorant &amp; Token Listrik instan dengan harga termurah!
            </p>
        </div>

        <!-- Gaming Category Tabs -->
        <div class="gaming-tabs">
            <button class="gaming-tab {{ $activeTab === 'all' ? 'active' : '' }}" wire:click="setTab('all')">
                <i class="fa-solid fa-fire"></i> Semua Produk
            </button>
            <button class="gaming-tab {{ $activeTab === 'mobile' ? 'active' : '' }}" wire:click="setTab('mobile')">
                <i class="fa-solid fa-mobile-screen-button"></i> Mobile Games
            </button>
            <button class="gaming-tab {{ $activeTab === 'pc' ? 'active' : '' }}" wire:click="setTab('pc')">
                <i class="fa-solid fa-desktop"></i> PC Games
            </button>
            <button class="gaming-tab {{ $activeTab === 'ppob' ? 'active' : '' }}" wire:click="setTab('ppob')">
                <i class="fa-solid fa-bolt"></i> Pulsa &amp; PLN
            </button>
        </div>

        <!-- Gaming Cards Grid -->
        <div class="gaming-grid">
            @foreach($games as $game)
                <div class="gaming-card" 
                     @click="openGameModal({
                         id: '{{ $game->id }}',
                         title: '{{ $game->title }}',
                         publisher: '{{ $game->publisher }}',
                         image: '{{ $game->image }}',
                         has_zone: {{ $game->has_zone ? 'true' : 'false' }},
                         zone_placeholder: '{{ $game->zone_placeholder }}',
                         packages: [
                             @foreach($game->packages as $pkg)
                                 {
                                     id: '{{ $pkg->id }}',
                                     name: '{{ $pkg->name }}',
                                     price: '{{ $pkg->price }}',
                                     price_raw: {{ preg_replace('/[^0-9]/', '', $pkg->price) ?: 0 }},
                                     original: '{{ $pkg->original }}'
                                 },
                             @endforeach
                         ]
                     })">
                    <div class="gaming-card-banner">
                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="gaming-banner-img">
                        <div class="gaming-card-overlay"></div>
                        @if($game->badge)
                            <span class="gaming-card-badge">{{ $game->badge }}</span>
                        @endif
                    </div>
                    <div class="gaming-card-body">
                        <div class="gaming-publisher">{{ $game->publisher }}</div>
                        <h3 class="gaming-card-title">{{ $game->title }}</h3>
                        <div class="gaming-card-footer">
                            <span class="gaming-status"><i class="fa-solid fa-bolt-lightning"></i> Proses Instan</span>
                            <button class="gaming-btn-select">
                                Top Up <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Unified Gaming Top-Up Modal (Dual Column) -->
    <div class="gaming-modal-backdrop" 
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="closeGameModal()"
         style="display: none;">
        
        <template x-if="selectedGame">
            <div class="gaming-modal-content glass-card-gaming animate-popup" style="max-width: 950px; padding: 0;">
                <button class="modal-close-btn" @click="closeGameModal()" style="z-index: 50;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                
                <div class="modal-flex-container">
                    <!-- Left Column: Game Details and Info -->
                    <div class="modal-left-col">
                        <div class="modal-detail-img-box" style="height: 180px;">
                            <img :src="selectedGame.image" :alt="selectedGame.title">
                            <div class="modal-img-gradient"></div>
                            <div class="modal-detail-title-info" style="bottom: 0.8rem; left: 1.2rem;">
                                <span class="gaming-publisher" x-text="selectedGame.publisher"></span>
                                <h3 class="modal-game-title" style="margin: 0;" x-text="selectedGame.title"></h3>
                            </div>
                        </div>

                        <div class="modal-left-content">
                            <span class="gaming-status-online" style="margin-bottom: 1rem;"><i class="fa-solid fa-circle-check"></i> Layanan Aktif 24 Jam</span>
                            
                            <h4 class="modal-detail-subheading" style="font-size: 0.95rem; margin-bottom: 0.5rem;">
                                <i class="fa-solid fa-circle-info" style="color: var(--accent-color);"></i> Panduan Pengisian:
                            </h4>
                            <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">
                                1. Masukkan User ID dan Zone ID akun game Anda.<br>
                                2. Klik tombol <strong>"Cek ID"</strong> untuk verifikasi username.<br>
                                3. Pilih nominal Diamond/Voucher yang diinginkan.<br>
                                4. Klik <strong>Checkout</strong> atau <strong>Tambah ke Keranjang</strong> untuk menyelesaikan pembayaran.<br>
                                5. Pesanan akan diproses otomatis dalam 1-3 menit setelah pembayaran terkonfirmasi.
                            </p>
                        </div>
                    </div>

                    <!-- Right Column: Verification & Checkout Form -->
                    <div class="modal-right-col" style="padding: 2rem;">
                        <!-- Step 1: Input Account ID and Verify -->
                        <div class="gaming-step-box">
                            <div class="gaming-step-num">1</div>
                            <div class="gaming-step-content">
                                <h4 class="gaming-step-title">Verifikasi Akun Game Anda</h4>
                                
                                <div class="gaming-input-grid" :class="selectedGame.has_zone ? 'has-zone' : ''">
                                    <div>
                                        <input type="text" class="gaming-input" x-model="userId" placeholder="Masukkan User ID">
                                    </div>
                                    <template x-if="selectedGame.has_zone">
                                        <div>
                                            <input type="text" class="gaming-input" x-model="zoneId" :placeholder="selectedGame.zone_placeholder">
                                        </div>
                                    </template>
                                </div>

                                <div style="margin-top: 0.8rem; display: flex; align-items: center; gap: 0.8rem;">
                                    <button class="btn btn-outline btn-sm" type="button" @click="verifyUserId()" :disabled="isCheckingId" style="border-radius: 8px; font-size: 0.8rem; padding: 0.5rem 1rem;">
                                        <template x-if="isCheckingId">
                                            <span><i class="fa-solid fa-spinner fa-spin"></i> Memeriksa...</span>
                                        </template>
                                        <template x-if="!isCheckingId">
                                            <span><i class="fa-solid fa-magnifying-glass"></i> Cek ID Akun</span>
                                        </template>
                                    </button>

                                    <template x-if="isIdVerified && verifiedNickname">
                                        <span class="badge-role badge-customer animate-pulse" style="font-size: 0.8rem; padding: 0.4rem 0.8rem; border-radius: 6px;">
                                            <i class="fa-solid fa-circle-check"></i> <span x-text="verifiedNickname"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Select Package (Locked until ID verified) -->
                        <div class="gaming-step-box" style="margin-top: 1.8rem; position: relative;">
                            <div class="gaming-step-num">2</div>
                            <div class="gaming-step-content" :class="!isIdVerified ? 'lock-step-section' : ''">
                                <h4 class="gaming-step-title">Pilih Nominal Top-Up</h4>
                                
                                <template x-if="!isIdVerified">
                                    <div class="lock-overlay-badge">
                                        <i class="fa-solid fa-lock"></i> Silakan Cek ID Terlebih Dahulu
                                    </div>
                                </template>

                                <div class="package-grid">
                                    <template x-for="pkg in selectedGame.packages" :key="pkg.id">
                                        <div class="package-card" 
                                             :class="selectedPackage && selectedPackage.id === pkg.id ? 'active' : ''" 
                                             @click="isIdVerified && selectPackage(pkg)">
                                            <div class="package-name" x-text="pkg.name"></div>
                                            <div class="package-price" x-text="pkg.price"></div>
                                            <template x-if="pkg.original">
                                                <div class="package-original" x-text="pkg.original"></div>
                                            </template>
                                            <template x-if="selectedPackage && selectedPackage.id === pkg.id">
                                                <div class="package-check"><i class="fa-solid fa-check"></i></div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Checkout Actions (Locked until ID verified) -->
                        <div class="gaming-step-box" style="margin-top: 1.8rem;">
                            <div class="gaming-step-num">3</div>
                            <div class="gaming-step-content" :class="!isIdVerified ? 'lock-step-section' : ''">
                                <h4 class="gaming-step-title">Konfirmasi &amp; Pembayaran</h4>

                                <div class="gaming-modal-footer" style="margin-top: 0; padding-top: 0; border: none; flex-direction: column; align-items: stretch; gap: 1rem;">
                                    <div class="total-summary" style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: var(--text-secondary);">Total Pembayaran:</span>
                                        <h3 class="total-price" style="margin: 0;" x-text="selectedPackage ? selectedPackage.price : 'Rp 0'"></h3>
                                    </div>
                                    
                                    <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                                        <button class="btn btn-primary" style="justify-content: center; padding: 0.8rem; font-size: 0.9rem;" 
                                                @click="processCheckout()" :disabled="!isIdVerified || isCheckoutLoading">
                                            <span x-show="!isCheckoutLoading"><i class="fa-solid fa-credit-card"></i> Checkout</span>
                                            <span x-show="isCheckoutLoading" style="display: none;"><i class="fa-solid fa-circle-notch fa-spin"></i> MEMPROSES...</span>
                                        </button>

                                        <button class="btn btn-outline" style="justify-content: center; padding: 0.8rem; font-size: 0.9rem;" 
                                                @click="addToCart()" :disabled="!isIdVerified">
                                            <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Alpine Controller Initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('topupComponent', () => ({
                isOpen: false,
                selectedGame: null,
                selectedPackage: null,
                userId: '',
                zoneId: '',
                isCheckingId: false,
                isIdVerified: false,
                verifiedNickname: '',
                isCheckoutLoading: false,

                openGameModal(game) {
                    this.selectedGame = game;
                    this.selectedPackage = game.packages && game.packages.length > 0 ? game.packages[0] : null;
                    this.userId = '';
                    this.zoneId = '';
                    this.isCheckingId = false;
                    this.isIdVerified = false;
                    this.verifiedNickname = '';
                    this.isCheckoutLoading = false;
                    this.isOpen = true;
                },

                closeGameModal() {
                    this.isOpen = false;
                },

                selectPackage(pkg) {
                    this.selectedPackage = pkg;
                },

                verifyUserId() {
                    if (!this.userId) {
                        alert('Silakan masukkan User ID terlebih dahulu.');
                        return;
                    }

                    this.isCheckingId = true;
                    this.isIdVerified = false;
                    this.verifiedNickname = '';

                    setTimeout(() => {
                        this.isCheckingId = false;
                        this.isIdVerified = true;

                        let prefix = 'FSHOP_Member_';
                        if (this.selectedGame.id === 'mlbb') prefix = 'MLBB_Gamer_';
                        else if (this.selectedGame.id === 'freefire') prefix = 'FF_Survivor_';
                        else if (this.selectedGame.id === 'pubgm') prefix = 'PUBG_Pro_';
                        else if (this.selectedGame.id === 'valorant') prefix = 'VAL_Radian_';
                        else if (this.selectedGame.id === 'genshin') prefix = 'GI_Traveler_';

                        const cleanId = this.userId.replace(/[^0-9]/g, '');
                        const suffix = cleanId ? cleanId.slice(-4) : Math.floor(1000 + Math.random() * 9000);
                        this.verifiedNickname = prefix + suffix;
                    }, 600);
                },

                addToCart() {
                    if (!this.selectedGame || !this.selectedPackage) return;
                    if (!this.isIdVerified) {
                        alert('Silakan verifikasi akun Anda terlebih dahulu.');
                        return;
                    }

                    let idInfo = "User ID: " + this.userId;
                    if (this.selectedGame.has_zone && this.zoneId) {
                        idInfo += " (Zone " + this.zoneId + ")";
                    }
                    idInfo += " | Nickname: " + this.verifiedNickname;

                    const cartItem = {
                        id: this.selectedPackage.id,
                        type: 'topup',
                        title: this.selectedGame.title,
                        package_name: this.selectedPackage.name,
                        image: this.selectedGame.image,
                        price_raw: this.selectedPackage.price_raw,
                        price: this.selectedPackage.price,
                        qty: 1,
                        meta: {
                            game_account: idInfo
                        }
                    };

                    Alpine.store('cart').addItem(cartItem);
                    this.closeGameModal();
                },

                processCheckout() {
                    if (!this.selectedGame || !this.selectedPackage) return;
                    if (!this.isIdVerified) {
                        alert('Silakan verifikasi akun Anda terlebih dahulu.');
                        return;
                    }

                    this.isCheckoutLoading = true;

                    fetch("/checkout/process-direct-topup", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            package_id: this.selectedPackage.id,
                            user_id: this.userId,
                            zone_id: this.zoneId,
                            nickname: this.verifiedNickname
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) {
                            window.location.href = data.url;
                        } else {
                            alert(data.message || 'Gagal memproses checkout.');
                            this.isCheckoutLoading = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan koneksi.');
                        this.isCheckoutLoading = false;
                    });
                }
            }));
        });
    </script>
</section>
