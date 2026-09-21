// ==========================================================================
// SONDHI ATELIER — APPLICATION & E-COMMERCE LOGIC
// ==========================================================================

// --- 1. Signature Fragrance Catalog ---
const products = [
    {
        id: 1,
        name: 'Lavender & Golden Amber',
        category: 'Floral',
        fragrance: 'French Lavender, Golden Amber, Spiced Cedar',
        topNotes: 'Wild Provence Lavender, Bergamot Zest',
        heartNotes: 'Golden Amber, Chamomile Blossom',
        baseNotes: 'Smoked Cedarwood, White Musk',
        price: 899,
        rating: 4.9,
        reviewsCount: 184,
        burnTime: '50 Hours',
        weight: '280g',
        badge: 'Bestseller',
        image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85',
        description: 'An intimate lullaby of French highlands lavender bathed in resinous molten amber. Formulated for evening un-winding and restful sleep sanctuaries.'
    },
    {
        id: 2,
        name: 'Rose Noir & Velvet Musk',
        category: 'Floral',
        fragrance: 'Damask Rose, Midnight Oud, Velvet Musk',
        topNotes: 'Crushed Pink Peppercorn, Damask Rose',
        heartNotes: 'Black Violet, Saffron Silk',
        baseNotes: 'Patchouli Leaf, Smoked Vetiver',
        price: 949,
        rating: 4.8,
        reviewsCount: 142,
        burnTime: '52 Hours',
        weight: '280g',
        badge: 'Staff Favorite',
        image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85',
        description: 'Deep, brooding, and unapologetically romantic. Dark Turkish petals steeped in velvety botanical musk for dinner parties and romantic evenings.'
    },
    {
        id: 3,
        name: 'Vanilla Tonka & Bourbon',
        category: 'Warm',
        fragrance: 'Bourbon Vanilla, Roasted Tonka, Sandalwood',
        topNotes: 'Cardamom Pods, Warm Milk',
        heartNotes: 'Madagascar Vanilla Bean, Tonka Bean',
        baseNotes: 'Creamy Mysore Sandalwood, Cocoa Husk',
        price: 799,
        rating: 4.9,
        reviewsCount: 218,
        burnTime: '48 Hours',
        weight: '260g',
        badge: 'Essential',
        image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85',
        description: 'Warm, culinary, and deeply nostalgic. Unlike synthetic vanilla, this features pure bean caviar wrapped in slow-roasted tonka and sandalwood.'
    },
    {
        id: 4,
        name: 'Sandalwood & Velvet Oud',
        category: 'Woody',
        fragrance: 'Indian Sandalwood, Dark Saffron, Sacred Oud',
        topNotes: 'Kashmiri Saffron, Smoked Nutmeg',
        heartNotes: 'Royal Agarwood (Oud), Cedar Resin',
        baseNotes: 'Aged Sandalwood, Frankincense',
        price: 1299,
        rating: 5.0,
        reviewsCount: 304,
        burnTime: '55 Hours',
        weight: '300g',
        badge: 'Atelier Masterpiece',
        image: 'https://images.unsplash.com/photo-1608181831718-c9e7d8a2a3a5?auto=format&fit=crop&w=800&q=85',
        description: 'Our most revered formulation. Deeply rooted in Indian olfactory heritage, pairing rare aged woods with ceremonial temple frankincense.'
    },
    {
        id: 5,
        name: 'Rain on Earth (Mitti Attar)',
        category: 'Fresh',
        fragrance: 'Baked Terracotta, Vetiver Root, Petrichor Accord',
        topNotes: 'Ozone, Crushed Green Leaves',
        heartNotes: 'Baked Terracotta Soil, Wild Georad',
        baseNotes: 'Ruh Khus (Wild Vetiver), Damp Moss',
        price: 849,
        rating: 4.9,
        reviewsCount: 265,
        burnTime: '48 Hours',
        weight: '260g',
        badge: 'Signature Scent',
        image: 'https://images.unsplash.com/photo-1602874801006-e26d6e8f0b15?auto=format&fit=crop&w=800&q=85',
        description: 'The poetic essence of Sondhi itself: the intoxicating earthy fragrance that rises from dry parched soil at the sudden kiss of the first monsoon rain.'
    },
    {
        id: 6,
        name: 'Neroli Blossom & Petitgrain',
        category: 'Floral',
        fragrance: 'Bitter Orange Blossom, Petitgrain, White Honey',
        topNotes: 'Italian Petitgrain, Green Lemon Leaf',
        heartNotes: 'Moroccan Neroli, Orange Flower Water',
        baseNotes: 'Clean White Linen, Honeycomb',
        price: 949,
        rating: 4.7,
        reviewsCount: 96,
        burnTime: '50 Hours',
        weight: '280g',
        badge: 'Luminous',
        image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85',
        description: 'Bright morning sunshine streaming through open linen curtains. Crisp, rejuvenating citrus blossom that clears the mind.'
    },
    {
        id: 7,
        name: 'Cedar Smoke & Cardamom',
        category: 'Woody',
        fragrance: 'Himalayan Cedar, Green Cardamom, Birch Smoke',
        topNotes: 'Cracked Green Cardamom, Dried Juniper',
        heartNotes: 'Himalayan Deodar Cedar, Cypress',
        baseNotes: 'Birch Tar Smoke, Amber Resin',
        price: 1199,
        rating: 4.9,
        reviewsCount: 157,
        burnTime: '52 Hours',
        weight: '280g',
        badge: 'Limited Harvest',
        image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85',
        description: 'Evocative of an evening fireside in the pine forests of Shimla. Smoky, resinous, and deeply grounding.'
    },
    {
        id: 8,
        name: 'Wild Citrus Peel & Vetiver',
        category: 'Fresh',
        fragrance: 'Sun-Drenched Mandarin, Kaffir Lime, White Musk',
        topNotes: 'Seville Bitter Orange, Lime Zest',
        heartNotes: 'Grapefruit Blossom, Ginger Lily',
        baseNotes: 'Haitian Vetiver, Soft Cedar',
        price: 749,
        rating: 4.7,
        reviewsCount: 112,
        burnTime: '45 Hours',
        weight: '250g',
        badge: 'Energizing',
        image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85',
        description: 'A burst of crisp vitality. Sharp zesty citrus peels balanced by the cool herbal undertones of wild grass roots.'
    }
];

