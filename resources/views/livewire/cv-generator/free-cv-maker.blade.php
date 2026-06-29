<section id="cv-maker">
    <div class="section-header">
        <p class="section-tag">FREE TOOL</p>
        <h2 class="section-title">Pembuat <span class="gradient-text">CV Gratis</span> Realtime</h2>
    </div>

    @if($step === 'choose')
        <!-- Template Selection Screen -->
        <div class="template-select-container">
            <div class="template-select-header">
                <h3>Pilih Format &amp; Gaya CV Anda</h3>
                <p>Pilihlah tipe CV yang sesuai dengan kebutuhan lamaran kerja Anda sebelum mengisi data.</p>
            </div>

            <div class="template-grid">
                <!-- Card 1: CV ATS -->
                <div class="template-card {{ $selectedTemplate === 'ats' ? 'active' : '' }}">
                    <div class="template-badge badge-ats"><i class="fa-solid fa-file-contract"></i> Ramah HRD / ATS</div>
                    <div class="template-icon">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h4>CV ATS (Standard Formal)</h4>
                    <p>Format klasik hitam-putih yang sangat mudah dibaca oleh sistem rekrutmen otomatis (ATS). Dilengkapi foto profil, tata letak rapi, dan QR Code Portofolio.</p>
                    <ul class="template-features">
                        <li><i class="fa-solid fa-check"></i> Layout 1 Kolom Ringkas</li>
                        <li><i class="fa-solid fa-check"></i> Ikon Kontak &amp; QR Code Portofolio</li>
                        <li><i class="fa-solid fa-check"></i> Sangat cocok untuk Perusahaan BUMN &amp; Corporate</li>
                    </ul>
                    <button wire:click="selectTemplate('ats')" class="btn btn-primary btn-block">
                        Gunakan CV ATS <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Card 2: CV Creative -->
                <div class="template-card {{ $selectedTemplate === 'creative' ? 'active' : '' }}">
                    <div class="template-badge badge-creative"><i class="fa-solid fa-wand-magic-sparkles"></i> Visual &amp; Warna</div>
                    <div class="template-icon">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <h4>CV Creative (Modern Design)</h4>
                    <p>Tata letak kreatif 2-kolom dengan kombinasi warna menarik, sidebar profil, badge keahlian modern, serta pilihan kustomisasi tema warna visual.</p>
                    <ul class="template-features">
                        <li><i class="fa-solid fa-check"></i> Layout Modern 2-Kolom &amp; Sidebar</li>
                        <li><i class="fa-solid fa-check"></i> Pilihan Tema Warna (Purple, Blue, Emerald, Sunset)</li>
                        <li><i class="fa-solid fa-check"></i> Cocok untuk Startup, Agency, UI/UX &amp; Designer</li>
                    </ul>
                    <button wire:click="selectTemplate('creative')" class="btn btn-outline btn-block" style="border-color: var(--primary-color); color: var(--text-primary);">
                        Gunakan CV Creative <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Editor Mode -->
        <div class="cv-editor-bar glass-card">
            <div class="template-info">
                <span class="active-badge">
                    @if($selectedTemplate === 'ats')
                        <i class="fa-solid fa-file-contract"></i> Mode: <strong>CV ATS Standard</strong>
                    @else
                        <i class="fa-solid fa-palette"></i> Mode: <strong>CV Creative Modern</strong>
                    @endif
                </span>
                <button wire:click="switchTemplate" class="btn-change-template">
                    <i class="fa-solid fa-rotate"></i> Ganti Format CV
                </button>
            </div>

            <div style="display: flex; align-items: center; gap: 0.8rem; flex-wrap: wrap;">
                <span style="font-size: 0.8rem; color: #2ed573; display: inline-flex; align-items: center; gap: 0.3rem; background: rgba(46, 213, 115, 0.1); padding: 0.3rem 0.6rem; border-radius: 20px; border: 1px solid rgba(46, 213, 115, 0.2);">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Autosave Aktif (Privat)
                </span>

                @if($selectedTemplate === 'creative')
                    <div class="color-picker-group">
                        <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-secondary);">Tema:</span>
                        <button wire:click="setTheme('purple')" class="color-btn btn-purple {{ $creativeTheme === 'purple' ? 'active' : '' }}" title="Space Purple"></button>
                        <button wire:click="setTheme('blue')" class="color-btn btn-blue {{ $creativeTheme === 'blue' ? 'active' : '' }}" title="Ocean Blue"></button>
                        <button wire:click="setTheme('emerald')" class="color-btn btn-emerald {{ $creativeTheme === 'emerald' ? 'active' : '' }}" title="Emerald Green"></button>
                        <button wire:click="setTheme('sunset')" class="color-btn btn-sunset {{ $creativeTheme === 'sunset' ? 'active' : '' }}" title="Sunset Orange"></button>
                    </div>
                @endif

                <button wire:click="resetCvData" onclick="return confirm('Apakah Anda yakin ingin mengosongkan form CV ini?')" class="btn-change-template" style="color: #ff4757; border-color: rgba(255,71,87,0.3);" title="Reset Form">
                    <i class="fa-solid fa-trash-can"></i> Reset Form
                </button>

                <button class="btn btn-primary btn-sm" onclick="exportCvToPdf(event)">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF (A4)
                </button>
                <button class="btn btn-outline btn-sm" onclick="exportCvToJpg(event)" style="border-color: var(--primary-color); color: var(--text-primary);">
                    <i class="fa-solid fa-file-image"></i> Download JPG
                </button>
            </div>
        </div>

        <div class="cv-builder-grid">
            <!-- Input Form Side -->
            <div class="glass-card" style="padding: 1.8rem;">
                <h3 style="margin-bottom: 1.2rem; color: var(--primary-color); font-size: 1.1rem;">
                    <i class="fa-solid fa-pen-to-square"></i> Isi Data CV Anda
                </h3>

                <!-- Data Pribadi & Foto -->
                <div class="form-group-title"><i class="fa-solid fa-user"></i> Data Pribadi &amp; Foto</div>
                
                <div class="form-group">
                    <label class="form-label">Foto Profil (Upload dari Perangkat / URL) <span style="font-weight: normal; color: #ef4444; font-size: 0.75rem;">*Maks. 3 MB</span></label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;">
                        <div>
                            <input type="file" class="form-input" wire:model="photo" accept="image/*" style="padding: 0.4rem; font-size: 0.8rem;">
                            <div style="font-size: 0.72rem; color: var(--text-muted, #94a3b8); margin-top: 0.25rem;">Maksimal ukuran file 3 MB (JPG/PNG)</div>
                            <div wire:loading wire:target="photo" style="font-size: 0.75rem; color: var(--primary-color); margin-top: 0.2rem;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Mengunggah foto...
                            </div>
                            @error('photo')
                                <div style="font-size: 0.75rem; color: #ef4444; margin-top: 0.2rem;"><i class="fa-solid fa-circle-exclamation"></i> File melebihi batas 3 MB</div>
                            @enderror
                        </div>
                        <div>
                            <input type="text" class="form-input" wire:model.live="photoUrl" placeholder="Atau tempel URL Gambar">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-input" wire:model.live="fullName" placeholder="Contoh: FAJAR NUR FARRIJAL">
                </div>

                <div class="form-group">
                    <label class="form-label">Profesi / Judul Karir</label>
                    <input type="text" class="form-input" wire:model.live="jobTitle" placeholder="Contoh: WEB DEVELOPER, UI/UX DESIGNER">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" wire:model.live="email" placeholder="email@domain.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Telepon / WA</label>
                        <input type="text" class="form-input" wire:model.live="phone" placeholder="08123456789">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat / Lokasi</label>
                    <input type="text" class="form-input" wire:model.live="address" placeholder="Kota, Provinsi">
                </div>

                <!-- Tautan & Sosial Media -->
                <div class="form-group-title" style="margin-top: 1.2rem;"><i class="fa-solid fa-share-nodes"></i> Portofolio &amp; Media Sosial</div>

                <div class="form-group">
                    <label class="form-label">URL Portofolio Web / Blog</label>
                    <input type="text" class="form-input" wire:model.live="portfolioUrl" placeholder="https://portofolio-anda.com">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;">
                    <div class="form-group">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" class="form-input" wire:model.live="socialLinkedin" placeholder="linkedin.com/in/username">
                    </div>
                    <div class="form-group">
                        <label class="form-label">GitHub</label>
                        <input type="text" class="form-input" wire:model.live="socialGithub" placeholder="github.com/username">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-top: 0.6rem;">
                    <div class="form-group">
                        <label class="form-label">Instagram</label>
                        <input type="text" class="form-input" wire:model.live="socialInstagram" placeholder="instagram.com/username">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Facebook</label>
                        <input type="text" class="form-input" wire:model.live="socialFacebook" placeholder="facebook.com/username">
                    </div>
                </div>

                <!-- Riwayat & Keahlian -->
                <div class="form-group-title" style="margin-top: 1.2rem;"><i class="fa-solid fa-briefcase"></i> Detail Riwayat</div>

                <div class="form-group">
                    <label class="form-label">Ringkasan Profil (Tentang Saya)</label>
                    <textarea class="form-textarea" rows="3" wire:model.live="summary" placeholder="Deskripsikan keahlian dan latar belakang Anda..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Pengalaman Kerja / Proyek</label>
                    <textarea class="form-textarea" rows="4" wire:model.live="experience" placeholder="IT Support - PT ABC&#10;Deskripsi kerjaan..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Pendidikan</label>
                    <textarea class="form-textarea" rows="2" wire:model.live="education" placeholder="S1 Informatika - Universitas XYZ..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Keahlian (Skills - Pisahkan dengan koma)</label>
                    <input type="text" class="form-input" wire:model.live="skills">
                </div>
            </div>

            <!-- Live Preview Paper Side -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <h3 style="color: var(--text-primary); font-size: 1.1rem;">
                        <i class="fa-solid fa-eye"></i> Pratinjau Lembar CV
                    </h3>
                </div>

                @if($selectedTemplate === 'ats')
                    <!-- ATS Paper Preview (Matching Screenshot exact design) -->
                    <div class="cv-paper-preview cv-paper-ats" id="printableCv">
                        <!-- Header Box: Photo Left, Name Right -->
                        <div class="ats-header">
                            <div class="ats-photo-box">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="Foto {{ $fullName }}" class="ats-photo">
                                @else
                                    <div class="ats-photo-placeholder"><i class="fa-solid fa-user"></i></div>
                                @endif
                            </div>
                            <div class="ats-header-text">
                                <h1 class="ats-title">{{ strtoupper($fullName ?: 'NAMA LENGKAP') }}</h1>
                                <p class="ats-subtitle">{{ strtoupper($jobTitle ?: 'PROFESI / JUDUL KARIR') }}</p>
                            </div>
                        </div>

                        <!-- Contact Bar with Icons -->
                        <div class="ats-contact-bar">
                            <span><i class="fa-solid fa-phone"></i> {{ $phone ?: '08123456789' }}</span>
                            <span><i class="fa-solid fa-envelope"></i> {{ $email ?: 'email@domain.com' }}</span>
                            <span><i class="fa-solid fa-location-dot"></i> {{ $address ?: 'Lokasi' }}</span>
                        </div>

                        <!-- Content Sections -->
                        <div class="ats-section-title">TENTANG SAYA</div>
                        <p class="ats-text">{{ $summary }}</p>

                        <div class="ats-section-title">PENGALAMAN</div>
                        <div class="ats-text" style="white-space: pre-line;">{{ $experience }}</div>

                        <div class="ats-section-title">PENDIDIKAN</div>
                        <div class="ats-text" style="white-space: pre-line;">{{ $education }}</div>

                        <div class="ats-section-title">KETERAMPILAN</div>
                        <ul class="ats-skills-list">
                            @foreach(array_map('trim', explode(',', $skills)) as $skillItem)
                                @if(!empty($skillItem))
                                    <li>{{ $skillItem }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @else
                    <!-- Creative Paper Preview (Modern 2-Column Visual design) -->
                    <div class="cv-paper-preview cv-paper-creative theme-{{ $creativeTheme }}" id="printableCv">
                        <!-- Left Sidebar Column -->
                        <div class="creative-sidebar">
                            <div class="creative-photo-container">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="Foto {{ $fullName }}" class="creative-photo">
                                @else
                                    <div class="creative-photo-placeholder"><i class="fa-solid fa-user"></i></div>
                                @endif
                            </div>

                            <div class="creative-sidebar-section">
                                <h5>KONTAK</h5>
                                <div class="creative-contact-item"><i class="fa-solid fa-envelope"></i> {{ $email ?: 'email@domain.com' }}</div>
                                <div class="creative-contact-item"><i class="fa-solid fa-phone"></i> {{ $phone ?: '08123456789' }}</div>
                                <div class="creative-contact-item"><i class="fa-solid fa-location-dot"></i> {{ $address ?: 'Lokasi' }}</div>
                            </div>

                            @if($socialLinkedin || $socialGithub || $socialInstagram || $socialFacebook || $portfolioUrl)
                                <div class="creative-sidebar-section">
                                    <h5>SOSIAL MEDIA</h5>
                                    @if($socialLinkedin)<div class="creative-contact-item"><i class="fa-brands fa-linkedin"></i> {{ $socialLinkedin }}</div>@endif
                                    @if($socialGithub)<div class="creative-contact-item"><i class="fa-brands fa-github"></i> {{ $socialGithub }}</div>@endif
                                    @if($socialInstagram)<div class="creative-contact-item"><i class="fa-brands fa-instagram"></i> {{ $socialInstagram }}</div>@endif
                                    @if($socialFacebook)<div class="creative-contact-item"><i class="fa-brands fa-facebook"></i> {{ $socialFacebook }}</div>@endif
                                    @if($portfolioUrl)<div class="creative-contact-item"><i class="fa-solid fa-globe"></i> {{ $portfolioUrl }}</div>@endif
                                </div>
                            @endif

                            <div class="creative-sidebar-section">
                                <h5>KEAHLIAN</h5>
                                <div class="creative-skills-badges">
                                    @foreach(array_map('trim', explode(',', $skills)) as $skillItem)
                                        @if(!empty($skillItem))
                                            <span class="creative-skill-badge">{{ $skillItem }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Right Main Column -->
                        <div class="creative-main">
                            <div class="creative-header">
                                <h1 class="creative-name">{{ $fullName ?: 'NAMA LENGKAP' }}</h1>
                                <p class="creative-title-text">{{ $jobTitle ?: 'PROFESI / JUDUL KARIR' }}</p>
                            </div>

                            <div class="creative-section-title">PROFIL PROFESIONAL</div>
                            <p class="creative-body-text">{{ $summary }}</p>

                            <div class="creative-section-title">PENGALAMAN KERJA</div>
                            <div class="creative-body-text" style="white-space: pre-line;">{{ $experience }}</div>

                            <div class="creative-section-title">RIWAYAT PENDIDIKAN</div>
                            <div class="creative-body-text" style="white-space: pre-line;">{{ $education }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>

@script
<script>
    const STORAGE_KEY = 'fshop_cv_draft_v1';

    function saveDraft() {
        try {
            const data = {
                fullName: $wire.fullName,
                jobTitle: $wire.jobTitle,
                email: $wire.email,
                phone: $wire.phone,
                address: $wire.address,
                photoUrl: $wire.photoUrl,
                portfolioUrl: $wire.portfolioUrl,
                socialLinkedin: $wire.socialLinkedin,
                socialGithub: $wire.socialGithub,
                socialInstagram: $wire.socialInstagram,
                socialFacebook: $wire.socialFacebook,
                summary: $wire.summary,
                experience: $wire.experience,
                education: $wire.education,
                skills: $wire.skills,
                selectedTemplate: $wire.selectedTemplate,
                creativeTheme: $wire.creativeTheme
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (e) {
            console.warn('Could not save draft to localStorage', e);
        }
    }

    // Restore draft on load
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
        try {
            const parsed = JSON.parse(saved);
            Object.keys(parsed).forEach(key => {
                if (parsed[key] !== undefined && parsed[key] !== null) {
                    $wire.set(key, parsed[key], false);
                }
            });
        } catch(e){}
    }

    // Listen to commits to save changes automatically
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            saveDraft();
        });
    });
