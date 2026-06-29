<div class="modal-overlay {{ $isOpen ? 'show' : '' }}">
    <div class="modal-content-box glass-card">
        <button class="modal-close-btn" wire:click="closeCheckout">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div class="service-icon-box" style="margin: 0 auto 1rem;">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <span class="section-tag">FORM PEMESANAN</span>
            <h2 style="font-size: 1.6rem; color: var(--text-primary);">Order: {{ $serviceTitle }}</h2>
        </div>

        <form wire:submit.prevent="processWhatsAppOrder">
            <div class="form-group">
                <label class="form-label">Nama Lengkap Anda</label>
                <input type="text" class="form-input" wire:model="customerName" required placeholder="Masukkan nama Anda">
            </div>

            <div class="form-group">
                <label class="form-label">No. WhatsApp / HP</label>
                <input type="text" class="form-input" wire:model="customerPhone" required placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label class="form-label">Prioritas / Target Tenggat Waktu</label>
                <select class="form-select" wire:model="deadline">
                    <option value="Santai (3-5 Hari)">Santai (3-5 Hari)</option>
                    <option value="Standard (1-2 Hari)">Standard (1-2 Hari)</option>
                    <option value="Kilat Express (< 24 Jam)">Kilat Express (&lt; 24 Jam)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Spesifikasi / Requirement Project</label>
                <textarea class="form-textarea" rows="3" wire:model="notes" placeholder="Jelaskan gambaran website, konsep poster, atau detail tugas yang Anda inginkan..."></textarea>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Kirim Pesanan ke WhatsApp Admin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('openUrlInNewTab', (event) => {
            window.open(event.url, '_blank');
        });
    });

    function triggerOrder(serviceId, serviceTitle) {
        Livewire.dispatch('openOrderCheckout', { serviceId: serviceId, serviceTitle: serviceTitle });
    }
</script>
