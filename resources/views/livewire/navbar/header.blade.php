<header class="header">
    <div class="nav-container">
        <a href="#home" class="logo">
            <i class="fa-solid fa-user-astronaut"></i> FSHOP<span>.space</span>
        </a>

        <nav class="nav-menu {{ $isMobileMenuOpen ? 'show' : '' }}" id="navMenu">
            <a href="#home" class="nav-link {{ $activeNav === 'home' ? 'active' : '' }}" wire:click="setActiveNav('home')">Beranda</a>

            <!-- Dropdown Layanan -->
            <div class="nav-dropdown {{ in_array($activeNav, ['services', 'topup']) ? 'active' : '' }}">
                <button class="nav-dropdown-trigger nav-link">
                    Layanan <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                </button>
                <div class="nav-dropdown-menu glass-card">
                    <a href="#services" class="dropdown-item {{ $activeNav === 'services' ? 'active' : '' }}" wire:click="setActiveNav('services')">
                        <div class="item-icon-box cyan"><i class="fa-solid fa-laptop-code"></i></div>
                        <div>
                            <div class="item-title">Layanan Jasa</div>
                            <div class="item-desc">Web, Apps, Desain &amp; Tugas</div>
                        </div>
                    </a>
                    <a href="#topup" class="dropdown-item {{ $activeNav === 'topup' ? 'active' : '' }}" wire:click="setActiveNav('topup')">
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
                    <a href="#cv-maker" class="dropdown-item {{ $activeNav === 'cv-maker' ? 'active' : '' }}" wire:click="setActiveNav('cv-maker')">
                        <div class="item-icon-box purple"><i class="fa-solid fa-file-invoice"></i></div>
                        <div>
                            <div class="item-title">Buat CV Gratis</div>
                            <div class="item-desc">Format ATS &amp; Kreatif A4</div>
                        </div>
                    </a>
                    <a href="#cover-letter" class="dropdown-item {{ $activeNav === 'cover-letter' ? 'active' : '' }}" wire:click="setActiveNav('cover-letter')">
                        <div class="item-icon-box magenta"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div>
                            <div class="item-title">Surat Lamaran AI</div>
                            <div class="item-desc">Surat Kerja Otomatis</div>
                        </div>
                    </a>
                </div>
            </div>

            <a href="#why-us" class="nav-link {{ $activeNav === 'why-us' ? 'active' : '' }}" wire:click="setActiveNav('why-us')">Keunggulan</a>
            <a href="#faq" class="nav-link {{ $activeNav === 'faq' ? 'active' : '' }}" wire:click="setActiveNav('faq')">FAQ</a>
        </nav>

        <div class="nav-actions">
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

            <!-- Mobile Hamburger Button -->
            <button class="menu-toggle" wire:click="toggleMobileMenu" aria-label="Toggle Navigation">
                <i class="fa-solid {{ $isMobileMenuOpen ? 'fa-xmark' : 'fa-bars' }}"></i>
            </button>
        </div>
    </div>
</header>
