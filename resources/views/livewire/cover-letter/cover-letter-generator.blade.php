<section id="cover-letter" class="cover-letter-section">
    <div class="section-container">
        <div class="section-header text-center" style="margin-bottom: 2.5rem;">
            <div class="ai-badge-header">
                <span class="ai-sparkle-dot"><i class="fa-solid fa-wand-magic-sparkles"></i></span> POWERED BY FSHOP AI ENGINE
            </div>
            <h2 class="section-title">
                AI <span class="gradient-text">COVER LETTER</span> GENERATOR
            </h2>
            <p class="section-subtitle">
                Buat Surat Lamaran Kerja (Cover Letter) otomatis yang profesional, memikat HRD, dan disesuaikan dengan posisi impian Anda dalam hitungan detik!
            </p>
        </div>

        <div class="cover-letter-grid">
            <!-- Left Column: Form Inputs -->
            <div class="glass-card cl-form-card">
                <h3 class="cl-card-title">
                    <i class="fa-solid fa-pen-to-square"></i> Data Lamaran Kerja
                </h3>

                <form wire:submit.prevent="generateLetter" class="cl-form">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-input" wire:model="fullName" placeholder="Contoh: Budi Santoso, S.Kom">
                        @error('fullName') <span class="text-danger-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" wire:model="email" placeholder="budi@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. WhatsApp / HP</label>
                            <input type="text" class="form-input" wire:model="phone" placeholder="081234567890">
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Perusahaan Tujuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-input" wire:model="targetCompany" placeholder="Contoh: PT Technology Indonesia">
                            @error('targetCompany') <span class="text-danger-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Posisi yang Dilamar <span class="text-danger">*</span></label>
                            <input type="text" class="form-input" wire:model="targetPosition" placeholder="Contoh: Web Developer / Graphic Designer">
                            @error('targetPosition') <span class="text-danger-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Pengalaman Kerja</label>
                            <select class="form-input" wire:model="experienceYears">
                                <option value="Fresh Graduate / Tanpa Pengalaman">Fresh Graduate / Tanpa Pengalaman</option>
                                <option value="1-2 tahun">1 - 2 Tahun Pengalaman</option>
                                <option value="3-5 tahun">3 - 5 Tahun Pengalaman</option>
                                <option value="Lebih dari 5 tahun">Lebih dari 5 Tahun Pengalaman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gaya Bahasa (Tone)</label>
                            <select class="form-input" wire:model="workTone">
                                <option value="profesional">Profesional &amp; Modern</option>
                                <option value="antusias">Antusias &amp; Penuh Semangat</option>
                                <option value="formal">Formal &amp; Resmi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keahlian Utama (Skill Keyphrase)</label>
                        <textarea class="form-input" wire:model="keySkills" rows="2" placeholder="Contoh: Laravel, Livewire, UI/UX Design, Komunikasi Tim, Problem Solving"></textarea>
                    </div>

                    <div class="cl-btn-group">
                        <button type="submit" class="btn btn-primary ai-generate-btn">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Surat Lamaran AI
                        </button>
                        @if($isGenerated)
                            <button type="button" class="btn btn-outline" wire:click="resetForm">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Right Column: Live Result Paper -->
            <div class="glass-card cl-result-card">
                <div class="cl-result-header">
                    <h3 class="cl-card-title">
                        <i class="fa-solid fa-file-contract"></i> Hasil Surat Lamaran (Preview)
                    </h3>
                    @if($isGenerated)
                        <span class="badge-success"><i class="fa-solid fa-check"></i> Ready to Export</span>
                    @endif
                </div>

                <div class="cl-paper-box" id="clPaperPreview">
                    @if($generatedLetter)
                        <pre class="cl-paper-text">{{ $generatedLetter }}</pre>
                    @else
                        <div class="cl-empty-placeholder">
                            <i class="fa-solid fa-robot ai-placeholder-icon"></i>
                            <h4>Belum Ada Surat yang Di-generate</h4>
                            <p>Isi formulir di sebelah kiri dan klik tombol <strong>Generate Surat Lamaran AI</strong> untuk membuat surat otomatis.</p>
                        </div>
                    @endif
                </div>

                @if($isGenerated)
                    <div class="cl-export-actions">
                        <button type="button" class="btn btn-outline" onclick="copyClToClipboard()">
                            <i class="fa-solid fa-copy"></i> Salin Teks
                        </button>
                        <button type="button" class="btn btn-primary" onclick="downloadClAsTxt()">
                            <i class="fa-solid fa-download"></i> Download Teks (.txt)
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyClToClipboard() {
            const text = document.querySelector('.cl-paper-text')?.innerText;
            if (text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Surat Lamaran Kerja berhasil disalin ke clipboard!');
                });
            }
        }

        function downloadClAsTxt() {
            const text = document.querySelector('.cl-paper-text')?.innerText;
            if (text) {
                const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'Surat_Lamaran_Kerja_FSHOP.txt';
                link.click();
            }
        }
    </script>
</section>
