<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSHOP | Space Digital Services & Free CV Maker</title>
    <meta name="description" content="FSHOP - Jasa Pembuatan Web, Aplikasi Mobile, Landing Page, Portfolio, Design Poster, Banner, dan CV Gratis dengan UI Space Glassmorphism.">
    
    <!-- Preconnect to external resource domains to accelerate DNS + TLS handshakes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://images.unsplash.com">

    <!-- Asynchronous non-blocking loading of Web Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700&display=swap" media="print" onload="this.media='all'">
    
    <!-- Asynchronous non-blocking loading of FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    
    <!-- Custom Space Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    @livewireStyles
</head>
<body>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('fshop_theme') || 'light';
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
            } else {
                document.body.classList.remove('light-mode');
            }
        })();
    </script>

    <!-- Global Client-Side Alpine Cart Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: JSON.parse(localStorage.getItem('fshop_cart') || '[]'),
                isOpen: false,
                isCheckoutLoading: false,

                get total() {
                    return this.items.reduce((sum, item) => sum + (item.selected !== false ? (parseInt(item.price_raw) * (item.qty || 1)) : 0), 0);
                },
                get count() {
                    return this.items.reduce((sum, item) => sum + (item.qty || 1), 0);
                },
                addItem(item) {
                    const metaStr = JSON.stringify(item.meta || {});
                    const uniqueKey = item.type + '_' + item.id + '_' + btoa(metaStr).replace(/=/g, '');
                    
                    let existing = this.items.find(i => i.uniqueKey === uniqueKey);
                    if (existing) {
                        existing.qty = (existing.qty || 1) + 1;
                        existing.selected = true;
                    } else {
                        item.uniqueKey = uniqueKey;
                        item.qty = 1;
                        item.selected = true;
                        this.items.push(item);
                    }
                    this.save();
                    this.isOpen = true;
                },
                removeItem(uniqueKey) {
                    this.items = this.items.filter(i => i.uniqueKey !== uniqueKey);
                    this.save();
                },
                save() {
                    localStorage.setItem('fshop_cart', JSON.stringify(this.items));
                },
                clear() {
                    this.items = [];
                    this.save();
                },
                formatMoney(value) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                },
                processCheckout() {
                    const selectedItems = this.items.filter(item => item.selected !== false);
                    if (selectedItems.length === 0) {
                        alert('Pilih minimal satu item untuk dicheckout.');
                        return;
                    }

                    this.isCheckoutLoading = true;
                    
                    fetch("/checkout/process-cart", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: selectedItems
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) {
                            // Clear only the checked out (selected) items from the cart
                            this.items = this.items.filter(item => item.selected === false);
                            this.save();
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
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('addToCart', (event) => {
                const item = event.item || event[0]?.item || event;
                if (item) {
                    Alpine.store('cart').addItem(item);
                }
            });
            Livewire.on('openCartDrawer', () => {
                Alpine.store('cart').isOpen = true;
            });
        });
    </script>

    <!-- Space Particle Light Canvas Background -->
    <div class="space-bg">
        <div class="stars"></div>
        <div class="nebula-1"></div>
        <div class="nebula-2"></div>
    </div>

    <!-- Livewire Navigation Header Component -->
    @livewire('navbar.header')

    <!-- Main Content Slot -->
    <main>
        @php
            $pendingIds = session('pending_order_ids', []);
            if (session()->has('latest_order_id') && !in_array(session('latest_order_id'), $pendingIds)) {
                $pendingIds[] = session('latest_order_id');
                session(['pending_order_ids' => $pendingIds]);
            }
            
            $activeOrders = [];
            $sessionUpdated = false;
            foreach ($pendingIds as $id) {
                $order = \App\Models\Order::find($id);
                if ($order) {
                    if ($order->payment_status === 'pending') {
                        $dokuService = new \App\Services\DokuService();
                        $status = $dokuService->checkStatus($order->id);
                        if ($status) {
                            $statusUpper = strtoupper($status);
                            if ($statusUpper === 'SUCCESS' || $statusUpper === 'PAID') {
                                $order->update(['payment_status' => 'paid']);
                            } elseif (in_array($statusUpper, ['CANCEL', 'CANCELLED', 'FAILED', 'EXPIRED', 'EXPIRE'])) {
                                $order->update(['payment_status' => 'failed']);
                                $pendingIds = array_diff($pendingIds, [$id]);
                                $sessionUpdated = true;
                                continue;
                            }
                        }
                    }
                    $activeOrders[] = $order;
                }
            }
            if ($sessionUpdated) {
                session(['pending_order_ids' => array_values($pendingIds)]);
            }
        @endphp

        @if(count($activeOrders) > 0 || session()->has('error') || session()->has('success'))
            <div class="global-alerts-container" style="margin-top: 6.5rem; padding: 0 1rem; display: flex; flex-direction: column; gap: 1rem; position: relative; z-index: 100;">
                <style>
                    .global-alerts-container ::-webkit-scrollbar {
                        width: 6px;
                    }
                    .global-alerts-container ::-webkit-scrollbar-track {
                        background: transparent;
                    }
                    .global-alerts-container ::-webkit-scrollbar-thumb {
                        background: rgba(var(--primary-rgb), 0.3);
                        border-radius: 3px;
                    }
                    .global-alerts-container ::-webkit-scrollbar-thumb:hover {
                        background: rgba(var(--primary-rgb), 0.5);
                    }
                </style>

                @if(count($activeOrders) > 0)
                    <div class="glass-card" style="max-width: 1200px; margin: 0 auto; width: 100%; padding: 1.5rem; border-radius: var(--radius-md); box-shadow: var(--glass-shadow);">
                        <h4 style="margin: 0 0 1rem 0; font-family: var(--font-heading); color: var(--text-primary); font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-credit-card" style="color: var(--primary-color);"></i> Status Transaksi Pembayaran Anda
                        </h4>
                        
                        <!-- Scrollable list of orders -->
                        <div style="max-height: 250px; overflow-y: auto; display: flex; flex-direction: column; gap: 0.8rem; padding-right: 0.5rem; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                            @foreach($activeOrders as $order)
                                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding: 1rem; background: rgba(var(--primary-rgb), 0.04); border: 1px solid var(--border-color); border-radius: 12px; transition: background 0.2s;">
                                    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 280px;">
                                        <div style="width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;
                                            {{ $order->payment_status === 'paid' ? 'background: rgba(46, 204, 113, 0.15); border: 1.5px solid #2ecc71; color: #2ecc71; box-shadow: 0 0 10px rgba(46, 204, 113, 0.1);' : 'background: rgba(241, 196, 15, 0.15); border: 1.5px solid #f1c40f; color: #f1c40f; box-shadow: 0 0 10px rgba(241, 196, 15, 0.1);' }}">
                                            <i class="fa-solid {{ $order->payment_status === 'paid' ? 'fa-circle-check' : 'fa-clock' }}"></i>
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                                <span style="font-weight: bold; color: var(--text-primary); font-size: 0.9rem;">#{{ $order->id }}</span>
                                                <span style="font-size: 0.7rem; padding: 0.1rem 0.4rem; border-radius: 8px; font-weight: bold; 
                                                    {{ $order->payment_status === 'paid' ? 'background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid #2ecc71;' : 'background: rgba(241, 196, 15, 0.2); color: #f1c40f; border: 1px solid #f1c40f;' }}">
                                                    {{ strtoupper($order->payment_status) }}
                                                </span>
                                            </div>
                                            <p style="margin: 0.2rem 0 0; font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">
                                                {{ $order->payment_status === 'paid' ? 'Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses oleh FSHOP.' : 'Menunggu konfirmasi pembayaran otomatis dari sistem Doku.' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                                        @if($order->payment_status === 'pending')
                                            <a href="{{ route('checkout.pay', $order->id) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600;" title="Buka Halaman Pembayaran Doku">
                                                <i class="fa-solid fa-external-link"></i> Lanjutkan
                                            </a>
                                        @endif
                                        <button onclick="window.location.reload()" class="btn btn-outline btn-sm" style="font-size: 0.75rem; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600;" title="Perbarui Status Pembayaran">
                                            <i class="fa-solid fa-arrows-rotate"></i> Cek Status
                                        </button>
                                        <a href="{{ route('checkout.clear-order', $order->id) }}" class="btn btn-outline btn-sm" style="font-size: 0.75rem; padding: 0.4rem 0.6rem; border-radius: 6px; color: var(--text-secondary);" title="Hapus dari Pemantauan">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="glass-card" style="max-width: 1200px; margin: 0 auto; width: 100%; padding: 1rem 1.5rem; background: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; border-radius: var(--radius-md); display: flex; align-items: center; gap: 0.8rem; font-size: 0.9rem;">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.2rem;"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="glass-card" style="max-width: 1200px; margin: 0 auto; width: 100%; padding: 1rem 1.5rem; background: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; border-radius: var(--radius-md); display: flex; align-items: center; gap: 0.8rem; font-size: 0.9rem;">
                        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Livewire Footer Component -->
    @livewire('footer.footer')

    <!-- Livewire Floating Widgets -->
    @livewire('widgets.space-weather')
    @livewire('widgets.astro-bot-chat')
    @livewire('widgets.whats-app-button')
    @livewire('cart.shopping-cart')

    @livewireScripts

    <!-- Global Theme Switcher, Accent Color & Active Nav Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Mode Toggle (Dark / Light)
            const savedTheme = localStorage.getItem('fshop_theme') || 'light';
            const themeIcon = document.getElementById('themeIcon');
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
                if (themeIcon) themeIcon.className = 'fa-solid fa-sun';
            } else {
                document.body.classList.remove('light-mode');
                if (themeIcon) themeIcon.className = 'fa-solid fa-moon';
            }

            // Accent Color Restoration
            const savedAccent = localStorage.getItem('fshop_accent') || '#6c5ce7';

            const savedRgb = localStorage.getItem('fshop_accent_rgb') || '108, 92, 231';
            document.documentElement.style.setProperty('--primary-color', savedAccent);
            document.documentElement.style.setProperty('--primary-rgb', savedRgb);

            // Active Navigation Switching (Click & ScrollSpy)
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('section[id]');

            function syncActiveNav(targetId) {
                if (!targetId) return;
                navLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === '#' + targetId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            // Set initial active nav
            const currentHash = window.location.hash.replace('#', '') || 'home';
            syncActiveNav(currentHash);

            // Handle ScrollSpy as user scrolls through sections
            let lastSection = '';
            window.addEventListener('scroll', function() {
                let currentSection = 'home';
                const scrollPos = window.scrollY + 250;

                sections.forEach(sec => {
                    const secTop = sec.offsetTop;
                    const secHeight = sec.offsetHeight;
                    if (scrollPos >= secTop && scrollPos < secTop + secHeight) {
                        currentSection = sec.getAttribute('id');
                    }
                });

                if (currentSection && currentSection !== lastSection) {
                    lastSection = currentSection;
                    syncActiveNav(currentSection);
                    if (window.Livewire) {
                        Livewire.dispatch('nav-scrolled', { section: currentSection });
                    }
                }
            });
        });

        function toggleThemeMode() {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            localStorage.setItem('fshop_theme', isLight ? 'light' : 'dark');
            
            // Dispatch event to components if needed
            const icon = document.getElementById('themeIcon');
            if(icon) {
                icon.className = isLight ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
            }
        }

        function setAccentColor(hex, rgb, name) {
            document.documentElement.style.setProperty('--primary-color', hex);
            document.documentElement.style.setProperty('--primary-rgb', rgb);
            localStorage.setItem('fshop_accent', hex);
            localStorage.setItem('fshop_accent_rgb', rgb);

            // Update active state in UI
            document.querySelectorAll('.accent-opt').forEach(opt => opt.classList.remove('active'));
            const activeOpt = document.querySelector('.color-' + name);
            if(activeOpt) activeOpt.classList.add('active');
        }
    </script>

    <!-- Cookie Consent Banner -->
    <div id="cookie-consent" class="glass-card" style="position: fixed; bottom: 2rem; left: 2rem; max-width: 400px; padding: 1.5rem; display: none; flex-direction: column; gap: 1rem; z-index: 9999; box-shadow: var(--glass-shadow); border: 1px solid var(--border-color); transition: opacity 0.5s ease; animation: slideInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;">
        <div style="display: flex; gap: 1rem; align-items: flex-start;">
            <div style="font-size: 1.5rem; color: var(--primary-color); background: rgba(var(--primary-rgb), 0.1); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fa-solid fa-cookie-bite"></i>
            </div>
            <div>
                <h4 style="margin: 0 0 0.25rem; font-family: var(--font-heading); color: var(--text-primary); font-size: 1rem;">Kebijakan Cookie</h4>
                <p style="margin: 0; font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">FSHOP menggunakan cookie untuk meningkatkan pengalaman jelajah Anda dan menganalisis lalu lintas situs.</p>
            </div>
        </div>
        <div style="display: flex; gap: 0.8rem; justify-content: flex-end; width: 100%;">
            <button id="decline-cookies" class="btn btn-outline btn-sm" style="font-size: 0.8rem; padding: 0.5rem 1rem; cursor: pointer;">Tolak</button>
            <button id="accept-cookies" class="btn btn-primary btn-sm" style="font-size: 0.8rem; padding: 0.5rem 1rem; cursor: pointer;">Terima Semua</button>
        </div>
    </div>

    <style>
        @keyframes slideInUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @media (max-width: 576px) {
            #cookie-consent {
                left: 1rem !important;
                right: 1rem !important;
                max-width: none !important;
                bottom: 1rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const consentBanner = document.getElementById('cookie-consent');
            const acceptBtn = document.getElementById('accept-cookies');
            const declineBtn = document.getElementById('decline-cookies');

            // Cek apakah user sudah memberikan jawaban persetujuan cookie
            const cookieConsent = localStorage.getItem('fshop_cookie_consent');

            if (!cookieConsent) {
                // Tampilkan banner setelah jeda 1.5 detik agar efek slide-in terlihat mulus
                setTimeout(() => {
                    consentBanner.style.display = 'flex';
                }, 1500);
            }

            acceptBtn.addEventListener('click', () => {
                localStorage.setItem('fshop_cookie_consent', 'accepted');
                consentBanner.style.opacity = '0';
                setTimeout(() => {
                    consentBanner.style.display = 'none';
                }, 500);
            });

            declineBtn.addEventListener('click', () => {
                localStorage.setItem('fshop_cookie_consent', 'declined');
                consentBanner.style.opacity = '0';
                setTimeout(() => {
                    consentBanner.style.display = 'none';
                }, 500);
            });
        });
    </script>
</body>
</html>

