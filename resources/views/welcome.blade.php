<x-layouts.app>
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="pulse-dot"></span> Digital Agency Space Enterprise
                </div>
                <h1 class="hero-title">
                    Solusi Digital Modern <br><span class="gradient-text">FSHOP Agency</span>
                </h1>
                <p class="hero-subtitle">
                    Mitra terpercaya untuk <strong>Jasa Pembuatan Web</strong>, <strong>Aplikasi Mobile</strong>, <strong>Landing Page</strong>, <strong>Poster &amp; Banner</strong>, <strong>Jasa Tugas</strong>, serta <strong>CV Gratis</strong> dengan performa ultra-ringan &amp; UI Glassmorphic futuristik.
                </p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary">
                        Jelajahi Layanan <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="#cv-maker" class="btn btn-outline">
                        <i class="fa-solid fa-file-invoice"></i> Buat CV Gratis
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="space-hero-globe">
                    <i class="fa-solid fa-rocket"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Catalog Component -->
    @livewire('services.services-list')

    <!-- Topup Game & PPOB Component -->
    @livewire('topup.topup-list')

    <!-- Free CV Generator Component -->
    @livewire('cv-generator.free-cv-maker')

    <!-- AI Cover Letter Generator Component -->
    @livewire('cover-letter.cover-letter-generator')

    <!-- Why Choose Us / Advantage Section -->
    <section id="why-us">
        <div class="section-header">
            <p class="section-tag">ADVANTAGES</p>
            <h2 class="section-title">Mengapa Memilih <span class="gradient-text">FSHOP</span>?</h2>
        </div>
        <div class="services-grid">
            <div class="glass-card" style="padding: 2rem; text-align: center;">
                <div class="service-icon-box" style="margin: 0 auto 1.2rem;">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h3 style="margin-bottom: 0.8rem; color: var(--text-primary);">Ultra Fast &amp; Light</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Aplikasi dikembangkan dengan arsitektur bersih Laravel &amp; Livewire 3 tanpa bloatware berat.</p>
            </div>


            <div class="glass-card" style="padding: 2rem; text-align: center;">
                <div class="service-icon-box" style="margin: 0 auto 1.2rem;">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 style="margin-bottom: 0.8rem; color: var(--text-primary);">Order Direct WhatsApp</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Proses order sangat mudah tanpa perlu login ribet. Cukup pilih paket, konsultasi langsung di WhatsApp.</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq">
        <div class="section-header">
            <p class="section-tag">FAQ</p>
            <h2 class="section-title">Pertanyaan Sering Diajukan</h2>
        </div>
        <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem;">
            <div class="glass-card" style="padding: 1.5rem;">
                <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-question"></i> Berapa lama pengerjaan pembuatan website?</h4>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Untuk Landing page / Portfolio berkisar 1-2 hari. Untuk website custom kompleks atau aplikasi mobile berkisar 3-7 hari kerja.</p>
            </div>
            <div class="glass-card" style="padding: 1.5rem;">
                <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-question"></i> Apakah pembuatan CV benar-benar 100% Gratis?</h4>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Ya! Fitur CV Generator di FSHOP dapat Anda gunakan sepenuhnya gratis tanpa dipungut biaya apapun, langsung bisa dicetak/disimpan ke PDF.</p>
            </div>
            <div class="glass-card" style="padding: 1.5rem;">
                <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-question"></i> Bagaimana sistem pembayaran jasa tugas &amp; desain?</h4>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Pembayaran fleksibel via Transfer Bank / E-Wallet (DANA, OVO, GoPay, ShopeePay) setelah kesepakatan detail tugas atau konsep desain.</p>
            </div>
        </div>
    </section>

    <!-- Order Checkout Global Modal -->
    @livewire('orders.order-checkout-modal')
</x-layouts.app>
