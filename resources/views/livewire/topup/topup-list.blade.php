<section id="topup" class="gaming-section">
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

        <!-- Gaming Category Filters -->
        <div class="gaming-tabs">
            <button class="gaming-tab {{ $activeTab === 'all' ? 'active' : '' }}" wire:click="$set('activeTab', 'all')">
                <i class="fa-solid fa-fire"></i> Semua Produk
            </button>
            <button class="gaming-tab {{ $activeTab === 'mobile' ? 'active' : '' }}" wire:click="$set('activeTab', 'mobile')">
                <i class="fa-solid fa-mobile-screen-button"></i> Mobile Games
            </button>
            <button class="gaming-tab {{ $activeTab === 'pc' ? 'active' : '' }}" wire:click="$set('activeTab', 'pc')">
                <i class="fa-solid fa-desktop"></i> PC Games
            </button>
            <button class="gaming-tab {{ $activeTab === 'ppob' ? 'active' : '' }}" wire:click="$set('activeTab', 'ppob')">
                <i class="fa-solid fa-bolt"></i> Pulsa &amp; PLN
            </button>
        </div>

        <!-- Gaming Cards Grid -->
        <div class="gaming-grid">
            @foreach($games as $game)
                <div class="gaming-card" wire:click="selectGame('{{ $game['id'] }}')">
                    <div class="gaming-card-banner">
                        <img src="{{ $game['image'] }}" alt="{{ $game['title'] }}" class="gaming-banner-img">
                        <div class="gaming-card-overlay"></div>
                        <span class="gaming-card-badge">{{ $game['badge'] }}</span>
                    </div>
                    <div class="gaming-card-body">
                        <div class="gaming-publisher">{{ $game['publisher'] }}</div>
                        <h3 class="gaming-card-title">{{ $game['title'] }}</h3>
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

    <!-- Gaming Top-Up Modal -->
    @if($selectedGame)
        <div class="gaming-modal-backdrop" wire:click.self="closeGameModal">
            <div class="gaming-modal-content glass-card-gaming animate-popup">
                <button class="gaming-modal-close" wire:click="closeGameModal">&times;</button>
                
                <div class="gaming-modal-header">
                    <img src="{{ $selectedGame['image'] }}" alt="{{ $selectedGame['title'] }}" class="modal-game-img">
                    <div>
                        <span class="gaming-publisher">{{ $selectedGame['publisher'] }}</span>
                        <h3 class="modal-game-title">{{ $selectedGame['title'] }}</h3>
                        <span class="gaming-status-online"><i class="fa-solid fa-circle-check"></i> Server Online 24 Jam</span>
                    </div>
                </div>

                <div class="gaming-modal-body">
                    <!-- Step 1: Input Account ID -->
                    <div class="gaming-step-box">
                        <div class="gaming-step-num">1</div>
                        <div class="gaming-step-content">
                            <h4 class="gaming-step-title">Masukkan User ID Game Anda</h4>
                            <div class="gaming-input-grid {{ $selectedGame['has_zone'] ? 'has-zone' : '' }}">
                                <div>
                                    <input type="text" class="gaming-input" wire:model="userId" placeholder="Contoh User ID: 12345678">
                                </div>
                                @if($selectedGame['has_zone'])
                                    <div>
                                        <input type="text" class="gaming-input" wire:model="zoneId" placeholder="{{ $selectedGame['zone_placeholder'] }}">
                                    </div>
                                @endif
                            </div>
                            <div class="gaming-input-hint">
                                <i class="fa-solid fa-circle-info"></i> Petunjuk: User ID dapat dilihat di profil dalam game Anda.
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Select Denomination Package -->
                    <div class="gaming-step-box" style="margin-top: 1.5rem;">
                        <div class="gaming-step-num">2</div>
                        <div class="gaming-step-content">
                            <h4 class="gaming-step-title">Pilih Nominal Top-Up</h4>
                            <div class="package-grid">
                                @foreach($selectedGame['packages'] as $pkg)
                                    <div class="package-card {{ ($selectedPackage['id'] ?? '') === $pkg['id'] ? 'active' : '' }}" wire:click="selectPackage('{{ $pkg['id'] }}')">
                                        <div class="package-name">{{ $pkg['name'] }}</div>
                                        <div class="package-price">{{ $pkg['price'] }}</div>
                                        @if(isset($pkg['original']))
                                            <div class="package-original">{{ $pkg['original'] }}</div>
                                        @endif
                                        @if(($selectedPackage['id'] ?? '') === $pkg['id'])
                                            <div class="package-check"><i class="fa-solid fa-check"></i></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <div class="gaming-modal-footer">
                        <div class="total-summary">
                            <span>Total Pembayaran:</span>
                            <h3 class="total-price">{{ $selectedPackage['price'] ?? 'Rp 0' }}</h3>
                        </div>
                        <button class="gaming-checkout-btn" wire:click="checkoutWa">
                            <i class="fa-brands fa-whatsapp"></i> Beli Sekarang Via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
