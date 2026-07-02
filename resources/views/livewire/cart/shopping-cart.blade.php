<div x-data>
    <!-- Cart Backdrop Overlay -->
    <div class="cart-backdrop" 
         :class="$store.cart.isOpen ? 'show' : ''"
         x-show="$store.cart.isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.cart.isOpen = false"
         style="display: none;"></div>

    <!-- Sliding Cart Drawer -->
    <div class="cart-drawer" 
         :class="$store.cart.isOpen ? 'show' : ''"
         x-show="$store.cart.isOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         style="display: none;">
        
        <div class="cart-drawer-header">
            <h3 class="cart-drawer-title">
                <i class="fa-solid fa-bag-shopping neon-text-cyan"></i> Keranjang Belanja
            </h3>
            <button class="cart-close-btn" @click="$store.cart.isOpen = false">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="cart-drawer-body">
            <!-- Empty Cart state -->
            <template x-if="$store.cart.items.length === 0">
                <div class="empty-cart-box">
                    <i class="fa-solid fa-box-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <p style="color: var(--text-secondary); margin: 0;">Keranjang belanja Anda kosong</p>
                    <button class="btn btn-primary btn-sm" style="margin-top: 1rem;" @click="$store.cart.isOpen = false">Jelajahi Layanan</button>
                </div>
            </template>

            <!-- Cart Items list -->
            <template x-if="$store.cart.items.length > 0">
                <div class="cart-items-container">
                    <template x-for="(item, index) in $store.cart.items" :key="item.uniqueKey">
                        <div class="cart-item-row glass-card" style="display: flex; align-items: center; gap: 0.8rem; padding: 1rem;">
                            <!-- Selection Checkbox & Serial Number -->
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0;">
                                <input type="checkbox" 
                                       :checked="item.selected !== false" 
                                       @change="item.selected = $event.target.checked; $store.cart.save()" 
                                       style="width: 16px; height: 16px; accent-color: var(--primary-color); cursor: pointer;">
                                <span style="font-size: 0.85rem; font-weight: bold; color: var(--text-muted); min-width: 15px; text-align: center;" x-text="index + 1"></span>
                            </div>

                            <div class="cart-item-img">
                                <img :src="item.image || 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=80&q=80'" :alt="item.title">
                            </div>
                            <div class="cart-item-details" style="flex: 1;">
                                <h4 class="cart-item-title" x-text="item.title"></h4>
                                <template x-if="item.package_name">
                                    <div class="cart-item-pkg" x-text="item.package_name"></div>
                                </template>
                                
                                <div class="cart-item-meta" x-show="item.meta && Object.keys(item.meta).length > 0">
                                    <template x-for="(v, k) in item.meta" :key="k">
                                        <template x-if="v">
                                            <span>
                                                <strong x-text="k.charAt(0).toUpperCase() + k.slice(1).replace('_', ' ') + ': '"></strong>
                                                <span x-text="v"></span>
                                            </span>
                                        </template>
                                    </template>
                                </div>

                                <div class="cart-item-price-qty">
                                    <span class="cart-item-price" x-text="item.price"></span>
                                    <template x-if="item.qty > 1">
                                        <span class="cart-item-qty" x-text="'x' + item.qty"></span>
                                    </template>
                                </div>
                            </div>
                            <button class="cart-item-remove-btn" @click="$store.cart.removeItem(item.uniqueKey)" title="Hapus Item">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <template x-if="$store.cart.items.length > 0">
            <div class="cart-drawer-footer">
                <div class="cart-total-row" style="margin-bottom: 1.2rem;">
                    <span style="color: var(--text-secondary); font-weight: 600;">Total Belanja (Item Terpilih):</span>
                    <span class="cart-total-price" x-text="$store.cart.formatMoney($store.cart.total)"></span>
                </div>
                
                <button class="btn btn-primary cart-checkout-btn" 
                        style="width: 100%; justify-content: center; padding: 0.9rem;" 
                        @click="$store.cart.processCheckout()" 
                        :disabled="$store.cart.isCheckoutLoading || $store.cart.items.filter(i => i.selected !== false).length === 0">
                    <span x-show="!$store.cart.isCheckoutLoading"><i class="fa-solid fa-circle-check"></i> LANJUTKAN CHECKOUT</span>
                    <span x-show="$store.cart.isCheckoutLoading" style="display: none;"><i class="fa-solid fa-circle-notch fa-spin"></i> MEMPROSES...</span>
                </button>
            </div>
        </template>
    </div>
</div>
