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
                    Mitra terpercaya untuk <strong>Jasa Pembuatan Web</strong>, <strong>Aplikasi Mobile</strong>, <strong>Landing Page</strong>, <strong>Portofolio Kreatif</strong>, <strong>Poster &amp; Banner</strong>, serta <strong>CV Gratis</strong> dengan performa ultra-ringan &amp; UI Glassmorphic futuristik.
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

    <!-- Main Features / Services Selector Grid -->
    <section id="features-menu" style="padding: 4rem 2rem;">
        <div class="section-header text-center" style="margin-bottom: 3rem;">
            <p class="section-tag">FITUR UNGGULAN</p>
            <h2 class="section-title">Pilih <span class="gradient-text">Layanan Digital</span> FSHOP</h2>
            <p class="section-subtitle">Akses semua fitur kami secara instan dan nikmati kemudahan transaksi.</p>
        </div>
        <div class="services-grid" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            
            <!-- Layanan Jasa -->
            <div class="glass-card" style="padding: 2.5rem 2rem; display: flex; flex-direction: column; height: 100%; text-align: center; align-items: center; justify-content: space-between; gap: 1.5rem;">
                <div>
                    <div class="service-icon-box cyan" style="margin: 0 auto 1.5rem; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: rgba(0, 206, 201, 0.1); border: 2px solid #00cec9; color: #00cec9; box-shadow: 0 0 15px rgba(0, 206, 201, 0.2);">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 style="margin-bottom: 0.8rem; color: var(--text-primary); font-family: var(--font-heading); font-size: 1.3rem;">Jasa Pembuatan Web &amp; Apps</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin: 0;">Solusi Jasa Pembuatan Website Portfolio Pribadi, Landing Page Bisnis, Aplikasi Mobile Custom, serta Desain Poster &amp; Banner.</p>
                </div>
                <a href="{{ route('services') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    Buka Layanan <i class="fa-solid fa-chevron-right" style="margin-left: 0.4rem; font-size: 0.8rem;"></i>
                </a>
            </div>

            <!-- Topup Game & PPOB -->
            <div class="glass-card" style="padding: 2.5rem 2rem; display: flex; flex-direction: column; height: 100%; text-align: center; align-items: center; justify-content: space-between; gap: 1.5rem;">
                <div>
                    <div class="service-icon-box pink" style="margin: 0 auto 1.5rem; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: rgba(253, 121, 168, 0.1); border: 2px solid #fd79a8; color: #fd79a8; box-shadow: 0 0 15px rgba(253, 121, 168, 0.2);">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                    <h3 style="margin-bottom: 0.8rem; color: var(--text-primary); font-family: var(--font-heading); font-size: 1.3rem;">Top-Up Game &amp; PPOB</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin: 0;">Isi ulang Diamond MLBB, Free Fire, UC PUBG Mobile, VP Valorant, Pulsa, Token Listrik PLN instan otomatis 24 jam dengan harga termurah.</p>
                </div>
                <a href="{{ route('topup') }}" class="btn btn-outline" style="width: 100%; justify-content: center; border-color: var(--primary-color); color: var(--text-primary);">
                    Mulai Top Up <i class="fa-solid fa-chevron-right" style="margin-left: 0.4rem; font-size: 0.8rem;"></i>
                </a>
            </div>

            <!-- Buat CV Gratis -->
            <div class="glass-card" style="padding: 2.5rem 2rem; display: flex; flex-direction: column; height: 100%; text-align: center; align-items: center; justify-content: space-between; gap: 1.5rem;">
                <div>
                    <div class="service-icon-box purple" style="margin: 0 auto 1.5rem; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: rgba(108, 92, 231, 0.1); border: 2px solid #6c5ce7; color: #6c5ce7; box-shadow: 0 0 15px rgba(108, 92, 231, 0.2);">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 style="margin-bottom: 0.8rem; color: var(--text-primary); font-family: var(--font-heading); font-size: 1.3rem;">Buat CV ATS &amp; Kreatif</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin: 0;">Bikin CV ATS Friendly atau CV Kreatif Visual secara online gratis. Preview realtime, kustom warna, dan download langsung format PDF / JPG.</p>
                </div>
                <a href="{{ route('cv-maker') }}" class="btn btn-outline" style="width: 100%; justify-content: center; border-color: var(--primary-color); color: var(--text-primary);">
                    Buat CV Sekarang <i class="fa-solid fa-chevron-right" style="margin-left: 0.4rem; font-size: 0.8rem;"></i>
                </a>
            </div>

            <!-- AI Cover Letter -->
            <div class="glass-card" style="padding: 2.5rem 2rem; display: flex; flex-direction: column; height: 100%; text-align: center; align-items: center; justify-content: space-between; gap: 1.5rem;">
                <div>
                    <div class="service-icon-box magenta" style="margin: 0 auto 1.5rem; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: rgba(224, 86, 253, 0.1); border: 2px solid #e056fd; color: #e056fd; box-shadow: 0 0 15px rgba(224, 86, 253, 0.2);">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 style="margin-bottom: 0.8rem; color: var(--text-primary); font-family: var(--font-heading); font-size: 1.3rem;">AI Cover Letter</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin: 0;">Tulis surat lamaran kerja otomatis menggunakan kecerdasan buatan. Pilihan tone bahasa, profesional, resmi, atau antusias.</p>
                </div>
                <a href="{{ route('cover-letter') }}" class="btn btn-outline" style="width: 100%; justify-content: center; border-color: var(--primary-color); color: var(--text-primary);">
                    Buka AI Generator <i class="fa-solid fa-chevron-right" style="margin-left: 0.4rem; font-size: 0.8rem;"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- Portfolio Section (Separated on Landing Page) -->
    <section id="portfolio" style="padding: 5rem 2rem; background: rgba(0, 0, 0, 0.2); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="section-header text-center" style="margin-bottom: 4rem;">
            <p class="section-tag">RECENT WORKS</p>
            <h2 class="section-title">Portofolio Showcase <span class="gradient-text">FSHOP Agency</span></h2>
            <p class="section-subtitle">Intip beberapa karya digital terbaik yang telah selesai kami kerjakan dengan hasil memuaskan.</p>
        </div>
        
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
            <!-- Portfolio Item 1 -->
            <div class="glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80" alt="SaaS Dashboard" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent, rgba(7, 9, 19, 0.95));"></div>
                    <span class="tag-badge" style="position: absolute; top: 1rem; right: 1rem; background: var(--primary-color);">Web App</span>
                </div>
                <div style="padding: 1.5rem 1.8rem 1.8rem;">
                    <h3 style="color: #ffffff; font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 0.5rem;">SaaS Dashboard Analytics</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Platform analitik bisnis real-time dengan visualisasi grafik interaktif &amp; performa ultra cepat.</p>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-badge" style="font-size: 0.7rem;">Laravel</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">Alpine.js</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">Tailwind</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 2 -->
            <div class="glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?auto=format&fit=crop&w=600&q=80" alt="E-Commerce Space" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent, rgba(7, 9, 19, 0.95));"></div>
                    <span class="tag-badge" style="position: absolute; top: 1rem; right: 1rem; background: #00cec9;">E-Commerce</span>
                </div>
                <div style="padding: 1.5rem 1.8rem 1.8rem;">
                    <h3 style="color: #ffffff; font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 0.5rem;">Space Nebula Shop</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Toko digital instan dengan integrasi payment gateway otomatis Doku &amp; invoice realtime.</p>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-badge" style="font-size: 0.7rem;">Livewire</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">MySQL</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">Doku API</span>
                    </div>
                </div>
            </div>

            <!-- Portfolio Item 3 -->
            <div class="glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?auto=format&fit=crop&w=600&q=80" alt="Company Profile" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent, rgba(7, 9, 19, 0.95));"></div>
                    <span class="tag-badge" style="position: absolute; top: 1rem; right: 1rem; background: #fd79a8;">Mobile UI/UX</span>
                </div>
                <div style="padding: 1.5rem 1.8rem 1.8rem;">
                    <h3 style="color: #ffffff; font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 0.5rem;">Crypto Wallet App</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Desain antarmuka dompet kripto dengan sistem keamanan sidik jari &amp; tema neon dark mode.</p>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-badge" style="font-size: 0.7rem;">Figma</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">Prototyping</span>
                        <span class="tag-badge" style="font-size: 0.7rem;">Design System</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

</x-layouts.app>
