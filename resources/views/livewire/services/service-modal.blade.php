<div class="modal-overlay {{ $isOpen ? 'show' : '' }}">
    @if($service)
        <div class="modal-content-box glass-card modal-dual-layout" style="max-width: 950px; padding: 0;">
            <button class="modal-close-btn" wire:click="closeModal" style="z-index: 50;">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Dual Column Flexbox Container -->
            <div class="modal-flex-container">
                
                <!-- Left Column: Product/Service Details -->
                <div class="modal-left-col">
                    <div class="modal-detail-img-box">
                        <img src="{{ $service->image }}" alt="{{ $service->title }}">
                        <div class="modal-img-gradient"></div>
                        <div class="modal-detail-title-info">
                            <span class="section-tag" style="margin: 0; color: var(--accent-color);">DETAIL LAYANAN</span>
                            <h2 class="modal-detail-heading">{{ $service->title }}</h2>
                        </div>
                    </div>

                    <div class="modal-left-content">
                        <p class="modal-detail-desc">
                            {{ $service->short_desc }}
                        </p>

                        <h4 class="modal-detail-subheading">
                            <i class="fa-solid fa-circle-check"></i> Fitur &amp; Keunggulan Utama:
                        </h4>

                        <ul class="modal-detail-features">
                            @foreach($service->features as $feature)
                                <li>
                                    <i class="fa-solid fa-check feature-check-icon"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <div class="modal-detail-price-box">
                            <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Estimasi Biaya:</span>
                            <span class="service-price" style="font-size: 1.5rem;">{{ $service->price }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Checkout Form -->
                <div class="modal-right-col">
                    <div style="margin-bottom: 1.5rem;">
                        <h3 class="modal-right-title">Form Pemesanan</h3>
                        <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">Silakan isi formulir di bawah ini untuk pemesanan cepat.</p>
                    </div>

                    <form>
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap Anda</label>
                            <input type="text" class="form-input" wire:model="customerName" required placeholder="Masukkan nama Anda">
                            @error('customerName') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">No. WhatsApp / HP</label>
                            <input type="text" class="form-input" wire:model="customerPhone" required placeholder="Contoh: 08123456789">
                            @error('customerPhone') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prioritas Tenggat Waktu</label>
                            <select class="form-select" wire:model="deadline">
                                <option value="Santai (3-5 Hari)">Santai (3-5 Hari)</option>
                                <option value="Standard (1-2 Hari)">Standard (1-2 Hari)</option>
                                <option value="Kilat Express (< 24 Jam)">Kilat Express (&lt; 24 Jam)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan Spesifikasi Project</label>
                            <textarea class="form-textarea" rows="3" wire:model="notes" placeholder="Jelaskan gambaran website, poster, atau tugas yang Anda inginkan..."></textarea>
                        </div>

                        <div style="margin-top: 1.8rem; display: flex; flex-direction: column; gap: 0.8rem;">
                            <!-- Buy/Checkout buttons -->
                            <button type="button" class="btn btn-primary" style="justify-content: center; padding: 0.85rem;" wire:click="processDokuOrder" wire:loading.attr="disabled">
                                <i class="fa-solid fa-credit-card"></i> Checkout
                            </button>

                            <button type="button" class="btn btn-outline" style="justify-content: center; padding: 0.8rem;" wire:click="addToCart" wire:loading.attr="disabled">
                                <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang Belanja
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('openUrlInNewTab', (event) => {
                window.open(event.url, '_blank');
            });
            
            Livewire.on('openPaymentUrl', (event) => {
                window.location.href = event.url;
            });
        });
    </script>
</div>