// --- 2. Application State ---
const state = {
    category: 'All',
    query: '',
    sortBy: 'featured',
    cart: JSON.parse(localStorage.getItem('sondhi_cart') || '[]'),
    discount: { code: '', rate: 0 },
    customCandle: {
        vessel: 'Smoked Obsidian',
        vesselColor: '#1A1817',
        vesselBorder: '#332D29',
        price: 1399,
        scent: 'Sandalwood & Velvet Oud',
        label: 'For Slow Evenings'
    }
};

// --- 3. Format Currency ---
const formatINR = (val) => `₹${Math.round(val).toLocaleString('en-IN')}`;

// --- 4. Toast Notification System ---
function showToast(message) {
    const toast = document.querySelector('#atelier-toast');
    const msgEl = document.querySelector('#atelier-toast-msg');
    if (!toast || !msgEl) return;

    msgEl.textContent = message;
    toast.classList.remove('hidden');
    toast.classList.add('flex');

    if (window._toastTimeout) clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('flex');
    }, 2800);
}

// --- 5. Catalog Rendering ---
function renderCatalog() {
    const grid = document.querySelector('#product-grid');
    if (!grid) return;

    // Filter by Category and Search Query
    let filtered = products.filter((item) => {
        const matchesCat = state.category === 'All' || item.category === state.category;
        const searchTarget = `${item.name} ${item.fragrance} ${item.topNotes} ${item.heartNotes} ${item.baseNotes}`.toLowerCase();
        const matchesQuery = !state.query || searchTarget.includes(state.query.toLowerCase());
        return matchesCat && matchesQuery;
    });

    // Sorting Logic
    if (state.sortBy === 'price-asc') {
        filtered.sort((a, b) => a.price - b.price);
    } else if (state.sortBy === 'price-desc') {
        filtered.sort((a, b) => b.price - a.price);
    } else if (state.sortBy === 'rating') {
        filtered.sort((a, b) => b.rating - a.rating);
    }

    // Empty state
    if (!filtered.length) {
        grid.innerHTML = `
            <div class="col-span-full py-20 text-center glass-card rounded-2xl p-8">
                <i class="fa-solid fa-wind text-3xl text-luxe-gold/50 mb-3"></i>
                <h3 class="font-display text-2xl text-atelier-cream">No fragrances matched your selection</h3>
                <p class="mt-2 text-xs text-atelier-muted">Try searching for other notes like Lavender, Oud, Sandalwood, or Amber.</p>
                <button onclick="resetFilters()" class="mt-6 rounded-full border border-luxe-gold/40 px-6 py-2 text-xs uppercase tracking-wider text-luxe-gold hover:bg-luxe-gold hover:text-atelier-base transition">
                    Clear Filters
                </button>
            </div>
        `;
        return;
    }

    grid.innerHTML = filtered.map((item) => `
        <article class="glass-card group flex flex-col justify-between overflow-hidden rounded-2xl transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-amber-950/20">
            <div>
                <!-- Image Container with Badges -->
                <div class="relative aspect-[4/5] overflow-hidden bg-atelier-surface">
                    <img class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" 
                         src="${item.image}" 
                         alt="${item.name} Hand-Poured Soy Candle" 
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-atelier-card via-transparent to-transparent opacity-60"></div>
                    
                    <!-- Scent Category & Batch Badge -->
                    <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start">
                        <span class="rounded-full bg-atelier-base/80 backdrop-blur-md px-3 py-1 text-[9px] font-bold uppercase tracking-[0.2em] text-luxe-gold border border-white/10">
                            ${item.category}
                        </span>
                        ${item.badge ? `
                            <span class="rounded-full bg-flame-amber/90 px-2.5 py-0.5 text-[8px] font-bold uppercase tracking-widest text-white shadow">
                                ${item.badge}
                            </span>
                        ` : ''}
                    </div>

                    <!-- Quick View Trigger Overlay Button -->
                    <button onclick="openQuickView(${item.id})" class="absolute bottom-3 right-3 flex h-9 w-9 items-center justify-center rounded-full bg-atelier-surface/90 backdrop-blur-md text-atelier-cream border border-white/10 opacity-0 transition-all duration-300 group-hover:opacity-100 hover:bg-luxe-gold hover:text-atelier-base" aria-label="Quick View ${item.name}">
                        <i class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="p-5">
                    <div class="flex items-center justify-between text-[11px] text-atelier-dim">
                        <span><i class="fa-regular fa-clock mr-1 text-luxe-gold"></i> ${item.burnTime}</span>
                        <span><i class="fa-solid fa-weight-scale mr-1 text-luxe-gold"></i> ${item.weight}</span>
                    </div>

                    <h3 class="mt-2.5 font-display text-2xl font-semibold leading-snug text-atelier-cream group-hover:text-luxe-gold transition">
                        ${item.name}
                    </h3>

                    <p class="mt-1 text-xs text-atelier-muted line-clamp-1">
                        ${item.fragrance}
                    </p>

                    <!-- Fragrance Notes Preview Pill -->
                    <div class="mt-3 flex items-center gap-1.5 text-[10px] text-luxe-gold">
                        <i class="fa-solid fa-star text-[9px]"></i>
                        <span class="font-bold">${item.rating}</span>
                        <span class="text-atelier-dim">(${item.reviewsCount} reviews)</span>
                    </div>
                </div>
            </div>

            <!-- Price & Action Footer -->
            <div class="border-t border-white/10 p-5 pt-3 flex items-center justify-between gap-3">
                <div class="font-display text-2xl font-bold text-atelier-cream">
                    ${formatINR(item.price)}
                </div>
                <button onclick="addToBag(${item.id})" class="flex items-center gap-2 rounded-full bg-flame-soft border border-luxe-gold/40 px-4 py-2 text-xs font-bold uppercase tracking-wider text-luxe-gold hover:bg-luxe-gold hover:text-atelier-base transition duration-200 shadow">
                    <i class="fa-solid fa-bag-shopping text-[10px]"></i>
                    <span>Add to Bag</span>
                </button>
            </div>
        </article>
    `).join('');
}

