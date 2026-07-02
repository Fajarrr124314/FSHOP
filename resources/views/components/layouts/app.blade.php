<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSHOP | Space Digital Services & Free CV Maker</title>
    <meta name="description" content="FSHOP - Jasa Pembuatan Web, Aplikasi Mobile, Landing Page, Portfolio, Design Poster, Banner, dan CV Gratis dengan UI Space Glassmorphism.">
    
    <!-- Google Fonts: Outfit & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                    return this.items.reduce((sum, item) => sum + (parseInt(item.price_raw) * (item.qty || 1)), 0);
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
                    } else {
                        item.uniqueKey = uniqueKey;
                        item.qty = 1;
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
                    if (this.items.length === 0) return;
                    this.isCheckoutLoading = true;
                    
                    fetch("/checkout/process-cart", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: this.items
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) {
                            this.clear();
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
</body>
</html>