</script>
@endscript

<!-- Client-side PDF & Image Generation Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    async function exportCvToJpg(evt) {
        const element = document.getElementById('printableCv');
        if (!element) return;

        const btn = evt.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses JPG...';
        btn.disabled = true;

        try {
            const canvas = await html2canvas(element, {
                scale: 2, // High DPI
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff'
            });

            const name = document.querySelector('.ats-title, .creative-name')?.innerText || 'CV_Document';
            const baseFileName = name.trim().replace(/[^a-zA-Z0-9]/g, '_');

            // Standard A4 aspect height relative to rendered canvas width
            const pageCanvasHeight = (canvas.width * 297) / 210;
            const totalPages = Math.ceil((canvas.height - 5) / pageCanvasHeight);

            if (totalPages <= 1) {
                // Single page download
                const link = document.createElement('a');
                link.download = baseFileName + '_A4.jpg';
                link.href = canvas.toDataURL('image/jpeg', 0.95);
                link.click();
            } else {
                // Multi-page JPG download (Slicing into separate page files automatically)
                for (let pageIndex = 0; pageIndex < totalPages; pageIndex++) {
                    const pageCanvas = document.createElement('canvas');
                    pageCanvas.width = canvas.width;
                    pageCanvas.height = pageCanvasHeight; // maintain clean A4 frame

                    const sourceY = pageIndex * pageCanvasHeight;
                    const sourceH = Math.min(pageCanvasHeight, canvas.height - sourceY);

                    const pageCtx = pageCanvas.getContext('2d');
                    pageCtx.fillStyle = '#ffffff';
                    pageCtx.fillRect(0, 0, pageCanvas.width, pageCanvas.height);
                    pageCtx.drawImage(
                        canvas,
                        0, sourceY, canvas.width, sourceH,
                        0, 0, canvas.width, sourceH
                    );

                    const link = document.createElement('a');
                    link.download = baseFileName + '_Halaman_' + (pageIndex + 1) + '.jpg';
                    link.href = pageCanvas.toDataURL('image/jpeg', 0.95);
                    link.click();

                    // Short delay between triggers to handle browser downloads smoothly
                    await new Promise(resolve => setTimeout(resolve, 300));
                }
            }
        } catch (err) {
            alert('Gagal mengunduh Gambar JPG: ' + err.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    async function exportCvToPdf(evt) {
        const element = document.getElementById('printableCv');
        if (!element) return;

        const btn = evt.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses PDF A4...';
        btn.disabled = true;

        try {
            const canvas = await html2canvas(element, {
                scale: 2, // High resolution rendering
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff'
            });

            const imgData = canvas.toDataURL('image/jpeg', 0.98);
            const { jsPDF } = window.jspdf;
            
            // Standard A4 Portrait in mm (210mm x 297mm)
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pdfWidth = 210;
            const pdfHeight = 297;

            // Calculate total height in mm to preserve exact aspect ratio
            const imgWidth = pdfWidth;
            const imgHeight = (canvas.height * pdfWidth) / canvas.width;

            let heightLeft = imgHeight;
            let position = 0;

            // Add Page 1
            pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Multi-page slicing if content exceeds 1 A4 page (297mm) into 1 single PDF document
            while (heightLeft > 5) {
                position -= pdfHeight; // Move Y offset up by 1 page height
                pdf.addPage();
                pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
                heightLeft -= pdfHeight;
            }

            const name = document.querySelector('.ats-title, .creative-name')?.innerText || 'CV_Document';
            const fileName = name.trim().replace(/[^a-zA-Z0-9]/g, '_') + '_A4.pdf';
            pdf.save(fileName);
        } catch (err) {
            alert('Gagal mengunduh file PDF: ' + err.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>