// Reset filter helper
window.resetFilters = function() {
    state.category = 'All';
    state.query = '';
    const searchInput = document.querySelector('#catalog-search-input');
    if (searchInput) searchInput.value = '';
    document.querySelectorAll('.mood-pill').forEach(pill => {
        pill.classList.toggle('bg-luxe-gold', pill.dataset.category === 'All');
        pill.classList.toggle('text-atelier-base', pill.dataset.category === 'All');
    });
    renderCatalog();
};

// --- 6. Shopping Cart Management ---
function saveCart() {
    localStorage.setItem('sondhi_cart', JSON.stringify(state.cart));
    updateCartUI();
}

function updateCartUI() {
    const badge = document.querySelector('#cart-count-badge');
    const counter = document.querySelector('#cart-items-counter');
    const container = document.querySelector('#cart-items-container');
    const subtotalEl = document.querySelector('#cart-subtotal-display');
    const discountRow = document.querySelector('#cart-discount-row');
    const discountEl = document.querySelector('#cart-discount-display');
    const totalEl = document.querySelector('#cart-total-display');
    const progressBar = document.querySelector('#shipping-progress-bar');
    const progressText = document.querySelector('#shipping-progress-text');

    const totalCount = state.cart.reduce((sum, item) => sum + item.quantity, 0);
    if (badge) badge.textContent = totalCount;
    if (counter) counter.textContent = `(${totalCount} item${totalCount === 1 ? '' : 's'})`;

    // Compute Subtotal
    const subtotal = state.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const discountAmount = subtotal * state.discount.rate;
    const finalTotal = subtotal - discountAmount;

    if (subtotalEl) subtotalEl.textContent = formatINR(subtotal);
    if (discountRow) {
        if (state.discount.rate > 0) {
            discountRow.classList.remove('hidden');
            if (discountEl) discountEl.textContent = `-${formatINR(discountAmount)}`;
        } else {
            discountRow.classList.add('hidden');
        }
    }
    if (totalEl) totalEl.textContent = formatINR(finalTotal);

    // Shipping threshold (Free over ₹999)
    if (progressBar && progressText) {
        if (subtotal >= 999) {
            progressBar.style.width = '100%';
            progressText.innerHTML = '<span class="text-luxe-gold font-bold">✓ Complimentary Shipping Unlocked!</span>';
        } else {
            const needed = 999 - subtotal;
            const pct = Math.min(100, Math.round((subtotal / 999) * 100));
            progressBar.style.width = `${pct}%`;
            progressText.textContent = `Add ${formatINR(needed)} more for Free Shipping`;
        }
    }

    // Render cart items
    if (!container) return;
    if (!state.cart.length) {
        container.innerHTML = `
            <div class="py-16 text-center text-atelier-muted">
                <i class="fa-solid fa-bag-shopping text-4xl text-white/10 mb-3"></i>
                <p class="font-display text-xl text-atelier-cream">Your bag is currently empty</p>
                <p class="mt-1 text-xs text-atelier-dim">Select a botanical formulation to begin your sanctuary ritual.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = state.cart.map((item, index) => `
        <div class="flex gap-4 rounded-xl bg-atelier-card p-3 border border-white/5">
            <img class="h-20 w-16 rounded-lg object-cover bg-atelier-surface" src="${item.image}" alt="${item.name}">
            <div class="flex flex-1 flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <h4 class="font-display text-base font-semibold leading-tight text-atelier-cream">${item.name}</h4>
                        <button onclick="removeFromCart(${index})" class="text-xs text-atelier-dim hover:text-rose-400 transition" aria-label="Remove item">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    ${item.isCustom ? `
                        <p class="text-[10px] text-luxe-gold font-medium mt-0.5">Custom Label: "${item.customLabel}"</p>
                        <p class="text-[9px] text-atelier-dim">${item.vessel} · ${item.scent}</p>
                    ` : `
                        <p class="text-[10px] text-atelier-muted">${item.fragrance || item.category}</p>
                    `}
                </div>

                <div class="flex items-center justify-between border-t border-white/5 pt-2 mt-2">
                    <!-- Quantity controls -->
                    <div class="flex items-center rounded-lg border border-white/10 bg-atelier-surface">
                        <button onclick="changeCartQty(${index}, -1)" class="h-6 w-6 text-xs text-atelier-muted hover:text-white flex items-center justify-center">
                            -
                        </button>
                        <span class="px-2 text-xs font-bold text-atelier-cream">${item.quantity}</span>
                        <button onclick="changeCartQty(${index}, 1)" class="h-6 w-6 text-xs text-atelier-muted hover:text-white flex items-center justify-center">
                            +
                        </button>
                    </div>
                    <span class="font-display text-base font-bold text-luxe-gold">
                        ${formatINR(item.price * item.quantity)}
                    </span>
                </div>
            </div>
        </div>
    `).join('');
}

// Add Standard Product to Bag
window.addToBag = function(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingIndex = state.cart.findIndex(item => item.id === productId && !item.isCustom);
    if (existingIndex > -1) {
        state.cart[existingIndex].quantity += 1;
    } else {
        state.cart.push({
            id: product.id,
            name: product.name,
            category: product.category,
            fragrance: product.fragrance,
            price: product.price,
            image: product.image,
            quantity: 1,
            isCustom: false
        });
    }

    saveCart();
    showToast(`Added "${product.name}" to your bag`);
    openCart();
};

// Cart Mutators
window.removeFromCart = function(index) {
    state.cart.splice(index, 1);
    saveCart();
};

window.changeCartQty = function(index, delta) {
    if (!state.cart[index]) return;
    state.cart[index].quantity += delta;
    if (state.cart[index].quantity <= 0) {
        state.cart.splice(index, 1);
    }
    saveCart();
};

// Cart Drawer Open / Close
function openCart() {
    const drawer = document.querySelector('#cart-drawer');
    const backdrop = document.querySelector('#cart-drawer-backdrop');
    if (drawer && backdrop) {
        drawer.classList.remove('translate-x-full');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100');
        document.body.style.overflow = 'hidden';
    }
}

function closeCart() {
    const drawer = document.querySelector('#cart-drawer');
    const backdrop = document.querySelector('#cart-drawer-backdrop');
    if (drawer && backdrop) {
        drawer.classList.add('translate-x-full');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100');
        document.body.style.overflow = '';
    }
}

// --- 7. Quick View Modal ---
window.openQuickView = function(productId) {
    const item = products.find(p => p.id === productId);
    if (!item) return;

    const container = document.querySelector('#quickview-content');
    const modalBackdrop = document.querySelector('#quickview-modal-backdrop');
    const modal = document.querySelector('#quickview-modal');

    if (!container || !modalBackdrop || !modal) return;

    container.innerHTML = `
        <div class="grid gap-8 md:grid-cols-2">
            <div class="relative aspect-square overflow-hidden rounded-xl bg-atelier-surface">
                <img class="h-full w-full object-cover" src="${item.image}" alt="${item.name}">
                <span class="absolute top-3 left-3 rounded-full bg-atelier-base/80 backdrop-blur-md px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-luxe-gold border border-white/10">
                    ${item.category}
                </span>
            </div>

            <div class="flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 text-xs text-luxe-gold mb-1">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        <span class="font-bold">${item.rating}</span>
                        <span class="text-atelier-dim">(${item.reviewsCount} customer reviews)</span>
                    </div>

                    <h2 class="font-display text-3xl font-bold text-atelier-cream">${item.name}</h2>
                    <div class="mt-2 font-display text-2xl font-bold text-luxe-gold">${formatINR(item.price)}</div>

                    <p class="mt-4 text-xs leading-relaxed text-atelier-muted">
                        ${item.description}
                    </p>

                    <!-- Fragrance Pyramid Accordion -->
                    <div class="mt-6 space-y-2 rounded-xl bg-atelier-card p-4 border border-white/5 text-xs">
                        <div class="font-bold uppercase tracking-widest text-[10px] text-luxe-gold mb-2">
                            Fragrance Architecture:
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-1.5 text-atelier-cream">
                            <span class="text-atelier-dim">Top:</span>
                            <span class="font-medium text-right">${item.topNotes}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-1.5 text-atelier-cream">
                            <span class="text-atelier-dim">Heart:</span>
                            <span class="font-medium text-right">${item.heartNotes}</span>
                        </div>
                        <div class="flex justify-between text-atelier-cream">
                            <span class="text-atelier-dim">Base:</span>
                            <span class="font-medium text-right">${item.baseNotes}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-3 border-t border-white/10 pt-4">
                    <button onclick="addToBag(${item.id}); closeQuickView();" class="flex-1 rounded-full bg-luxe-gold py-3.5 text-xs font-bold uppercase tracking-[0.2em] text-atelier-base hover:bg-white transition shadow-lg shadow-amber-900/30">
                        Add To Bag · ${formatINR(item.price)}
                    </button>
                </div>
            </div>
        </div>
    `;

    modalBackdrop.classList.remove('opacity-0', 'pointer-events-none');
    modalBackdrop.classList.add('opacity-100');
    modal.classList.remove('scale-95');
    modal.classList.add('scale-100');
    document.body.style.overflow = 'hidden';
};

window.closeQuickView = function() {
    const modalBackdrop = document.querySelector('#quickview-modal-backdrop');
    const modal = document.querySelector('#quickview-modal');
    if (modalBackdrop && modal) {
        modalBackdrop.classList.add('opacity-0', 'pointer-events-none');
        modalBackdrop.classList.remove('opacity-100');
        modal.classList.add('scale-95');
        modal.classList.remove('scale-100');
        document.body.style.overflow = '';
    }
};

// --- 8. Custom Candle Studio Interactive Configurator ---
function initCustomCandleStudio() {
    const vesselButtons = document.querySelectorAll('.vessel-option');
    const scentSelect = document.querySelector('#custom-scent-select');
    const labelInput = document.querySelector('#custom-label-input');
    const addBtn = document.querySelector('#add-custom-candle-btn');

    const vesselSelectedLabel = document.querySelector('#vessel-selected-label');
    const scentSelectedNotes = document.querySelector('#scent-selected-notes');
    const priceDisplay = document.querySelector('#custom-price-display');

    const mockupVessel = document.querySelector('#mockup-vessel');
    const mockupTitle = document.querySelector('#mockup-label-title');
    const mockupScent = document.querySelector('#mockup-label-scent');

    // Step 1: Vessel Selection
    vesselButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            vesselButtons.forEach(b => {
                b.classList.remove('border-luxe-gold', 'bg-atelier-hover', 'active');
                b.classList.add('border-white/10', 'bg-atelier-surface');
            });
            btn.classList.add('border-luxe-gold', 'bg-atelier-hover', 'active');
            btn.classList.remove('border-white/10', 'bg-atelier-surface');

            state.customCandle.vessel = btn.dataset.vessel;
            state.customCandle.vesselColor = btn.dataset.color;
            state.customCandle.vesselBorder = btn.dataset.border;
            state.customCandle.price = parseInt(btn.dataset.price, 10);

            if (vesselSelectedLabel) vesselSelectedLabel.textContent = state.customCandle.vessel;
            if (priceDisplay) priceDisplay.textContent = formatINR(state.customCandle.price);

            // Update Mockup
            if (mockupVessel) {
                mockupVessel.style.backgroundColor = state.customCandle.vesselColor;
                mockupVessel.style.borderColor = state.customCandle.vesselBorder;
            }
        });
    });

    // Step 2: Scent Selection
    if (scentSelect) {
        scentSelect.addEventListener('change', () => {
            const opt = scentSelect.options[scentSelect.selectedIndex];
            state.customCandle.scent = scentSelect.value;
            const notes = opt.dataset.notes || '';
            if (scentSelectedNotes) scentSelectedNotes.textContent = notes;
            if (mockupScent) mockupScent.textContent = state.customCandle.scent;
        });
    }

    // Step 3: Personalized Dedication Text
    if (labelInput) {
        labelInput.addEventListener('input', (e) => {
            const text = e.target.value.trim();
            state.customCandle.label = text || 'For Slow Evenings';
            if (mockupTitle) mockupTitle.textContent = state.customCandle.label;
        });
    }

    // Add Custom Candle To Bag
    if (addBtn) {
        addBtn.addEventListener('click', () => {
            const customItem = {
                id: `custom_${Date.now()}`,
                name: `Bespoke Candle (${state.customCandle.vessel})`,
                vessel: state.customCandle.vessel,
                scent: state.customCandle.scent,
                customLabel: state.customCandle.label,
                price: state.customCandle.price,
                image: 'https://images.unsplash.com/photo-1608181831718-c9e7d8a2a3a5?auto=format&fit=crop&w=600&q=85',
                quantity: 1,
                isCustom: true
            };

            state.cart.push(customItem);
            saveCart();
            showToast('Custom candle added to your sanctuary bag');
            openCart();
        });
    }
}

// --- 9. Event Listeners & Initialization ---
document.addEventListener('DOMContentLoaded', () => {
    // Initial Renderings
    renderCatalog();
    updateCartUI();
    initCustomCandleStudio();

    // Close welcome overlay on Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && typeof closeWelcomeOverlay === 'function') {
            closeWelcomeOverlay();
        }
    });

    // Mood Filters
    const moodPills = document.querySelectorAll('.mood-pill');
    moodPills.forEach(pill => {
        pill.addEventListener('click', () => {
            moodPills.forEach(p => {
                p.classList.remove('bg-luxe-gold', 'text-atelier-base');
                p.classList.add('bg-atelier-surface', 'text-atelier-muted');
            });
            pill.classList.add('bg-luxe-gold', 'text-atelier-base');
            pill.classList.remove('bg-atelier-surface', 'text-atelier-muted');

            state.category = pill.dataset.category;
            renderCatalog();
        });
    });

    // Catalog Search
    const catalogSearch = document.querySelector('#catalog-search-input');
    if (catalogSearch) {
        catalogSearch.addEventListener('input', (e) => {
            state.query = e.target.value;
            renderCatalog();
        });
    }

    // Catalog Sort
    const sortSelect = document.querySelector('#catalog-sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            state.sortBy = e.target.value;
            renderCatalog();
        });
    }

    // Cart Drawer Toggle
    const cartToggleBtn = document.querySelector('#cart-toggle-btn');
    const cartCloseBtn = document.querySelector('#cart-close-btn');
    const cartBackdrop = document.querySelector('#cart-drawer-backdrop');

    if (cartToggleBtn) cartToggleBtn.addEventListener('click', openCart);
    if (cartCloseBtn) cartCloseBtn.addEventListener('click', closeCart);
    if (cartBackdrop) cartBackdrop.addEventListener('click', closeCart);

    // Quick View Close
    const qvCloseBtn = document.querySelector('#quickview-close-btn');
    const qvBackdrop = document.querySelector('#quickview-modal-backdrop');
    if (qvCloseBtn) qvCloseBtn.addEventListener('click', closeQuickView);
    if (qvBackdrop) {
        qvBackdrop.addEventListener('click', (e) => {
            if (e.target === qvBackdrop) closeQuickView();
        });
    }

    // Escape Key Listener to Close Modals & Drawers
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCart();
            closeQuickView();
        }
    });

    // Search Header Overlay Toggle
    const searchToggleBtn = document.querySelector('#search-toggle-btn');
    const searchOverlay = document.querySelector('#search-overlay');
    const searchCloseBtn = document.querySelector('#search-close-btn');
    const headerSearchInput = document.querySelector('#header-search-input');

    if (searchToggleBtn && searchOverlay) {
        searchToggleBtn.addEventListener('click', () => {
            searchOverlay.classList.toggle('hidden');
            if (!searchOverlay.classList.contains('hidden') && headerSearchInput) {
                headerSearchInput.focus();
            }
        });
    }

    if (searchCloseBtn && searchOverlay) {
        searchCloseBtn.addEventListener('click', () => {
            searchOverlay.classList.add('hidden');
        });
    }

    if (headerSearchInput) {
        headerSearchInput.addEventListener('input', (e) => {
            state.query = e.target.value;
            if (catalogSearch) catalogSearch.value = e.target.value;
            renderCatalog();
            document.querySelector('#collection')?.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('#mobile-menu-btn');
    const mobileMenu = document.querySelector('#mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // Promo Code Coupon Applicator
    const applyCouponBtn = document.querySelector('#apply-coupon-btn');
    const couponInput = document.querySelector('#coupon-input');
    if (applyCouponBtn && couponInput) {
        applyCouponBtn.addEventListener('click', () => {
            const code = couponInput.value.trim().toUpperCase();
            if (code === 'LIGHT10') {
                state.discount = { code: 'LIGHT10', rate: 0.10 };
                saveCart();
                showToast('10% Circle Discount Applied!');
                couponInput.value = '';
            } else if (code) {
                showToast('Invalid promo code. Try LIGHT10');
            }
        });
    }

    // Checkout Button Handler
    const checkoutBtn = document.querySelector('#checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (!state.cart.length) {
                showToast('Your bag is empty. Choose a fragrance to proceed.');
                return;
            }

            // Check if user is authenticated
            if (window.sondhiAuth && !window.sondhiAuth.isAuthenticated()) {
                window.sondhiAuth.openAuthModal(
                    'signin',
                    'Please sign in or create an account to commission your candles and track your order.',
                    () => {
                        // After successful login, trigger checkout
                        checkoutBtn.click();
                    }
                );
                return;
            }

            // Calculate totals
            const subtotal = state.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            const discountAmount = state.discount ? subtotal * state.discount.rate : 0;
            const taxable = subtotal - discountAmount;
            const gst = taxable * 0.18;
            const finalTotal = Math.round(taxable + gst);

            const orderData = {
                total: finalTotal,
                items: state.cart.map(item => ({
                    name: item.name + (item.weight ? ` (${item.weight})` : ''),
                    quantity: item.quantity,
                    price: item.price
                })),
                candles: state.cart.map(item => `${item.name} (${item.weight || '280g'}) × ${item.quantity}`),
                status: 'Pouring & Curing',
                statusCode: 'pouring',
                statusDesc: 'Botanical soy wax setting in ceramic vessels under ambient temperature control'
            };

            if (window.sondhiAuth) {
                const result = window.sondhiAuth.addUserOrder(orderData);
                if (result.success) {
                    state.cart = [];
                    state.discount = null;
                    saveCart();
                    closeCart();
                    window.sondhiAuth.showOrderSuccessModal(result.order);
                } else {
                    showToast(result.message || 'Failed to commission order.', true);
                }
            } else {
                alert('🕯️ Order Confirmed!\n\nThank you for choosing Sondhi. Our artisans will hand-pour, pack, and ship your botanical candles with great care.');
                state.cart = [];
                saveCart();
                closeCart();
                showToast('Order placed successfully!');
            }
        });
    }

    // Newsletter Subscription Form
    const newsletterForm = document.querySelector('#newsletter-form');
    const newsletterSuccess = document.querySelector('#newsletter-success');
    if (newsletterForm && newsletterSuccess) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            newsletterSuccess.classList.remove('hidden');
            newsletterForm.reset();
            showToast('Welcome to the Private Circle. 10% code unlocked!');
        });
    }

    // Scroll Reveal Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-node, section').forEach(el => {
        el.classList.add('reveal-node');
        observer.observe(el);
    });

    // ======================================================================
    // SONDHI LOVE SANCTUARY — "I LOVE YOU BABY" INTERACTIVE SYSTEM
    // ======================================================================
    function spawnHeartBurst(x, y, count = 28) {
        const container = document.body;
        const colors = ['#f43f5e', '#fb7185', '#fda4af', '#f59e0b', '#fbbf24', '#f472b6', '#e11d48'];
        const particleCount = count;
        const startX = typeof x === 'number' && !isNaN(x) ? x : (window.innerWidth / 2);
        const startY = typeof y === 'number' && !isNaN(y) ? y : (window.innerHeight / 2);

        for (let i = 0; i < particleCount; i++) {
            const el = document.createElement('div');
            el.className = 'fixed pointer-events-none z-[110] select-none text-base sm:text-lg';
            const color = colors[Math.floor(Math.random() * colors.length)];
            el.style.color = color;
            el.style.textShadow = `0 0 14px ${color}`;
            el.innerHTML = `<i class="fa-solid fa-heart"></i>`;
            
            el.style.left = `${startX}px`;
            el.style.top = `${startY}px`;
            el.style.opacity = '1';
            el.style.transform = `translate(-50%, -50%) scale(${0.4 + Math.random() * 0.7})`;
            el.style.transition = 'transform 1.1s cubic-bezier(0.1, 0.8, 0.3, 1), opacity 1.1s ease-out';
            
            container.appendChild(el);

            const angle = Math.random() * Math.PI * 2;
            const velocity = 70 + Math.random() * 180;
            const destX = Math.cos(angle) * velocity;
            const destY = Math.sin(angle) * velocity - (60 + Math.random() * 90);
            const rotation = (Math.random() - 0.5) * 360;

            requestAnimationFrame(() => {
                el.style.transform = `translate(calc(-50% + ${destX}px), calc(-50% + ${destY}px)) scale(${1.1 + Math.random() * 0.5}) rotate(${rotation}deg)`;
                el.style.opacity = '0';
            });

            setTimeout(() => {
                if (el && el.parentNode) el.remove();
            }, 1200);
        }
    }

    const welcomeOverlay = document.querySelector('#welcome-overlay');
    const welcomeCloseBtn = document.querySelector('#welcome-overlay-close');
    const welcomeHeartBtn = document.querySelector('#welcome-heart-btn');
    const floatingLoveBtn = document.querySelector('#floating-love-btn');
    const mainHeartSparkBtn = document.querySelector('#main-heart-spark-btn');
    const sparkLoveBtn = document.querySelector('#spark-love-btn');

    const romanticNotes = [
        "I love you baby! With all my heart, from Arya ❤️",
        "You are the most precious flame in my life ✨",
        "Every day with you is pure magic and warmth 🕯️",
        "Forever & always yours, my love 💖",
        "You light up my whole world, baby 🌹"
    ];
    let noteIndex = 0;

    function closeWelcomeOverlay(e) {
        if (!welcomeOverlay) return;
        const rect = welcomeCloseBtn ? welcomeCloseBtn.getBoundingClientRect() : null;
        const x = e && e.clientX ? e.clientX : (rect ? rect.left + rect.width / 2 : window.innerWidth / 2);
        const y = e && e.clientY ? e.clientY : (rect ? rect.top + rect.height / 2 : window.innerHeight / 2);
        
        spawnHeartBurst(x, y, 32);

        welcomeOverlay.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        setTimeout(() => {
            welcomeOverlay.style.display = 'none';
        }, 700);

        showToast("Welcome to our sanctuary, baby! ❤️");
    }

    function openWelcomeOverlay() {
        if (!welcomeOverlay) return;
        welcomeOverlay.style.display = 'flex';
        requestAnimationFrame(() => {
            welcomeOverlay.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
        });
        spawnHeartBurst(window.innerWidth / 2, window.innerHeight / 2, 24);
    }

    if (welcomeCloseBtn) {
        welcomeCloseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            closeWelcomeOverlay(e);
        });
    }

    if (welcomeHeartBtn) {
        welcomeHeartBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const rect = welcomeHeartBtn.getBoundingClientRect();
            spawnHeartBurst(rect.left + rect.width / 2, rect.top + rect.height / 2, 35);
            setTimeout(() => {
                closeWelcomeOverlay(e);
            }, 300);
        });
    }

    if (welcomeOverlay) {
        welcomeOverlay.addEventListener('click', (e) => {
            if (e.target === welcomeOverlay || e.target.closest('#welcome-overlay')) {
                closeWelcomeOverlay(e);
            }
        });
    }

    if (floatingLoveBtn) {
        floatingLoveBtn.addEventListener('click', () => {
            openWelcomeOverlay();
        });
    }

    function triggerLoveSparks(e) {
        const target = e.currentTarget || e.target;
        const rect = target.getBoundingClientRect();
        const x = rect.left + rect.width / 2;
        const y = rect.top + rect.height / 2;

        spawnHeartBurst(x, y, 36);

        // Rotating romantic toasts
        const note = romanticNotes[noteIndex % romanticNotes.length];
        noteIndex++;
        showToast(note);
    }

    if (mainHeartSparkBtn) {
        mainHeartSparkBtn.addEventListener('click', triggerLoveSparks);
    }

    if (sparkLoveBtn) {
        sparkLoveBtn.addEventListener('click', triggerLoveSparks);
    }
});
