<footer class="footer" style="padding: 4rem 2rem 2rem; border-top: 1px solid var(--border-color); background: var(--bg-card); backdrop-filter: blur(10px);">
    <div class="footer-content" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; text-align: left; padding-bottom: 2rem;">
        
        <!-- Left Col: Logo & Info -->
        <div>
            <a href="{{ route('home') }}" class="logo" style="margin-bottom: 1rem; display: inline-flex;">
                <i class="fa-solid fa-user-astronaut"></i> FSHOP<span>.space</span>
            </a>
            <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 1rem;">
                Solusi digital modern, cepat &amp; profesional untuk meningkatkan konversi dan bisnis Anda di era digital.
            </p>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                &copy; {{ date('Y') }} FSHOP Agency. All Rights Reserved.
            </p>
        </div>

        <!-- Middle Col: Quick Menu -->
        <div>
            <h4 style="font-family: var(--font-heading); color: var(--text-primary); margin-bottom: 1.2rem; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fa-solid fa-link text-cyan"></i> Menu Cepat
            </h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; font-size: 0.9rem;">
                <a href="{{ route('home') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fa-solid fa-house" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> Beranda
                </a>
                <a href="{{ route('services') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fa-solid fa-laptop-code" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> Jasa Pembuatan
                </a>
                <a href="{{ route('topup') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fa-solid fa-gamepad" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> Top-Up Game
                </a>
                <a href="{{ route('cv-maker') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fa-solid fa-file-invoice" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> CV ATS Gratis
                </a>
                <a href="{{ route('cover-letter') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> AI Cover Letter
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                            <i class="fa-solid fa-user-gear" style="font-size: 0.8rem; margin-right: 0.3rem;"></i> Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Right Col: Layanan Utama -->
        <div>
            <h4 style="font-family: var(--font-heading); color: var(--text-primary); margin-bottom: 1.2rem; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fa-solid fa-gears text-cyan"></i> Layanan Populer
            </h4>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem; display: flex; flex-direction: column; gap: 0.6rem; color: var(--text-secondary);">
                <li><i class="fa-solid fa-circle-check text-cyan" style="margin-right: 0.5rem; font-size: 0.8rem;"></i> Website Portfolio Bisnis</li>
                <li><i class="fa-solid fa-circle-check text-cyan" style="margin-right: 0.5rem; font-size: 0.8rem;"></i> Top Up Game Otomatis 24 Jam</li>
                <li><i class="fa-solid fa-circle-check text-cyan" style="margin-right: 0.5rem; font-size: 0.8rem;"></i> AI Cover Letter Generator</li>
            </ul>
        </div>

    </div>
</footer>

