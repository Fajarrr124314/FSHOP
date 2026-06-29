<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSHOP | Space Digital Services & Free CV Maker</title>
    <meta name="description" content="FSHOP - Jasa Pembuatan Web, Aplikasi Mobile, Landing Page, Portfolio, Design Poster, Banner, Jasa Tugas, dan CV Gratis dengan UI Space Glassmorphism.">
    
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

    @livewireScripts

    <!-- Global Theme Switcher, Accent Color & Active Nav Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Mode Toggle (Dark / Light)
            const savedTheme = localStorage.getItem('fshop_theme') || 'dark';
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
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
