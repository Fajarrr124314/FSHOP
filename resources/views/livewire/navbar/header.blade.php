<header class="header">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="logo">
            <i class="fa-solid fa-user-astronaut"></i> FSHOP<span>.space</span>
        </a>

        <nav class="nav-menu {{ $isMobileMenuOpen ? 'show' : '' }}" id="navMenu">
            <a href="{{ route('home') }}" class="nav-link {{ $activeNav === 'home' ? 'active' : '' }}">Beranda</a>

            <!-- Dropdown Layanan -->
            <div class="nav-dropdown {{ in_array($activeNav, ['services', 'topup']) ? 'active' : '' }}">
                <button class="nav-dropdown-trigger nav-link">
                    Layanan <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                </button>
                <div class="nav-dropdown-menu glass-card">
                    <a href="{{ route('services') }}" class="dropdown-item {{ $activeNav === 'services' ? 'active' : '' }}">
                        <div class="item-icon-box cyan"><i class="fa-solid fa-laptop-code"></i></div>
                        <div>
                            <div class="item-title">Layanan Jasa</div>
                            <div class="item-desc">Web, Apps, Desain &amp; Tugas</div>
                        </div>
                    </a>
                    <a href="{{ route('topup') }}" class="dropdown-item {{ $activeNav === 'topup' ? 'active' : '' }}">
                        <div class="item-icon-box pink"><i class="fa-solid fa-gamepad"></i></div>
                        <div>
                            <div class="item-title">Top-Up Game &amp; PPOB</div>
                            <div class="item-desc">Diamond ML, FF &amp; Token PLN</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Dropdown Fitur Karir -->
            <div class="nav-dropdown {{ in_array($activeNav, ['cv-maker', 'cover-letter']) ? 'active' : '' }}">
                <button class="nav-dropdown-trigger nav-link">
                    Fitur Karir <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                </button>
                <div class="nav-dropdown-menu glass-card">
                    <a href="{{ route('cv-maker') }}" class="dropdown-item {{ $activeNav === 'cv-maker' ? 'active' : '' }}">
                        <div class="item-icon-box purple"><i class="fa-solid fa-file-invoice"></i></div>
                        <div>
                            <div class="item-title">Buat CV Gratis</div>
                            <div class="item-desc">Format ATS &amp; Kreatif A4</div>
                        </div>
                    </a>
                    <a href="{{ route('cover-letter') }}" class="dropdown-item {{ $activeNav === 'cover-letter' ? 'active' : '' }}">
                        <div class="item-icon-box magenta"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div>
                            <div class="item-title">Surat Lamaran AI</div>
                            <div class="item-desc">Surat Kerja Otomatis</div>
                        </div>
                    </a>
                </div>
            </div>

            <a href="{{ route('home') }}#why-us" class="nav-link {{ $activeNav === 'why-us' ? 'active' : '' }}">Keunggulan</a>
            <a href="{{ route('home') }}#faq" class="nav-link {{ $activeNav === 'faq' ? 'active' : '' }}">FAQ</a>
            
            <!-- Mobile Auth Actions (Shown inside mobile menu sidebar) -->
            <div class="mobile-auth-actions">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="border-radius: 30px; padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); width: fit-content; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                            <i class="fa-solid fa-gauge-high"></i> Admin Panel
                        </a>
                    @endif
                    <a href="{{ route('auth.logout') }}" class="nav-link" style="border-radius: 30px; padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); width: fit-content; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: #ef4444;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout ({{ explode(' ', auth()->user()->name)[0] }})
                    </a>
                @else
                    <a href="{{ route('auth.google') }}" class="btn btn-outline" style="border-radius: 30px; font-size: 0.9rem; padding: 0.5rem 1.2rem; border-color: rgba(255,255,255,0.2); display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; width: fit-content;">
                        <i class="fa-brands fa-google"></i> Login dengan Google
                    </a>
                @endauth
            </div>
        </nav>


        <div class="nav-actions">
            <!-- Shopping Cart Button with Badge -->
            <button class="theme-toggle" x-data @click="$store.cart.isOpen = true" title="Buka Keranjang Belanja" style="position: relative; overflow: visible;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="nav-cart-badge" x-show="$store.cart.count > 0" x-text="$store.cart.count" style="display: none;"></span>
            </button>

            <!-- Color Accent Picker Dropdown -->
            <div class="accent-picker-container">
                <button class="theme-toggle" title="Pilih Warna Aksen">
                    <i class="fa-solid fa-palette"></i>
                </button>
                <div class="accent-dropdown glass-card">
                    <button class="accent-opt color-purple active" onclick="setAccentColor('#6c5ce7', '108, 92, 231', 'purple')" title="Nebula Purple"></button>
                    <button class="accent-opt color-cyan" onclick="setAccentColor('#00cec9', '0, 206, 201', 'cyan')" title="Supernova Cyan"></button>
                    <button class="accent-opt color-pink" onclick="setAccentColor('#fd79a8', '253, 121, 168', 'pink')" title="Cosmic Pink"></button>
                    <button class="accent-opt color-green" onclick="setAccentColor('#2ecc71', '46, 204, 113', 'green')" title="Aurora Green"></button>
                </div>
            </div>

            <!-- Dark / Light Mode Switcher -->
            <button class="theme-toggle" onclick="toggleThemeMode()" title="Ubah Tema Mode">
                <i class="fa-solid fa-moon" id="themeIcon"></i>
            </button>

            <!-- User Auth status & Profile Dropdown -->
            <div class="desktop-auth">
                @auth
                    <div class="nav-dropdown" style="position: relative; margin-left: 0.3rem;">
                        <button class="nav-dropdown-trigger nav-link" style="display: flex; align-items: center; gap: 0.4rem; border-radius: 30px; padding: 0.3rem 0.8rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border-color); cursor: pointer; text-transform: none; font-size: 0.85rem; height: 38px;">
                            <img src="{{ auth()->user()->avatar ?: 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email) . '?d=mp' }}" alt="User profile" style="width: 24px; height: 24px; border-radius: 50%;">
                            <span style="color: #ffffff; max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 600;">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem; opacity: 0.7;"></i>
                        </button>
                        <div class="nav-dropdown-menu glass-card" style="right: 0; left: auto; min-width: 180px; top: 110%;">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item" style="padding: 0.8rem 1rem;">
                                    <div class="item-icon-box purple" style="width: 32px; height: 32px; font-size: 0.85rem;"><i class="fa-solid fa-gauge-high"></i></div>
                                    <div>
                                        <div class="item-title" style="font-size: 0.85rem; font-weight: 600;">Admin Panel</div>
                                    </div>
                                </a>
                            @endif
                            <a href="{{ route('auth.logout') }}" class="dropdown-item" style="padding: 0.8rem 1rem;">
                                <div class="item-icon-box pink" style="width: 32px; height: 32px; font-size: 0.85rem;"><i class="fa-solid fa-right-from-bracket"></i></div>
                                <div>
                                    <div class="item-title" style="font-size: 0.85rem; font-weight: 600;">Logout</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('auth.google') }}" class="btn btn-outline" style="border-radius: 30px; font-size: 0.8rem; padding: 0.4rem 1rem; border-color: rgba(255,255,255,0.2); height: 38px; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fa-brands fa-google"></i> Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <button class="menu-toggle" wire:click="toggleMobileMenu" aria-label="Toggle Navigation">
                <i class="fa-solid {{ $isMobileMenuOpen ? 'fa-xmark' : 'fa-bars' }}"></i>
            </button>
        </div>
    </div>
</header>
