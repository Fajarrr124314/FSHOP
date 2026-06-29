<section id="services">
    <div class="section-header">
        <p class="section-tag">SERVICES CATALOG</p>
        <h2 class="section-title">Layanan Digital <span class="gradient-text">FSHOP</span></h2>
    </div>

    <!-- Category Filters -->
    <div class="services-filters">
        <button class="filter-btn {{ $activeFilter === 'all' ? 'active' : '' }}" wire:click="setFilter('all')">
            <i class="fa-solid fa-border-all"></i> Semua Layanan
        </button>
        <button class="filter-btn {{ $activeFilter === 'web' ? 'active' : '' }}" wire:click="setFilter('web')">
            <i class="fa-solid fa-code"></i> Web Dev &amp; Portfolio
        </button>
        <button class="filter-btn {{ $activeFilter === 'mobile' ? 'active' : '' }}" wire:click="setFilter('mobile')">
            <i class="fa-solid fa-mobile-screen"></i> Mobile Apps
        </button>
        <button class="filter-btn {{ $activeFilter === 'design' ? 'active' : '' }}" wire:click="setFilter('design')">
            <i class="fa-solid fa-palette"></i> Desain Poster &amp; Banner
        </button>
        <button class="filter-btn {{ $activeFilter === 'tugas' ? 'active' : '' }}" wire:click="setFilter('tugas')">
            <i class="fa-solid fa-graduation-cap"></i> Jasa Tugas
        </button>
    </div>

    <!-- Grid Container -->
    <div class="services-grid">
        @foreach($services as $service)
            <div class="service-card glass-card">
                <div class="service-img-wrapper">
                    <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="service-card-img" loading="lazy">
                    <div class="img-overlay-glow"></div>
                </div>
                <div class="service-card-body">
                    <h3 class="service-title">{{ $service['title'] }}</h3>
                    <p class="service-desc">{{ $service['short_desc'] }}</p>

                    <div class="service-tags">
                        @foreach($service['tags'] as $tag)
                            <span class="tag-badge">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <div class="service-footer">
                        <span class="service-price">{{ $service['price'] }}</span>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-outline btn-sm" wire:click="openDetail('{{ $service['id'] }}')">
                                <i class="fa-solid fa-eye"></i> Detail
                            </button>
                            <button class="btn btn-primary btn-sm" onclick="triggerOrder('{{ $service['id'] }}', '{{ $service['title'] }}')">
                                <i class="fa-solid fa-cart-shopping"></i> Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Livewire Service Modal Component -->
    @livewire('services.service-modal')
</section>
