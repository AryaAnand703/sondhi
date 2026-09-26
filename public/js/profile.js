// ==========================================================================
// SONDHI ATELIER — CLIENT PROFILE & BILLING LOGIC
// ==========================================================================

const profileState = {
    user: {
        firstName: 'Arya',
        lastName: 'Anand',
        email: 'arya@example.com',
        phone: '+91 98765 43210',
        tier: 'VIP Collector',
        points: 1450,
        membership: {
            tier: 'The Flame Circle',
            quarterlyPrice: 2499,
            nextBilling: 'November 15, 2026',
            status: 'Active',
            perks: [
                'Complimentary bespoke wax sealing',
                'Priority private pour reservations',
                'Quarterly reserve fragrance gift box',
                'Free temperature-controlled courier delivery'
            ]
        }
    },
    paymentMethods: [
        {
            id: 'pm-1',
            type: 'visa',
            brand: 'Visa Signature',
            last4: '8842',
            exp: '09/28',
            holder: 'Arya Anand',
            isDefault: true
        },
        {
            id: 'pm-2',
            type: 'mastercard',
            brand: 'Mastercard World Elite',
            last4: '3019',
            exp: '04/27',
            holder: 'Arya Anand',
            isDefault: false
        },
        {
            id: 'pm-3',
            type: 'upi',
            brand: 'UPI / Direct Mandate',
            last4: 'arya@okhdfcbank',
            exp: 'Autopay Verified',
            holder: 'Arya Anand',
            isDefault: false
        }
    ],
    invoices: [
        {
            id: 'INV-2026-084',
            date: 'Sep 12, 2026',
            description: 'Order #SND-9014 · 2x Lavender & Golden Amber, 1x Rain on Earth',
            amount: 2647,
            status: 'Paid',
            items: [
                { name: 'Lavender & Golden Amber (280g)', qty: 2, price: 899 },
                { name: 'Rain on Earth Mitti Attar (260g)', qty: 1, price: 849 }
            ],
            tax: 283.60,
            subtotal: 2647
        },
        {
            id: 'INV-2026-071',
            date: 'Aug 15, 2026',
            description: 'Flame Circle Quarterly Allocation — Q3 Reserve Edition',
            amount: 2499,
            status: 'Paid',
            items: [
                { name: 'Flame Circle Q3 Reserve Curated Atelier Box', qty: 1, price: 2499 }
            ],
            tax: 267.75,
            subtotal: 2499
        },
        {
            id: 'INV-2026-055',
            date: 'Jul 28, 2026',
            description: 'Bespoke Atelier commission: "Midnight Oud in Kashmir"',
            amount: 1499,
            status: 'Paid',
            items: [
                { name: 'Custom Studio Bespoke Formulation #F-402', qty: 1, price: 1499 }
            ],
            tax: 160.60,
            subtotal: 1499
        },
        {
            id: 'INV-2026-039',
            date: 'Jun 10, 2026',
            description: 'Order #SND-8412 · Sandalwood & Velvet Oud Signature',
            amount: 1299,
            status: 'Paid',
            items: [
                { name: 'Sandalwood & Velvet Oud (300g)', qty: 1, price: 1299 }
            ],
            tax: 139.18,
            subtotal: 1299
        }
    ],
    orders: [],
    formulas: [
        {
            id: 'FORMULA-771',
            name: 'Midnight Monsoon & Oud',
            dateCreated: 'Aug 24, 2026',
            vessel: 'Matte Obsidian Ceramic',
            wick: 'Dual Crackling Cedar Wood',
            top: 'Mitti Attar Petrichor & Ozone',
            heart: 'Midnight Damask Rose & Nutmeg',
            base: 'Smoked Cambodian Oud & Sandalwood',
            notes: 'Intimate evening meditation candle with deep earthy petrichor throw.'
        },
        {
            id: 'FORMULA-604',
            name: 'Kashmiri Bergamot & Honeycomb',
            dateCreated: 'Jul 11, 2026',
            vessel: 'Smoked Amber Glass',
            wick: 'Braided Egyptian Organic Cotton',
            top: 'Sunlit Bergamot & Neroli Water',
            heart: 'Wildflower Honey & Cardamom',
            base: 'Creamy Tonka Bean & Cedar',
            notes: 'Invigorating sunrise formulation for reading sanctuary.'
        }
    ],
    addresses: [
        {
            id: 'addr-1',
            label: 'Primary Sanctuary Residence',
            street: '7B, Sea Face Promenade, Worli',
            city: 'Mumbai',
            pincode: '400018',
            isDefault: true
        },
        {
            id: 'addr-2',
            label: 'Art & Design Studio',
            street: '402 The Loft, Industrial Estate, Lower Parel',
            city: 'Mumbai',
            pincode: '400013',
            isDefault: false
        }
    ]
};

