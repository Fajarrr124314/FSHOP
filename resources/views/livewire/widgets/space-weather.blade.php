<div style="max-width: 1280px; margin: 0 auto 2rem; padding: 0 1.5rem;">
    <div class="glass-card" style="padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(var(--primary-rgb), 0.2); display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                <i class="fa-solid fa-satellite-dish fa-spin" style="animation-duration: 10s;"></i>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: #2ecc71; font-weight: 600;">
                    <i class="fa-solid fa-circle" style="font-size: 0.6rem;"></i> LIVE TELEMETRY
                </span>
                <p style="font-size: 0.95rem; color: var(--text-primary); font-weight: 500;">{{ $status }}</p>
            </div>
        </div>
        <div style="display: flex; gap: 1.5rem; font-size: 0.85rem; color: var(--text-secondary);">
            <span><i class="fa-solid fa-location-dot" style="color: var(--primary-color);"></i> {{ $location }}</span>
            <span><i class="fa-solid fa-temperature-half" style="color: var(--accent-color);"></i> {{ $temperature }}</span>
        </div>
    </div>
</div>
