<div class="modal-overlay {{ $isOpen ? 'show' : '' }}">
    @if($service)
        <div class="modal-content-box glass-card">
            <button class="modal-close-btn" wire:click="closeModal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div style="border-radius: var(--radius-md); overflow: hidden; height: 180px; margin-bottom: 1.5rem; position: relative;">
                <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.8) 100%);"></div>
                <div style="position: absolute; bottom: 1rem; left: 1.5rem; right: 1.5rem;">
                    <span class="section-tag" style="margin: 0; color: var(--accent-color);">DETAIL LAYANAN</span>
                    <h2 style="font-size: 1.6rem; color: #ffffff; text-shadow: 0 2px 8px rgba(0,0,0,0.6);">{{ $service['title'] }}</h2>
                </div>
            </div>

            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 1.05rem;">
                {{ $service['short_desc'] }}
            </p>

            <h4 style="color: var(--primary-color); margin-bottom: 0.8rem; font-size: 1.1rem;">
                <i class="fa-solid fa-circle-check"></i> Fitur &amp; Keunggulan Utama:
            </h4>

            <ul style="list-style: none; padding: 0; margin-bottom: 2rem; display: flex; flex-direction: column; gap: 0.6rem;">
                @foreach($service['features'] as $feature)
                    <li style="display: flex; align-items: center; gap: 0.8rem; color: var(--text-primary); font-size: 0.95rem;">
                        <i class="fa-solid fa-check" style="color: #2ecc71; font-size: 0.9rem;"></i>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>

            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <div>
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block;">Estimasi Biaya:</span>
                    <span class="service-price" style="font-size: 1.3rem;">{{ $service['price'] }}</span>
                </div>
                <button class="btn btn-primary" onclick="triggerOrder('{{ $service['id'] }}', '{{ $service['title'] }}'); Livewire.dispatch('closeServiceModal');">
                    <i class="fa-solid fa-paper-plane"></i> Pesan Sekarang
                </button>
            </div>
        </div>
    @endif
</div>