// --- Sync Profile With Central Auth State ---
function syncProfileWithAuth() {
    if (!window.sondhiAuth) return;
    const user = window.sondhiAuth.getCurrentUser();
    if (user) {
        const names = (user.fullName || 'Patron').split(' ');
        profileState.user.firstName = names[0] || 'Patron';
        profileState.user.lastName = names.slice(1).join(' ') || '';
        profileState.user.email = user.email || '';
        profileState.user.phone = user.phone || '+91 98765 43210';
        profileState.user.tier = user.tier || 'Patron';
        if (user.orders && user.orders.length) {
            profileState.orders = user.orders;
        } else if (window.serverOrders && window.serverOrders.length) {
            profileState.orders = window.serverOrders.map(so => ({
                id: so.order_number || ('SND-' + so.id),
                date: new Date(so.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
                status: so.status || 'Pouring & Curing',
                statusCode: so.status_code || 'pouring',
                statusDesc: so.status_desc || 'Artisan bench allocated; botanicals infused into soy wax',
                itemsCount: so.items_count || 1,
                total: parseFloat(so.total || 0),
                subtotal: parseFloat(so.subtotal || so.total || 0),
                shippingAddress: so.shipping_address || 'Primary Sanctuary Residence, Mumbai',
                paymentMethod: so.payment_method || 'Prepaid Card / UPI',
                estimatedDelivery: so.estimated_delivery || '7-9 Business Days',
                items: so.items || []
            }));
        } else if (!profileState.orders || profileState.orders.length === 0) {
            profileState.orders = [
                {
                    id: 'SND-9014',
                    date: 'Sep 12, 2026',
                    status: 'Pouring & Curing',
                    statusCode: 'pouring',
                    statusDesc: 'Botanical soy wax setting in ceramic vessels under ambient temperature control',
                    itemsCount: 3,
                    total: 2647,
                    subtotal: 2647,
                    estimatedDelivery: 'Sep 21, 2026',
                    shippingAddress: '7B, Sea Face Promenade, Worli, Mumbai - 400018',
                    paymentMethod: 'UPI Direct / HDFC Bank',
                    candles: [
                        'Lavender & Golden Amber (280g) × 2',
                        'Rain on Earth Mitti Attar (260g) × 1'
                    ]
                },
                {
                    id: 'SND-8890',
                    date: 'Aug 15, 2026',
                    status: 'Delivered',
                    statusCode: 'delivered',
                    statusDesc: 'Delivered via White-Glove Courier to Mumbai Sanctuary',
                    itemsCount: 1,
                    total: 2499,
                    subtotal: 2499,
                    estimatedDelivery: 'Delivered Aug 18, 2026',
                    shippingAddress: '7B, Sea Face Promenade, Worli, Mumbai - 400018',
                    paymentMethod: 'Visa Signature •••• 8842',
                    candles: [
                        'Flame Circle Q3 Reserve Box (Monsoon Vetiver) × 1'
                    ]
                },
                {
                    id: 'SND-8412',
                    date: 'Jun 10, 2026',
                    status: 'Delivered',
                    statusCode: 'delivered',
                    statusDesc: 'Delivered with bespoke wax sealing and wooden wick care kit',
                    itemsCount: 2,
                    total: 2098,
                    subtotal: 2248,
                    estimatedDelivery: 'Delivered Jun 14, 2026',
                    shippingAddress: '402 The Loft, Industrial Estate, Lower Parel, Mumbai - 400013',
                    paymentMethod: 'Mastercard World Elite •••• 3019',
                    candles: [
                        'Sandalwood & Velvet Oud (300g) × 1',
                        'Neroli Blossom & Petitgrain (260g) × 1'
                    ]
                }
            ];
        }

        if (user.addresses && user.addresses.length) {
            profileState.addresses = user.addresses;
        }
        if (user.formulas && user.formulas.length) {
            profileState.formulas = user.formulas;
        }

        // Populate form inputs
        const inputFirst = document.getElementById('input-first-name');
        const inputLast = document.getElementById('input-last-name');
        const inputEmail = document.getElementById('input-email');
        const inputPhone = document.getElementById('input-phone');
        if (inputFirst) inputFirst.value = profileState.user.firstName;
        if (inputLast) inputLast.value = profileState.user.lastName;
        if (inputEmail) inputEmail.value = profileState.user.email;
        if (inputPhone) inputPhone.value = profileState.user.phone;

        // Toggle admin/superadmin workspace pills based on role
        const adminPill = document.getElementById('pill-admin-link');
        const superPill = document.getElementById('pill-superadmin-link');
        if (adminPill) {
            adminPill.style.display = (user && (user.role === 'admin' || user.role === 'superadmin')) ? 'inline-flex' : 'none';
        }
        if (superPill) {
            superPill.style.display = (user && user.role === 'superadmin') ? 'inline-flex' : 'none';
        }
    }
}

// --- DOM Loaded Initialization ---
document.addEventListener('DOMContentLoaded', () => {
    const initProfilePage = () => {
        syncProfileWithAuth();
        renderPaymentMethods();
        renderInvoices();
        renderOrders();
        renderFormulas();
        renderAddresses();
        updateIdentityHeader();

        // Check hash for direct tab navigation
        const hash = window.location.hash.replace('#', '');
        if (['overview', 'billing', 'orders', 'formulas', 'addresses'].includes(hash)) {
            switchProfileTab(hash);
        }
    };

    if (window.sondhiAuth) {
        if (!window.sondhiAuth.isAuthenticated()) {
            window.sondhiAuth.openAuthModal(
                'signin',
                'Please sign in or create an account to view your sanctuary profile and order history.',
                () => {
                    initProfilePage();
                }
            );
        } else {
            initProfilePage();
        }

        // Listen for auth or order changes
        window.addEventListener('sondhi_auth_change', () => {
            initProfilePage();
        });
        window.addEventListener('sondhi_order_placed', () => {
            syncProfileWithAuth();
            renderOrders();
        });
    } else {
        initProfilePage();
    }
});

// --- Tab Navigation ---
function switchProfileTab(tabId) {
    const tabs = ['overview', 'billing', 'orders', 'formulas', 'addresses'];
    tabs.forEach(t => {
        const btn = document.getElementById(`tab-btn-${t}`);
        const sec = document.getElementById(`section-${t}`);
        if (btn && sec) {
            if (t === tabId) {
                btn.classList.add('active');
                sec.classList.remove('hidden');
            } else {
                btn.classList.remove('active');
                sec.classList.add('hidden');
            }
        }
    });
    window.location.hash = tabId;
}

// --- Render Payment Methods (Billing Section) ---
function renderPaymentMethods() {
    const container = document.getElementById('payment-methods-grid');
    if (!container) return;

    container.innerHTML = profileState.paymentMethods.map(pm => {
        const iconClass = pm.type === 'visa' 
            ? 'fa-brands fa-cc-visa text-blue-400' 
            : (pm.type === 'mastercard' ? 'fa-brands fa-cc-mastercard text-amber-500' : 'fa-solid fa-building-columns text-emerald-400');
        
        return `
            <div class="rounded-xl border ${pm.isDefault ? 'border-luxe-gold/50 bg-flame-soft/20' : 'border-white/10 bg-atelier-surface'} p-5 flex flex-col justify-between transition hover:border-white/30">
                <div>
                    <div class="flex items-center justify-between">
                        <i class="${iconClass} text-2xl"></i>
                        ${pm.isDefault ? `<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-luxe-gold/20 text-luxe-gold border border-luxe-gold/30">Primary</span>` : ''}
                    </div>
                    <div class="font-mono text-sm text-atelier-cream mt-3 tracking-wider">
                        ${pm.type === 'upi' ? pm.last4 : `•••• •••• •••• ${pm.last4}`}
                    </div>
                    <div class="flex justify-between text-xs text-atelier-muted mt-2">
                        <span>${pm.holder}</span>
                        <span>${pm.exp}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    ${!pm.isDefault ? `
                        <button onclick="setDefaultPaymentMethod('${pm.id}')" class="text-luxe-gold hover:underline font-semibold text-[11px]">
                            Set as Primary
                        </button>
                    ` : `<span class="text-luxe-sage text-[11px]"><i class="fa-solid fa-check"></i> Default Active</span>`}
                    <button onclick="deletePaymentMethod('${pm.id}')" class="text-atelier-dim hover:text-red-400 transition" title="Remove method">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

// --- Render Invoices (Billing Section) ---
function renderInvoices(filterText = '') {
    const tbody = document.getElementById('invoices-table-body');
    if (!tbody) return;

    const filtered = profileState.invoices.filter(inv => 
        inv.id.toLowerCase().includes(filterText.toLowerCase()) || 
        inv.description.toLowerCase().includes(filterText.toLowerCase())
    );

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-atelier-muted">No invoices found matching your criteria.</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.map(inv => `
        <tr class="hover:bg-white/[0.02] transition">
            <td class="py-3.5 font-mono font-semibold text-luxe-gold">${inv.id}</td>
            <td class="py-3.5 text-atelier-muted">${inv.date}</td>
            <td class="py-3.5 text-atelier-cream max-w-xs truncate">${inv.description}</td>
            <td class="py-3.5 font-semibold text-atelier-cream">₹${inv.amount.toLocaleString()}</td>
            <td class="py-3.5">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-luxe-sage/20 text-luxe-sage border border-luxe-sage/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-luxe-sage"></span> ${inv.status}
                </span>
            </td>
            <td class="py-3.5 text-right">
                <button onclick="viewInvoiceDetails('${inv.id}')" class="inline-flex items-center gap-1 px-3 py-1 rounded bg-atelier-card hover:bg-white/10 border border-white/10 text-atelier-cream text-xs transition">
                    <i class="fa-solid fa-eye text-[10px]"></i> View Tax Slip
                </button>
            </td>
        </tr>
    `).join('');
}

// --- Order State & Filter Controllers ---
let currentOrderFilter = 'all';
let orderSearchQuery = '';

function setOrderFilter(filter) {
    currentOrderFilter = filter;
    ['all', 'active', 'delivered'].forEach(f => {
        const btn = document.getElementById(`order-filter-${f}`);
        if (btn) {
            if (f === filter) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }
    });
    renderOrders();
}

function handleOrderSearch(query) {
    orderSearchQuery = (query || '').trim().toLowerCase();
    const clearBtn = document.getElementById('order-search-clear');
    if (clearBtn) {
        if (orderSearchQuery.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
    renderOrders();
}

function clearOrderSearch() {
    const input = document.getElementById('order-search-input');
    if (input) input.value = '';
    handleOrderSearch('');
}

function getOrderItems(order) {
    if (order.items && Array.isArray(order.items) && order.items.length > 0) {
        return order.items.map(item => ({
            name: item.product_name || item.name || 'Artisan Candle',
            quantity: item.quantity || 1,
            price: parseFloat(item.price || 0),
            subtotal: parseFloat(item.subtotal || (item.price * item.quantity) || 0)
        }));
    }
    if (order.candles && Array.isArray(order.candles) && order.candles.length > 0) {
        return order.candles.map(c => {
            if (typeof c === 'string') {
                const parts = c.split(' × ');
                const name = parts[0] || c;
                const qty = parts[1] ? parseInt(parts[1], 10) : 1;
                const totalAmount = parseFloat(order.total) || 2000;
                const totalCount = parseInt(order.itemsCount, 10) || 2;
                const approxPrice = Math.round(totalAmount / totalCount);
                return {
                    name: name,
                    quantity: qty,
                    price: approxPrice,
                    subtotal: approxPrice * qty
                };
            }
            return {
                name: c.name || 'Artisan Candle',
                quantity: c.quantity || 1,
                price: parseFloat(c.price || 0),
                subtotal: parseFloat(c.subtotal || 0)
            };
        });
    }
    return [{
        name: 'Bespoke Atelier Fragrance Commission',
        quantity: order.itemsCount || 1,
        price: parseFloat(order.total || 0),
        subtotal: parseFloat(order.total || 0)
    }];
}

function getOrderStep(statusCode) {
    const code = (statusCode || '').toLowerCase();
    if (code === 'delivered' || code === 'completed') return 4;
    if (code === 'dispatched' || code === 'in_transit' || code === 'shipping') return 3;
    if (code === 'pouring' || code === 'curing' || code === 'processing') return 2;
    return 1; // pending or confirmed
}

function getStatusBadge(order) {
    const step = getOrderStep(order.statusCode);
    if (step === 4) {
        return `
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-luxe-sage/20 text-luxe-sage border border-luxe-sage/30">
                <i class="fa-solid fa-circle-check text-[10px]"></i> Delivered
            </span>
        `;
    }
    if (step === 3) {
        return `
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-500/15 text-blue-400 border border-blue-400/30">
                <i class="fa-solid fa-truck-fast text-[10px]"></i> Dispatched
            </span>
        `;
    }
    if (step === 2) {
        return `
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-flame-soft text-flame-glow border border-flame-glow/30">
                <i class="fa-solid fa-fire text-[10px] animate-pulse"></i> Pouring & Curing
            </span>
        `;
    }
    return `
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-amber-500/15 text-amber-400 border border-amber-400/30">
            <i class="fa-regular fa-clock text-[10px]"></i> Order Confirmed
        </span>
    `;
}

function copyOrderId(orderId, btnElement) {
    const cleanId = orderId.replace('#', '');
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(cleanId).then(() => {
            showToast(`Order ID #${cleanId} copied to clipboard!`);
            if (btnElement) {
                const old = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="fa-solid fa-check text-luxe-sage text-[11px]"></i>';
                setTimeout(() => { btnElement.innerHTML = old; }, 2000);
            }
        }).catch(() => {
            showToast(`Order ID: #${cleanId}`);
        });
    } else {
        showToast(`Order ID: #${cleanId}`);
    }
}

function renderOrderStepper(currentStep) {
    const steps = [
        { label: 'Confirmed', icon: 'fa-check' },
        { label: 'Pouring & Curing', icon: 'fa-fire' },
        { label: 'Dispatched', icon: 'fa-truck-fast' },
        { label: 'Delivered', icon: 'fa-house-chimney' }
    ];

    const progressMap = { 1: 15, 2: 48, 3: 80, 4: 100 };
    const progressPct = progressMap[currentStep] || 15;

    return `
        <div class="py-3 px-2 sm:px-4 my-3 bg-atelier-surface/50 border border-white/5 rounded-xl">
            <div class="relative px-2 sm:px-6">
                <!-- Background track -->
                <div class="absolute top-4 left-6 right-6 h-0.5 bg-white/10 -translate-y-1/2 rounded-full"></div>
                <!-- Active filled track -->
                <div class="absolute top-4 left-6 h-0.5 bg-gradient-to-r from-luxe-gold to-flame-glow -translate-y-1/2 rounded-full transition-all duration-500" style="width: calc(${progressPct}% - 2rem);"></div>

                <!-- Steps container -->
                <div class="relative flex justify-between items-start text-center">
                    ${steps.map((st, idx) => {
                        const stepNum = idx + 1;
                        const isCompleted = stepNum < currentStep;
                        const isCurrent = stepNum === currentStep;

                        let nodeHtml = '';
                        if (isCompleted) {
                            nodeHtml = `
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-luxe-gold text-atelier-base flex items-center justify-center text-xs font-bold shadow-md mx-auto">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                </div>
                                <span class="text-[10px] sm:text-xs font-semibold text-atelier-cream mt-1.5 block">${st.label}</span>
                            `;
                        } else if (isCurrent) {
                            nodeHtml = `
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-flame-glow to-luxe-gold text-white flex items-center justify-center text-xs font-bold shadow-lg ring-4 ring-flame-glow/20 animate-pulse mx-auto">
                                    <i class="fa-solid ${st.icon} text-[10px]"></i>
                                </div>
                                <span class="text-[10px] sm:text-xs font-bold text-luxe-gold mt-1.5 block">${st.label}</span>
                            `;
                        } else {
                            nodeHtml = `
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-atelier-card border border-white/15 text-atelier-dim flex items-center justify-center text-[10px] mx-auto">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                                </div>
                                <span class="text-[10px] sm:text-xs text-atelier-dim mt-1.5 block">${st.label}</span>
                            `;
                        }

                        return `
                            <div class="flex-1 max-w-[85px] sm:max-w-[120px]">
                                ${nodeHtml}
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        </div>
    `;
}

// --- Render Orders Main UI ---
function renderOrders() {
    const container = document.getElementById('orders-list-container');
    if (!container) return;

    const orders = profileState.orders || [];
    const totalCount = orders.length;

    // Calculate active vs delivered
    const activeOrders = orders.filter(o => {
        const step = getOrderStep(o.statusCode);
        return step < 4;
    });
    const deliveredOrders = orders.filter(o => {
        const step = getOrderStep(o.statusCode);
        return step >= 4;
    });

    // Update Section Metric Chips
    const statTotal = document.getElementById('order-stat-total');
    const statActive = document.getElementById('order-stat-active');
    const statDelivered = document.getElementById('order-stat-delivered');
    if (statTotal) statTotal.textContent = totalCount;
    if (statActive) statActive.textContent = activeOrders.length;
    if (statDelivered) statDelivered.textContent = deliveredOrders.length;

    // Update Filter Tab Badge Counts
    const countAll = document.getElementById('count-filter-all');
    const countActive = document.getElementById('count-filter-active');
    const countDelivered = document.getElementById('count-filter-delivered');
    if (countAll) countAll.textContent = totalCount;
    if (countActive) countActive.textContent = activeOrders.length;
    if (countDelivered) countDelivered.textContent = deliveredOrders.length;

    // Update Header Metric (in identity banner)
    const statHeaderTotal = document.getElementById('stat-total-orders');
    if (statHeaderTotal) statHeaderTotal.textContent = totalCount;

    // Apply Filter
    let filtered = orders;
    if (currentOrderFilter === 'active') {
        filtered = activeOrders;
    } else if (currentOrderFilter === 'delivered') {
        filtered = deliveredOrders;
    }

    // Apply Search
    if (orderSearchQuery) {
        filtered = filtered.filter(o => {
            const idMatch = (o.id || '').toLowerCase().includes(orderSearchQuery);
            const statusMatch = (o.status || '').toLowerCase().includes(orderSearchQuery);
            const descMatch = (o.statusDesc || '').toLowerCase().includes(orderSearchQuery);
            const dateMatch = (o.date || '').toLowerCase().includes(orderSearchQuery);
            const candlesMatch = (o.candles || []).some(c => (typeof c === 'string' ? c : c.name || '').toLowerCase().includes(orderSearchQuery));
            const itemsMatch = (o.items || []).some(i => (i.product_name || i.name || '').toLowerCase().includes(orderSearchQuery));
            return idMatch || statusMatch || descMatch || dateMatch || candlesMatch || itemsMatch;
        });
    }

    // Empty state
    if (filtered.length === 0) {
        if (orderSearchQuery || currentOrderFilter !== 'all') {
            container.innerHTML = `
                <div class="text-center py-12 px-4 rounded-2xl border border-white/5 bg-atelier-card/40">
                    <div class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-atelier-muted text-lg mx-auto mb-3">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </div>
                    <h4 class="font-display text-lg font-semibold text-atelier-cream">No matching commissions found</h4>
                    <p class="text-xs text-atelier-muted max-w-sm mx-auto mt-1 mb-4">
                        We couldn't find any orders matching "${orderSearchQuery || currentOrderFilter}".
                    </p>
                    <button onclick="clearOrderSearch(); setOrderFilter('all');" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-atelier-surface hover:bg-white/10 border border-white/10 text-xs font-semibold uppercase tracking-wider text-atelier-cream hover:text-luxe-gold transition">
                        <i class="fa-solid fa-arrows-rotate text-xs"></i> Reset Filter
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div class="text-center py-12 px-4 rounded-2xl border border-white/5 bg-atelier-card/40">
                <div class="w-14 h-14 rounded-full bg-luxe-gold/10 border border-luxe-gold/30 flex items-center justify-center text-luxe-gold text-xl mx-auto mb-3">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h4 class="font-display text-xl font-semibold text-atelier-cream">No Commission History Yet</h4>
                <p class="text-xs text-atelier-muted max-w-sm mx-auto mt-1 mb-5">
                    Your personal sanctuary commission history will appear here once you order your first hand-crafted fragrance candle.
                </p>
                <a href="/#collection" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition shadow-lg">
                    <i class="fa-solid fa-fire text-xs"></i> Explore Signature Scents
                </a>
            </div>
        `;
        return;
    }

    // Render Order Cards
    container.innerHTML = filtered.map(order => {
        const items = getOrderItems(order);
        const currentStep = getOrderStep(order.statusCode);
        const badgeHtml = getStatusBadge(order);
        const stepperHtml = renderOrderStepper(currentStep);

        return `
            <div class="rounded-2xl border border-white/10 bg-atelier-surface/90 hover:border-luxe-gold/30 transition p-5 sm:p-6 shadow-sm group">
                <!-- Top Row: Order ID, Date, Status, Total -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="flex items-center gap-1.5 bg-white/5 border border-white/10 px-2.5 py-1 rounded-lg">
                            <span class="font-mono text-sm font-bold text-luxe-gold">#${order.id}</span>
                            <button onclick="copyOrderId('${order.id}', this)" class="text-atelier-dim hover:text-luxe-gold transition ml-1 text-xs" title="Copy Order ID" aria-label="Copy Order ID">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>
                        <span class="text-xs text-atelier-muted">Placed on <strong class="text-atelier-cream font-medium">${order.date}</strong></span>
                        ${order.estimatedDelivery ? `
                            <span class="inline-flex items-center gap-1 text-[11px] text-atelier-dim bg-white/[0.03] px-2 py-0.5 rounded-full border border-white/5">
                                <i class="fa-regular fa-calendar-check text-[10px] text-luxe-gold"></i>
                                Est: ${order.estimatedDelivery}
                            </span>
                        ` : ''}
                    </div>

                    <div class="flex items-center gap-3 justify-between sm:justify-end">
                        ${badgeHtml}
                        <div class="text-right">
                            <span class="text-base sm:text-lg font-bold font-display text-atelier-cream">₹${(parseFloat(order.total) || 0).toLocaleString()}</span>
                        </div>
                    </div>
                </div>

                <!-- 4-Stage Visual Progress Stepper -->
                ${stepperHtml}

                <!-- Status Context Banner -->
                <div class="flex items-start gap-2.5 px-3.5 py-2.5 rounded-xl bg-white/[0.02] border border-white/5 text-xs text-atelier-muted mb-4">
                    <span class="text-luxe-gold text-xs mt-0.5"><i class="fa-solid fa-sparkles"></i></span>
                    <span class="leading-relaxed">${order.statusDesc || 'Commission received and entered in artisan master ledger.'}</span>
                </div>

                <!-- Ordered Items List -->
                <div class="border-t border-b border-white/5 py-3 mb-4 space-y-2.5">
                    <div class="text-[10px] uppercase font-bold tracking-widest text-atelier-dim">Items Commissioned (${items.length})</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        ${items.map(it => `
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-atelier-card/60 border border-white/5">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-flame-soft/20 border border-white/10 flex items-center justify-center text-flame-glow shrink-0 text-xs">
                                        <i class="fa-solid fa-fire"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold text-atelier-cream truncate">${it.name}</div>
                                        <div class="text-[11px] text-atelier-dim">Qty: ${it.quantity} · ₹${it.price.toLocaleString()} each</div>
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-atelier-cream shrink-0 pl-2">
                                    ₹${(it.subtotal || it.price * it.quantity).toLocaleString()}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <!-- Footer: Destination Address & Action Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1">
                    <div class="text-xs text-atelier-dim flex items-center gap-2 max-w-md truncate">
                        <i class="fa-solid fa-location-dot text-luxe-gold text-xs shrink-0"></i>
                        <span class="truncate">Delivery to: <strong class="text-atelier-muted font-normal">${order.shippingAddress || 'Primary Sanctuary Residence, Mumbai'}</strong></span>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap self-end sm:self-auto">
                        <button onclick="openOrderTrackModal('${order.id}')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-luxe-gold text-atelier-base hover:bg-white text-xs font-bold uppercase tracking-wider transition shadow-sm">
                            <i class="fa-solid fa-route text-[11px]"></i> Track Order
                        </button>
                        <button onclick="viewOrderInvoice('${order.id}')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-atelier-card hover:bg-white/10 border border-white/10 text-atelier-cream hover:text-white text-xs font-medium transition" title="View tax invoice slip">
                            <i class="fa-solid fa-file-invoice text-[11px] text-luxe-gold"></i> Invoice
                        </button>
                        <button onclick="reorderBatch('${order.id}')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-atelier-card hover:bg-white/10 border border-white/10 text-atelier-cream hover:text-luxe-gold text-xs font-medium transition" title="Reorder these candles">
                            <i class="fa-solid fa-arrows-rotate text-[11px]"></i> Reorder
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// --- Render Bespoke Formulas ---
function renderFormulas() {
    const container = document.getElementById('formulas-grid');
    if (!container) return;

    container.innerHTML = profileState.formulas.map(f => `
        <div class="rounded-xl border border-white/10 bg-atelier-surface p-5 flex flex-col justify-between hover:border-luxe-gold/40 transition">
            <div>
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-mono text-[10px] text-luxe-gold uppercase tracking-widest">${f.id}</span>
                        <h3 class="font-display text-lg font-semibold text-atelier-cream mt-0.5">${f.name}</h3>
                    </div>
                    <span class="text-[10px] text-atelier-dim">${f.dateCreated}</span>
                </div>

                <div class="my-3 text-xs text-atelier-muted space-y-1.5 border-y border-white/5 py-2.5">
                    <div><strong class="text-atelier-dim uppercase text-[10px]">Top Note:</strong> <span class="text-atelier-cream">${f.top}</span></div>
                    <div><strong class="text-atelier-dim uppercase text-[10px]">Heart Note:</strong> <span class="text-atelier-cream">${f.heart}</span></div>
                    <div><strong class="text-atelier-dim uppercase text-[10px]">Base Note:</strong> <span class="text-atelier-cream">${f.base}</span></div>
                </div>

                <div class="text-[11px] text-atelier-muted italic">
                    "${f.notes}"
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between">
                <span class="text-[10px] text-atelier-dim uppercase tracking-wider">${f.vessel}</span>
                <button onclick="pourBespokeCandle('${f.id}')" class="px-3 py-1.5 rounded-lg bg-luxe-gold/20 border border-luxe-gold text-luxe-gold text-[10px] font-bold uppercase tracking-wider hover:bg-luxe-gold hover:text-atelier-base transition">
                    Pour Custom Batch
                </button>
            </div>
        </div>
    `).join('');
}

// --- Render Addresses ---
function renderAddresses() {
    const container = document.getElementById('addresses-grid');
    if (!container) return;

    container.innerHTML = profileState.addresses.map(addr => `
        <div class="rounded-xl border ${addr.isDefault ? 'border-luxe-gold/40 bg-flame-soft/10' : 'border-white/10 bg-atelier-surface'} p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-atelier-cream flex items-center gap-1.5">
                        <i class="fa-solid fa-house-chimney text-[11px] text-luxe-gold"></i> ${addr.label}
                    </span>
                    ${addr.isDefault ? `<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-luxe-gold/20 text-luxe-gold border border-luxe-gold/30">Default</span>` : ''}
                </div>
                <p class="text-xs text-atelier-muted leading-relaxed">${addr.street}</p>
                <p class="text-xs text-atelier-dim mt-1">${addr.city} — ${addr.pincode}, India</p>
            </div>

            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                ${!addr.isDefault ? `
                    <button onclick="setDefaultAddress('${addr.id}')" class="text-luxe-gold hover:underline text-[11px] font-semibold">
                        Set as Default
                    </button>
                ` : `<span class="text-luxe-sage text-[11px]"><i class="fa-solid fa-check"></i> Active Sanctuary</span>`}
                <button onclick="deleteAddress('${addr.id}')" class="text-atelier-dim hover:text-red-400 transition" title="Delete address">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// --- Interactive Handlers ---

function setDefaultPaymentMethod(id) {
    profileState.paymentMethods.forEach(pm => {
        pm.isDefault = (pm.id === id);
    });
    renderPaymentMethods();
    showToast('Primary payment card updated successfully.');
}

function deletePaymentMethod(id) {
    if (profileState.paymentMethods.length <= 1) {
        showToast('You must keep at least one saved payment method.', true);
        return;
    }
    profileState.paymentMethods = profileState.paymentMethods.filter(pm => pm.id !== id);
    renderPaymentMethods();
    showToast('Payment method removed.');
}

function openAddCardModal() {
    openModal('modal-add-card');
}

function submitNewCard() {
    const name = document.getElementById('card-name').value;
    const number = document.getElementById('card-number').value.replace(/\s+/g, '');
    const exp = document.getElementById('card-expiry').value;
    const isDefault = document.getElementById('card-default').checked;

    const last4 = number.slice(-4) || '7721';
    const newCard = {
        id: 'pm-' + Date.now(),
        type: 'visa',
        brand: 'Visa Atelier Card',
        last4: last4,
        exp: exp,
        holder: name,
        isDefault: isDefault
    };

    if (isDefault) {
        profileState.paymentMethods.forEach(pm => pm.isDefault = false);
    }
    profileState.paymentMethods.push(newCard);

    closeModal('modal-add-card');
    document.getElementById('add-card-form').reset();
    renderPaymentMethods();
    showToast('New payment card encrypted and saved.');
}

function viewInvoiceDetails(invId) {
    const inv = profileState.invoices.find(i => i.id === invId);
    if (!inv) return;

    document.getElementById('invoice-modal-title').textContent = `Tax Invoice #${inv.id}`;
    
    const content = document.getElementById('invoice-modal-content');
    content.innerHTML = `
        <div class="grid grid-cols-2 gap-4 border-b border-white/10 pb-4">
            <div>
                <span class="text-[10px] uppercase tracking-wider text-atelier-dim">Billed To</span>
                <div class="font-semibold text-atelier-cream mt-0.5">${profileState.user.firstName} ${profileState.user.lastName}</div>
                <div class="text-atelier-muted">7B, Sea Face Promenade, Worli</div>
                <div class="text-atelier-dim">GSTIN: 27AADCS9982Q1Z3</div>
            </div>
            <div class="text-right">
                <span class="text-[10px] uppercase tracking-wider text-atelier-dim">Issuer</span>
                <div class="font-display font-bold text-luxe-gold text-base">SONDHI BOTANICALS ATELIER</div>
                <div class="text-atelier-muted">14 Heritage Mill, Colaba, Mumbai</div>
                <div class="text-atelier-dim">Date: ${inv.date}</div>
            </div>
        </div>

        <div>
            <span class="text-[10px] uppercase tracking-wider text-atelier-dim block mb-2">Line Items</span>
            <div class="space-y-2">
                ${inv.items.map(item => `
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <div>
                            <div class="font-medium text-atelier-cream">${item.name}</div>
                            <div class="text-[11px] text-atelier-dim">Quantity: ${item.qty}</div>
                        </div>
                        <div class="font-semibold text-atelier-cream">₹${(item.price * item.qty).toLocaleString()}</div>
                    </div>
                `).join('')}
            </div>
        </div>

        <div class="border-t border-white/10 pt-3 space-y-1.5 text-right">
            <div class="flex justify-between text-atelier-muted">
                <span>Subtotal:</span>
                <span>₹${inv.subtotal.toLocaleString()}</span>
            </div>
            <div class="flex justify-between text-atelier-muted">
                <span>Integrated GST (12%):</span>
                <span>₹${inv.tax.toFixed(2)}</span>
            </div>
            <div class="flex justify-between text-sm font-bold text-luxe-gold pt-2 border-t border-white/10">
                <span>Total Amount Paid:</span>
                <span>₹${inv.amount.toLocaleString()}</span>
            </div>
        </div>

        <div class="p-3 bg-white/[0.02] border border-white/10 rounded-lg text-[11px] text-atelier-dim">
            <i class="fa-solid fa-lock text-luxe-gold mr-1"></i> Paid via Encrypted Stripe Payment Gateway · Transaction Auth #AUTH-${inv.id.replace('INV-', '')}-99
        </div>
    `;

    openModal('modal-invoice');
}

function filterInvoices() {
    const val = document.getElementById('invoice-search').value;
    renderInvoices(val);
}

function downloadAllReceipts() {
    showToast('Compiling annual tax invoices into PDF statement...');
    setTimeout(() => {
        showToast('Tax statement downloaded successfully.');
    }, 1200);
}

function openAddAddressModal() {
    openModal('modal-add-address');
}

function submitNewAddress() {
    const label = document.getElementById('addr-label').value;
    const street = document.getElementById('addr-street').value;
    const city = document.getElementById('addr-city').value;
    const pincode = document.getElementById('addr-pincode').value;

    const newAddr = {
        id: 'addr-' + Date.now(),
        label: label,
        street: street,
        city: city,
        pincode: pincode,
        isDefault: false
    };

    profileState.addresses.push(newAddr);
    closeModal('modal-add-address');
    document.getElementById('add-address-form').reset();
    renderAddresses();
    showToast('New sanctuary delivery address saved.');
}

function setDefaultAddress(id) {
    profileState.addresses.forEach(a => a.isDefault = (a.id === id));
    renderAddresses();
    showToast('Primary sanctuary address updated.');
}

function deleteAddress(id) {
    if (profileState.addresses.length <= 1) {
        showToast('You must keep at least one address.', true);
        return;
    }
    profileState.addresses = profileState.addresses.filter(a => a.id !== id);
    renderAddresses();
    showToast('Address removed.');
}

function saveProfileDetails() {
    const first = document.getElementById('input-first-name').value;
    const last = document.getElementById('input-last-name').value;
    const email = document.getElementById('input-email').value;
    const phone = document.getElementById('input-phone') ? document.getElementById('input-phone').value : '';

    profileState.user.firstName = first;
    profileState.user.lastName = last;
    profileState.user.email = email;
    profileState.user.phone = phone;

    if (window.sondhiAuth) {
        window.sondhiAuth.updateUser({
            fullName: `${first} ${last}`.trim(),
            email: email,
            phone: phone
        });
    }

    updateIdentityHeader();
    showToast('Patron profile credentials updated.');
}

function updateIdentityHeader() {
    const fullName = `${profileState.user.firstName} ${profileState.user.lastName}`.trim() || 'Patron';
    const initials = `${(profileState.user.firstName[0] || 'P')}${(profileState.user.lastName[0] || '')}`.toUpperCase();

    const heroName = document.getElementById('hero-user-name');
    const headerName = document.getElementById('header-user-name');
    const heroEmail = document.getElementById('hero-user-email');
    const initialsEl = document.getElementById('profile-avatar-initials');
    const avatarEl = document.getElementById('header-user-avatar');
    const tierEl = document.getElementById('header-user-tier');
    const statRewards = document.getElementById('stat-rewards-points');
    const statBespoke = document.getElementById('stat-bespoke-formulas');

    if (heroName) heroName.textContent = fullName;
    if (headerName) headerName.textContent = fullName;
    if (heroEmail) heroEmail.textContent = `${profileState.user.email} · Client since 2026`;
    if (initialsEl) initialsEl.textContent = initials;
    if (avatarEl) avatarEl.textContent = initials;
    if (tierEl) tierEl.textContent = profileState.user.tier || 'Patron';
    if (statRewards) statRewards.textContent = (profileState.user.points || 0).toLocaleString();
    if (statBespoke) statBespoke.textContent = (profileState.formulas || []).length;
}

function manageMembershipModal() {
    showToast('Flame Circle membership is active until November 15, 2026.');
}

function reorderBatch(orderId) {
    const cleanId = orderId.replace('#', '');
    const order = (profileState.orders || []).find(o => o.id === cleanId || o.id === orderId);
    showToast(`Items from #${cleanId} added to your commission bag!`);
    
    // Add to session / cart if available
    if (window.sondhiCart && typeof window.sondhiCart.addItem === 'function') {
        const items = getOrderItems(order || {});
        items.forEach(it => {
            window.sondhiCart.addItem({
                id: it.id || Math.floor(Math.random() * 8) + 1,
                name: it.name,
                price: it.price,
                quantity: it.quantity
            });
        });
    }
}

function viewOrderInvoice(orderId) {
    const cleanId = orderId.replace('#', '');
    let inv = (profileState.invoices || []).find(i => 
        (i.id && i.id.includes(cleanId.replace('SND-', ''))) || 
        (i.description && i.description.includes(cleanId))
    );

    if (!inv) {
        const order = (profileState.orders || []).find(o => o.id === cleanId || o.id === orderId);
        if (order) {
            const items = getOrderItems(order);
            const subtotal = order.subtotal || order.total || 2500;
            const tax = Math.round(subtotal * 0.12 * 100) / 100;
            inv = {
                id: 'INV-' + cleanId.replace('SND-', ''),
                date: order.date,
                description: `Order #${cleanId} · ${items.map(i => `${i.quantity}x ${i.name}`).join(', ')}`,
                amount: order.total || subtotal,
                status: 'Paid',
                items: items.map(i => ({ name: i.name, qty: i.quantity, price: i.price })),
                tax: tax,
                subtotal: subtotal
            };
            if (!profileState.invoices) profileState.invoices = [];
            profileState.invoices.unshift(inv);
        }
    }

    if (inv) {
        viewInvoiceDetails(inv.id);
    } else {
        showToast(`Tax invoice generated for #${cleanId}`);
    }
}

function openOrderTrackModal(orderId) {
    const cleanId = orderId.replace('#', '');
    const order = (profileState.orders || []).find(o => o.id === cleanId || o.id === orderId);
    if (!order) return;

    const modal = document.getElementById('modal-order-track');
    const content = document.getElementById('track-modal-content');
    const title = document.getElementById('track-modal-title');
    const badge = document.getElementById('track-modal-badge');
    const whatsappLink = document.getElementById('track-modal-whatsapp');

    if (title) title.textContent = `Order #${order.id}`;
    if (badge) {
        const step = getOrderStep(order.statusCode);
        badge.textContent = order.status || 'Active';
        if (step === 4) {
            badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-luxe-sage/20 text-luxe-sage border border-luxe-sage/30';
        } else if (step === 3) {
            badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-500/15 text-blue-400 border border-blue-400/30';
        } else {
            badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-flame-soft text-flame-glow border border-flame-glow/30';
        }
    }

    if (whatsappLink) {
        const waText = encodeURIComponent(`Hello Sondhi Atelier Concierge, I would like an update on my candle order #${order.id}.`);
        whatsappLink.href = `https://wa.me/919876543210?text=${waText}`;
    }

    const items = getOrderItems(order);
    const step = getOrderStep(order.statusCode);
    const awbNumber = 'BLD-' + (order.id.replace(/\D/g, '') || '9014') + '884';

    const timeline = [
        {
            title: 'Order Confirmed & Payment Verified',
            desc: 'Commission committed to master pouring ledger; artisan allocated.',
            time: order.date + ' · 09:30 AM',
            isDone: step >= 1,
            isCurrent: step === 1
        },
        {
            title: 'Artisan Hand-Pouring & 48-Hour Curing',
            desc: 'Organic coconut-soy wax heated, natural botanical essences infused, and crackling wood wicks centered.',
            time: order.date + ' · 02:45 PM',
            isDone: step >= 2,
            isCurrent: step === 2
        },
        {
            title: 'Dispatched via White-Glove Luxury Courier',
            desc: `Handed over to BlueDart Luxury Logistics under ambient climate control. Tracking AWB: ${awbNumber}`,
            time: step >= 3 ? 'In Transit · Handled with Care' : 'Estimated prior to arrival',
            isDone: step >= 3,
            isCurrent: step === 3
        },
        {
            title: 'Delivered to Client Sanctuary',
            desc: `Signature confirmed at ${order.shippingAddress || 'Sanctuary Residence'}.`,
            time: order.estimatedDelivery || 'Delivered',
            isDone: step >= 4,
            isCurrent: step === 4
        }
    ];

    if (content) {
        content.innerHTML = `
            <!-- Top Summary Card in Modal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 rounded-xl bg-atelier-card/70 border border-white/10 text-xs">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-atelier-dim">Courier Partner</span>
                    <div class="font-semibold text-atelier-cream mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-truck-shield text-luxe-gold text-xs"></i>
                        BlueDart White-Glove Logistics
                    </div>
                    <div class="font-mono text-[11px] text-atelier-muted mt-1 flex items-center gap-1">
                        AWB: <span>${awbNumber}</span>
                        <button onclick="copyOrderId('${awbNumber}', this)" class="text-atelier-dim hover:text-luxe-gold p-0.5 ml-1" title="Copy Tracking Number">
                            <i class="fa-regular fa-copy text-[10px]"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-atelier-dim">Estimated Delivery</span>
                    <div class="font-display font-bold text-base text-luxe-gold mt-0.5">
                        ${order.estimatedDelivery || 'Within 7-9 Business Days'}
                    </div>
                    <div class="text-[11px] text-atelier-dim mt-1">Temperature-monitored packaging</div>
                </div>
            </div>

            <!-- Detailed Chronological Timeline -->
            <div>
                <h4 class="text-xs uppercase font-bold tracking-widest text-atelier-dim mb-3">Live Commission Milestones</h4>
                <div class="space-y-4 relative pl-6 border-l-2 border-white/10 ml-2">
                    ${timeline.map(tl => {
                        let dotHtml = '';
                        if (tl.isCurrent) {
                            dotHtml = `<span class="absolute -left-[13px] top-0.5 w-6 h-6 rounded-full bg-gradient-to-br from-flame-glow to-luxe-gold text-white flex items-center justify-center text-[10px] shadow-lg ring-4 ring-flame-glow/20 animate-pulse"><i class="fa-solid fa-fire text-[9px]"></i></span>`;
                        } else if (tl.isDone) {
                            dotHtml = `<span class="absolute -left-[13px] top-0.5 w-6 h-6 rounded-full bg-luxe-gold text-atelier-base flex items-center justify-center text-[10px] shadow"><i class="fa-solid fa-check text-[9px]"></i></span>`;
                        } else {
                            dotHtml = `<span class="absolute -left-[13px] top-0.5 w-6 h-6 rounded-full bg-atelier-surface border border-white/20 text-atelier-dim flex items-center justify-center text-[10px]"><span class="w-1.5 h-1.5 rounded-full bg-white/20"></span></span>`;
                        }

                        return `
                            <div class="relative">
                                ${dotHtml}
                                <div class="text-xs font-semibold ${tl.isCurrent ? 'text-luxe-gold' : (tl.isDone ? 'text-atelier-cream' : 'text-atelier-dim')}">
                                    ${tl.title}
                                </div>
                                <div class="text-[11px] text-atelier-muted mt-0.5 leading-relaxed">
                                    ${tl.desc}
                                </div>
                                <div class="text-[10px] text-atelier-dim mt-1 font-mono">
                                    ${tl.time}
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>

            <!-- Delivery Address & Items Mini-Card -->
            <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5 text-xs space-y-2">
                <div class="flex items-start gap-2 text-atelier-muted">
                    <i class="fa-solid fa-location-dot text-luxe-gold text-xs mt-0.5"></i>
                    <div>
                        <span class="text-atelier-cream font-medium">Delivering to:</span>
                        <span>${order.shippingAddress || '7B, Sea Face Promenade, Worli, Mumbai - 400018'}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-white/5 text-atelier-dim text-[11px]">
                    <span class="truncate max-w-[280px]">Candles: ${items.map(i => i.name).join(', ')}</span>
                    <span class="font-bold text-atelier-cream font-display text-sm shrink-0">₹${(parseFloat(order.total) || 0).toLocaleString()}</span>
                </div>
            </div>
        `;
    }

    openModal('modal-order-track');
}

function pourBespokeCandle(formulaId) {
    showToast(`Formula ${formulaId} sent to the pouring bench queue!`);
}

function openAvatarModal() {
    showToast('Profile portrait update simulation active.');
}

// --- Generic Modal Helpers ---
function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('opacity-0', 'pointer-events-none');
    const inner = modal.querySelector('.scale-95');
    if (inner) {
        inner.classList.remove('scale-95');
        inner.classList.add('scale-100');
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('opacity-0', 'pointer-events-none');
    const inner = modal.querySelector('.scale-100');
    if (inner) {
        inner.classList.remove('scale-100');
        inner.classList.add('scale-95');
    }
}

// --- Toast notification ---
function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    const msg = document.getElementById('toast-message');
    const icon = document.getElementById('toast-icon');
    if (!toast || !msg) return;

    msg.textContent = message;
    if (isError) {
        icon.className = 'fa-solid fa-circle-exclamation text-red-400 text-sm';
        toast.style.borderColor = 'rgba(248, 113, 113, 0.6)';
    } else {
        icon.className = 'fa-solid fa-circle-check text-luxe-gold text-sm';
        toast.style.borderColor = '#E5C378';
    }

    toast.classList.remove('opacity-0', 'pointer-events-none');
    toast.classList.add('translate-y-0');

    setTimeout(() => {
        toast.classList.add('opacity-0', 'pointer-events-none');
    }, 3200);
}
