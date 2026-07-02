<section id="services" x-data="serviceModalComponent('{{ auth()->check() ? auth()->user()->name : '' }}')">
    <div class="section-header">
        <p class="section-tag">SERVICES CATALOG</p>
        <h2 class="section-title">Layanan Digital <span class="gradient-text">FSHOP</span></h2>
    </div>

    <!-- Category Filters -->
    <div class="services-filters">
        <button class="filter-btn {{ $activeFilter === 'all' ? 'active' : '' }}" wire:click="setFilter('all')">
            <i class="fa-solid fa-border-all"></i> Semua Layanan
        </button>
        <button class="filter-btn {{ $activeFilter === 'web' ? 'active' : '' }}" wire:click="setFilter('web')">
            <i class="fa-solid fa-code"></i> Web Dev &amp; Portfolio
        </button>
        <button class="filter-btn {{ $activeFilter === 'mobile' ? 'active' : '' }}" wire:click="setFilter('mobile')">
            <i class="fa-solid fa-mobile-screen"></i> Mobile Apps
        </button>
        <button class="filter-btn {{ $activeFilter === 'design' ? 'active' : '' }}" wire:click="setFilter('design')">
            <i class="fa-solid fa-palette"></i> Desain Poster &amp; Banner
        </button>
    </div>

    <!-- Grid Container -->
    <div class="services-grid">
        @foreach($services as $service)
            <div class="service-card glass-card">
                <div class="service-img-wrapper">
                    <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="service-card-img" loading="lazy">
                    <div class="img-overlay-glow"></div>
                </div>
                <div class="service-card-body">
                    <h3 class="service-title">{{ $service['title'] }}</h3>
                    <p class="service-desc">{{ $service['short_desc'] }}</p>

                    <div class="service-tags">
                        @foreach($service['tags'] as $tag)
                            <span class="tag-badge">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <div class="service-footer">
                        <span class="service-price">{{ $service['price'] }}</span>
                        <button class="btn btn-primary btn-sm" 
                                @click="openModal({
                                    id: '{{ $service['id'] }}',
                                    title: '{{ $service['title'] }}',
                                    image: '{{ $service['image'] }}',
                                    short_desc: '{{ addslashes($service['short_desc']) }}',
                                    price: '{{ $service['price'] }}',
                                    price_raw: {{ preg_replace('/[^0-9]/', '', $service['price']) ?: 0 }},
                                    features: {{ json_encode($service['features']) }}
                                })"
                                style="justify-content: center; min-width: 110px;">
                            <i class="fa-solid fa-cart-shopping"></i> Order
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Alpine.js Instant Details/Order Modal -->
    <div class="modal-overlay" 
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         :class="isOpen ? 'show' : ''"
         style="display: none;">
        
        <template x-if="service">
            <div class="modal-content-box glass-card modal-dual-layout" style="max-width: 950px; padding: 0;">
                <button class="modal-close-btn" @click="closeModal()" style="z-index: 50;">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Dual Column Layout -->
                <div class="modal-flex-container">
                    
                    <!-- Left Column: Details -->
                    <div class="modal-left-col">
                        <div class="modal-detail-img-box">
                            <img :src="service.image" :alt="service.title">
                            <div class="modal-img-gradient"></div>
                            <div class="modal-detail-title-info">
                                <span class="section-tag" style="margin: 0; color: var(--accent-color);">DETAIL LAYANAN</span>
                                <h2 class="modal-detail-heading" x-text="service.title"></h2>
                            </div>
                        </div>

                        <div class="modal-left-content">
                            <p class="modal-detail-desc" x-text="service.short_desc"></p>

                            <h4 class="modal-detail-subheading">
                                <i class="fa-solid fa-circle-check"></i> Fitur &amp; Keunggulan Utama:
                            </h4>

                            <ul class="modal-detail-features">
                                <template x-for="feature in service.features" :key="feature">
                                    <li>
                                        <i class="fa-solid fa-check feature-check-icon"></i>
                                        <span x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>

                            <div class="modal-detail-price-box">
                                <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Estimasi Biaya:</span>
                                <span class="service-price" style="font-size: 1.5rem;" x-text="service.price"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Form -->
                    <div class="modal-right-col">
                        <div style="margin-bottom: 1.5rem;">
                            <h3 class="modal-right-title">Form Pemesanan</h3>
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">Silakan isi formulir di bawah ini untuk pemesanan cepat.</p>
                        </div>

                        <form @submit.prevent="processCheckout()">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap Anda</label>
                                <input type="text" class="form-input" x-model="customerName" required placeholder="Masukkan nama Anda">
                            </div>

                            <div class="form-group">
                                <label class="form-label">No. WhatsApp / HP</label>
                                <input type="text" class="form-input" x-model="customerPhone" required placeholder="Contoh: 08123456789">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Prioritas Tenggat Waktu</label>
                                <select class="form-select" x-model="deadline">
                                    <option value="Santai (3-5 Hari)">Santai (3-5 Hari)</option>
                                    <option value="Standard (1-2 Hari)">Standard (1-2 Hari)</option>
                                    <option value="Kilat Express (< 24 Jam)">Kilat Express (&lt; 24 Jam)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Catatan Spesifikasi Project</label>
                                <textarea class="form-textarea" rows="3" x-model="notes" placeholder="Jelaskan gambaran website, poster, atau tugas yang Anda inginkan..."></textarea>
                            </div>

                            <div style="margin-top: 1.8rem; display: flex; flex-direction: column; gap: 0.8rem;">
                                <button type="submit" class="btn btn-primary" style="justify-content: center; padding: 0.85rem;" :disabled="isCheckoutLoading">
                                    <span x-show="!isCheckoutLoading"><i class="fa-solid fa-credit-card"></i> Checkout</span>
                                    <span x-show="isCheckoutLoading" style="display: none;"><i class="fa-solid fa-circle-notch fa-spin"></i> MEMPROSES...</span>
                                </button>

                                <button type="button" class="btn btn-outline" style="justify-content: center; padding: 0.8rem;" @click="addToCart()">
                                    <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang Belanja
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Alpine Controller Initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('serviceModalComponent', (defaultName) => ({
                isOpen: false,
                service: null,
                
                customerName: defaultName,
                customerPhone: '',
                deadline: 'Santai (3-5 Hari)',
                notes: '',
                isCheckoutLoading: false,

                openModal(service) {
                    this.service = service;
                    this.customerName = defaultName;
                    this.customerPhone = '';
                    this.deadline = 'Santai (3-5 Hari)';
                    this.notes = '';
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                },
                addToCart() {
                    if (!this.service) return;
                    if (!this.customerName || !this.customerPhone) {
                        alert('Nama lengkap dan nomor WhatsApp wajib diisi.');
                        return;
                    }

                    const cartItem = {
                        id: this.service.id,
                        type: 'service',
                        title: this.service.title,
                        image: this.service.image,
                        price_raw: this.service.price_raw,
                        price: this.service.price,
                        meta: {
                            prioritas: this.deadline,
                            catatan: this.notes || '-'
                        },
                        customer_name: this.customerName,
                        customer_phone: this.customerPhone
                    };

                    Alpine.store('cart').addItem(cartItem);
                    this.closeModal();
                },
                processCheckout() {
                    if (!this.service) return;
                    if (!this.customerName || !this.customerPhone) {
                        alert('Nama lengkap dan nomor WhatsApp wajib diisi.');
                        return;
                    }

                    this.isCheckoutLoading = true;
                    
                    fetch("/checkout/process-direct-service", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            service_id: this.service.id,
                            customer_name: this.customerName,
                            customer_phone: this.customerPhone,
                            deadline: this.deadline,
                            notes: this.notes
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
