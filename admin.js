// ==========================================================================
// SONDHI ATELIER — ADMIN OPERATIONS & BILLING LOGIC
// ==========================================================================

const adminState = {
    payoutBalance: 184520,
    orders: [
        {
            id: 'SND-9014',
            customer: 'Arya Anand',
            tier: 'VIP Collector',
            commission: 'Lavender & Golden Amber (280g) × 2, Rain on Earth × 1',
            total: 2647,
            status: 'Pouring & Curing',
            date: 'Today, 11:20 AM'
        },
        {
            id: 'SND-9015',
            customer: 'Meera Rajput',
            tier: 'Patron',
            commission: 'Sandalwood & Velvet Oud (300g) × 1',
            total: 1299,
            status: 'Pending',
            date: 'Today, 01:45 PM'
        },
        {
            id: 'SND-9016',
            customer: 'Rohan Deshmukh',
            tier: 'Flame Circle Member',
            commission: 'Rose Noir & Velvet Musk × 2',
            total: 1898,
            status: 'Pending',
            date: 'Today, 02:10 PM'
        },
        {
            id: 'SND-9010',
            customer: 'Pooja Singhania',
            tier: 'VIP Collector',
            commission: 'Vanilla Tonka & Bourbon × 1, Neroli Blossom × 1',
            total: 1748,
            status: 'Dispatched',
            date: 'Yesterday, 04:30 PM'
        },
        {
            id: 'SND-9008',
            customer: 'Vikram Kapoor',
            tier: 'Patron',
            commission: 'Custom Studio Formula #FORMULA-771 × 2',
            total: 2998,
            status: 'Pouring & Curing',
            date: 'Sep 17, 2026'
        },
        {
            id: 'SND-9001',
            customer: 'Ananya Birla',
            tier: 'Flame Circle Member',
            commission: 'Rain on Earth (Mitti Attar) × 4 (Gifting Box)',
            total: 3396,
            status: 'Delivered',
            date: 'Sep 16, 2026'
        }
    ],
    products: [
        {
            id: 'prod-1',
            name: 'Lavender & Golden Amber',
            category: 'Floral',
            vessel: 'Smoked Amber Glass (280g)',
            price: 899,
            stock: 42,
            active: true
        },
        {
            id: 'prod-2',
            name: 'Rose Noir & Velvet Musk',
            category: 'Floral',
            vessel: 'Matte Obsidian Ceramic (280g)',
            price: 949,
            stock: 28,
            active: true
        },
        {
            id: 'prod-3',
            name: 'Vanilla Tonka & Bourbon',
            category: 'Warm',
            vessel: 'Frosted Biscuit Ceramic (260g)',
            price: 799,
            stock: 55,
            active: true
        },
        {
            id: 'prod-4',
            name: 'Sandalwood & Velvet Oud',
            category: 'Woody',
            vessel: 'Terracotta Glazed Vessel (300g)',
            price: 1299,
            stock: 14,
            active: true
        },
        {
            id: 'prod-5',
            name: 'Rain on Earth (Mitti Attar)',
            category: 'Fresh',
            vessel: 'Raw Clay Vessel (260g)',
            price: 849,
            stock: 31,
            active: true
        },
        {
            id: 'prod-6',
            name: 'Neroli Blossom & Petitgrain',
            category: 'Floral',
            vessel: 'Smoked Amber Glass (260g)',
            price: 949,
            stock: 22,
            active: true
        }
    ],
    transactions: [
        {
            txnId: 'TXN-99824',
            time: '12 Mins Ago',
            customer: 'Rohan Deshmukh',
            method: 'Visa •••• 1044',
            gross: 1898,
            fee: 40.01,
            net: 1857.99,
            status: 'Captured'
        },
        {
            txnId: 'TXN-99823',
            time: '45 Mins Ago',
            customer: 'Meera Rajput',
            method: 'UPI / HDFC Autopay',
            gross: 1299,
            fee: 0.00,
            net: 1299.00,
            status: 'Captured'
        },
        {
            txnId: 'TXN-99820',
            time: '3 Hours Ago',
            customer: 'Arya Anand',
            method: 'Visa •••• 8842',
            gross: 2647,
            fee: 54.61,
            net: 2592.39,
            status: 'Captured'
        },
        {
            txnId: 'TXN-99812',
            time: 'Yesterday',
            customer: 'Pooja Singhania',
            method: 'Mastercard •••• 3019',
            gross: 1748,
            fee: 37.08,
            net: 1710.92,
            status: 'Captured'
        },
        {
            txnId: 'TXN-99799',
            time: 'Sep 16, 2026',
            customer: 'Devika Parekh',
            method: 'Amex •••• 4001',
            gross: 949,
            fee: 28.47,
            net: 920.53,
            status: 'Refunded'
        }
    ],
    supplies: [
        { name: '100% Botanical Soy Flakes', current: '280 kg', min: '100 kg', status: 'Optimal', icon: 'fa-seedling', color: 'text-luxe-sage' },
        { name: 'Organic Crackling Wood Wicks', current: '620 units', min: '250 units', status: 'Optimal', icon: 'fa-fire', color: 'text-flame-glow' },
        { name: 'Matte Obsidian Vessels', current: '42 units', min: '80 units', status: 'Low Supply', icon: 'fa-mug-hot', color: 'text-amber-400' },
        { name: 'Pure Cambodian Oud Essence', current: '1,200 ml', min: '500 ml', status: 'Optimal', icon: 'fa-flask', color: 'text-luxe-gold' }
    ],
    concierge: [
        {
            id: 'REQ-109',
            customer: 'Siddharth Roy',
            blend: 'Smoked Cardamom, Frankincense & Wild Jasmine',
            vessel: 'Raw Terracotta Pot',
            wick: 'Single Cotton Braided',
            date: 'Today, 10:15 AM'
        },
        {
            id: 'REQ-108',
            customer: 'Zara Merchant',
            blend: 'Petrichor, Roasted Coffee Bean & Tonka',
            vessel: 'Smoked Glass',
            wick: 'Crackling Wood',
            date: 'Yesterday'
        }
    ]
};

// --- Section Auth Check & Initialization ---
function initAdminPage() {
    if (window.sondhiAuth) {
        const globalOrders = window.sondhiAuth.getAllOrders();
        if (globalOrders && globalOrders.length) {
            adminState.orders = globalOrders.map(o => ({
                id: o.id,
                customer: o.customer || o.customerName || 'Patron',
                tier: o.tier || 'Patron',
                commission: o.commission || (Array.isArray(o.candles) ? o.candles.join(', ') : 'Botanical Candle'),
                total: o.total || 0,
                status: o.status || 'Pouring & Curing',
                date: o.date || 'Today'
            }));
        }
    }

    renderAdminOrders('all');
    renderAdminProducts();
    renderAdminBilling();
    renderSupplies();
    renderConciergeQueue();

    const hash = window.location.hash.replace('#', '');
    if (['orders', 'products', 'billing', 'supplies', 'concierge'].includes(hash)) {
        switchAdminTab(hash);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.sondhiAuth) {
        if (!window.sondhiAuth.isSectionUnlocked('admin')) {
            window.sondhiAuth.openSectionPassModal('admin', () => {
                initAdminPage();
            });
        } else {
            initAdminPage();
        }

        window.addEventListener('sondhi_order_placed', () => {
            initAdminPage();
        });
    } else {
        initAdminPage();
    }
});

// --- Tab Switcher ---
function switchAdminTab(tabId) {
    const tabs = ['orders', 'products', 'billing', 'supplies', 'concierge'];
    tabs.forEach(t => {
        const btn = document.getElementById(`tab-admin-${t}`);
        const sec = document.getElementById(`section-admin-${t}`);
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

// --- Render Orders with Status Filters ---
function renderAdminOrders(filterStatus = 'all') {
    const tbody = document.getElementById('admin-orders-table-body');
    if (!tbody) return;

    const filtered = adminState.orders.filter(o => {
        if (filterStatus === 'all') return true;
        return o.status.toLowerCase() === filterStatus.toLowerCase();
    });

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-atelier-muted">No orders match this status filter.</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.map(order => {
        let badgeStyle = 'bg-white/5 text-atelier-muted border-white/10';
        if (order.status === 'Pending') badgeStyle = 'bg-amber-500/15 text-amber-400 border-amber-500/30';
        else if (order.status === 'Pouring & Curing') badgeStyle = 'bg-flame-soft text-flame-glow border-flame-glow/30';
        else if (order.status === 'Dispatched') badgeStyle = 'bg-blue-500/15 text-blue-400 border-blue-500/30';
        else if (order.status === 'Delivered') badgeStyle = 'bg-luxe-sage/15 text-luxe-sage border-luxe-sage/30';

        let nextAction = '';
        if (order.status === 'Pending') {
            nextAction = `<button onclick="advanceOrderStatus('${order.id}', 'Pouring & Curing')" class="px-2.5 py-1 rounded bg-flame-soft hover:bg-flame-amber text-flame-glow hover:text-white border border-flame-glow/30 text-[10px] font-semibold uppercase tracking-wider transition"><i class="fa-solid fa-fire mr-1"></i> Send to Pour</button>`;
        } else if (order.status === 'Pouring & Curing') {
            nextAction = `<button onclick="advanceOrderStatus('${order.id}', 'Dispatched')" class="px-2.5 py-1 rounded bg-blue-500/20 hover:bg-blue-600 text-blue-400 hover:text-white border border-blue-500/30 text-[10px] font-semibold uppercase tracking-wider transition"><i class="fa-solid fa-truck-fast mr-1"></i> Dispatch</button>`;
        } else if (order.status === 'Dispatched') {
            nextAction = `<button onclick="advanceOrderStatus('${order.id}', 'Delivered')" class="px-2.5 py-1 rounded bg-luxe-sage/20 hover:bg-luxe-sage text-luxe-sage hover:text-atelier-base border border-luxe-sage/30 text-[10px] font-semibold uppercase tracking-wider transition"><i class="fa-solid fa-check mr-1"></i> Mark Delivered</button>`;
        } else {
            nextAction = `<span class="text-atelier-dim text-[11px]"><i class="fa-solid fa-check-double text-luxe-sage"></i> Complete</span>`;
        }

        return `
            <tr class="hover:bg-white/[0.02] transition">
                <td class="py-3.5 font-mono font-bold text-luxe-gold">${order.id}</td>
                <td class="py-3.5">
                    <div class="font-semibold text-atelier-cream">${order.customer}</div>
                    <div class="text-[10px] text-luxe-gold uppercase tracking-wider">${order.tier}</div>
                </td>
                <td class="py-3.5 text-atelier-muted max-w-sm truncate">${order.commission}</td>
                <td class="py-3.5 font-semibold text-atelier-cream">₹${order.total.toLocaleString()}</td>
                <td class="py-3.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider border ${badgeStyle}">
                        ${order.status}
                    </span>
                </td>
                <td class="py-3.5 text-right space-x-2">
                    ${nextAction}
                    <button onclick="printPackingSlip('${order.id}')" title="Print White-Glove Packing Slip" class="p-1.5 text-atelier-muted hover:text-white transition">
                        <i class="fa-solid fa-print"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

function filterOrdersByStatus(status) {
    const buttons = document.querySelectorAll('#order-filter-btns button');
    buttons.forEach(btn => {
        btn.className = "px-3 py-1.5 rounded-lg bg-atelier-surface hover:bg-white/10 text-atelier-muted border border-white/10 font-semibold uppercase text-[10px]";
    });
    event.target.className = "px-3 py-1.5 rounded-lg bg-luxe-gold/20 text-luxe-gold border border-luxe-gold font-semibold uppercase text-[10px]";
    renderAdminOrders(status);
}

function advanceOrderStatus(orderId, newStatus) {
    const order = adminState.orders.find(o => o.id === orderId);
    if (order) {
        order.status = newStatus;
        if (window.sondhiAuth) {
            const code = newStatus === 'Pouring & Curing' ? 'pouring' : (newStatus === 'Dispatched' ? 'dispatched' : 'delivered');
            window.sondhiAuth.updateOrderStatus(orderId, newStatus, code);
        }
        renderAdminOrders('all');
        showToast(`Order ${orderId} moved to '${newStatus}'.`);
    }
}

function printPackingSlip(orderId) {
    showToast(`Generating artisan certification & packing slip for ${orderId}...`);
}

// --- Product Catalog Management ---
function renderAdminProducts() {
    const tbody = document.getElementById('admin-products-table-body');
    if (!tbody) return;

    tbody.innerHTML = adminState.products.map(prod => `
        <tr class="hover:bg-white/[0.02] transition">
            <td class="py-3.5">
                <div class="font-semibold text-atelier-cream">${prod.name}</div>
                <div class="text-[10px] text-atelier-dim uppercase tracking-wider">${prod.id}</div>
            </td>
            <td class="py-3.5">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-white/5 border border-white/10 text-atelier-muted">
                    ${prod.category}
                </span>
            </td>
            <td class="py-3.5 text-atelier-muted">${prod.vessel}</td>
            <td class="py-3.5 font-semibold text-luxe-gold">₹${prod.price.toLocaleString()}</td>
            <td class="py-3.5">
                <span class="font-semibold ${prod.stock <= 15 ? 'text-amber-400' : 'text-atelier-cream'}">${prod.stock} units</span>
                ${prod.stock <= 15 ? `<span class="block text-[9px] text-amber-400 font-medium">Low Inventory</span>` : ''}
            </td>
            <td class="py-3.5">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider ${prod.active ? 'bg-luxe-sage/15 text-luxe-sage border border-luxe-sage/30' : 'bg-white/5 text-atelier-dim border border-white/10'}">
                    ${prod.active ? 'Available' : 'Archived'}
                </span>
            </td>
            <td class="py-3.5 text-right space-x-2">
                <button onclick="editProductPrompt('${prod.id}')" class="px-2.5 py-1 rounded bg-atelier-card hover:bg-white/10 border border-white/10 text-[10px] font-semibold text-atelier-cream transition">
                    Edit Price / Stock
                </button>
                <button onclick="toggleProductStatus('${prod.id}')" class="text-xs ${prod.active ? 'text-atelier-dim hover:text-amber-400' : 'text-luxe-sage hover:underline'}" title="Toggle active status">
                    <i class="fa-solid ${prod.active ? 'fa-pause' : 'fa-play'}"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function openNewCandleModal() {
    openModal('modal-new-candle');
}

function submitNewCandle() {
    const name = document.getElementById('candle-name').value;
    const cat = document.getElementById('candle-category').value;
    const price = parseInt(document.getElementById('candle-price').value, 10);
    const burn = document.getElementById('candle-burn').value;
    const stock = parseInt(document.getElementById('candle-stock').value, 10);

    const newProd = {
        id: 'prod-' + (adminState.products.length + 1),
        name: name,
        category: cat,
        vessel: `Signature Vessel (${burn})`,
        price: price,
        stock: stock,
        active: true
    };

    adminState.products.push(newProd);
    closeModal('modal-new-candle');
    document.getElementById('new-candle-form').reset();
    renderAdminProducts();
    showToast(`Fragrance '${name}' added to active atelier collection.`);
}

function toggleProductStatus(id) {
    const prod = adminState.products.find(p => p.id === id);
    if (prod) {
        prod.active = !prod.active;
        renderAdminProducts();
        showToast(`'${prod.name}' status updated to ${prod.active ? 'Available' : 'Archived'}.`);
    }
}

function editProductPrompt(id) {
    const prod = adminState.products.find(p => p.id === id);
    if (!prod) return;
    const newPrice = prompt(`Update retail price for ${prod.name} (Current: ₹${prod.price}):`, prod.price);
    if (newPrice && !isNaN(newPrice)) {
        prod.price = parseInt(newPrice, 10);
        renderAdminProducts();
        showToast(`Price for ${prod.name} updated to ₹${prod.price}.`);
    }
}

// --- Store Billing & Merchant Payouts Section ---
function renderAdminBilling(filterText = '') {
    const tbody = document.getElementById('admin-billing-table-body');
    if (!tbody) return;

    const filtered = adminState.transactions.filter(t => 
        t.txnId.toLowerCase().includes(filterText.toLowerCase()) || 
        t.customer.toLowerCase().includes(filterText.toLowerCase())
    );

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="py-6 text-center text-atelier-muted">No merchant billing transactions found.</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.map(t => {
        const isCaptured = t.status === 'Captured';
        return `
            <tr class="hover:bg-white/[0.02] transition">
                <td class="py-3.5 font-mono font-semibold text-luxe-gold">${t.txnId}</td>
                <td class="py-3.5 text-atelier-muted">${t.time}</td>
                <td class="py-3.5 font-medium text-atelier-cream">${t.customer}</td>
                <td class="py-3.5 text-atelier-muted">${t.method}</td>
                <td class="py-3.5 font-semibold text-atelier-cream">₹${t.gross.toLocaleString()}</td>
                <td class="py-3.5 font-semibold text-luxe-sage">₹${t.net.toFixed(2)}</td>
                <td class="py-3.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider ${isCaptured ? 'bg-luxe-sage/15 text-luxe-sage border border-luxe-sage/30' : 'bg-red-500/15 text-red-400 border border-red-500/30'}">
                        ${t.status}
                    </span>
                </td>
                <td class="py-3.5 text-right">
                    ${isCaptured ? `
                        <button onclick="processRefund('${t.txnId}')" class="text-xs text-atelier-dim hover:text-red-400 transition" title="Initiate refund">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Refund
                        </button>
                    ` : `<span class="text-[11px] text-atelier-dim">Settled</span>`}
                </td>
            </tr>
        `;
    }).join('');
}

function filterAdminBilling() {
    const val = document.getElementById('admin-billing-search').value;
    renderAdminBilling(val);
}

function processRefund(txnId) {
    const txn = adminState.transactions.find(t => t.txnId === txnId);
    if (!txn) return;
    if (confirm(`Are you sure you want to refund ₹${txn.gross} to ${txn.customer}?`)) {
        txn.status = 'Refunded';
        adminState.payoutBalance -= txn.gross;
        const balEl = document.getElementById('kpi-payout-bal');
        if (balEl) balEl.textContent = `₹${adminState.payoutBalance.toLocaleString()}`;
        renderAdminBilling();
        showToast(`Refund processed for transaction ${txnId}. Amount deducted from settlement balance.`);
    }
}

function requestPayoutModal() {
    showToast(`Bank wire transfer of ₹${adminState.payoutBalance.toLocaleString()} initiated to HDFC Bank A/C ••9942.`);
}

function downloadAdminBillingLedger() {
    showToast('Exporting CSV merchant billing report for current month...');
}

// --- Raw Botanicals & Supplies ---
function renderSupplies() {
    const container = document.getElementById('supplies-grid');
    if (!container) return;

    container.innerHTML = adminState.supplies.map(sup => `
        <div class="glass-card rounded-xl p-5 border border-white/10 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <i class="fa-solid ${sup.icon} ${sup.color} text-xl"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-white/5 border border-white/10 ${sup.status === 'Low Supply' ? 'text-amber-400 border-amber-400/40' : 'text-luxe-sage'}">
                        ${sup.status}
                    </span>
                </div>
                <h3 class="font-display text-base font-semibold text-atelier-cream mt-3">${sup.name}</h3>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-xl font-bold font-mono text-atelier-cream">${sup.current}</span>
                    <span class="text-[10px] text-atelier-dim">Min: ${sup.min}</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10">
                <button onclick="restockSuppliesPrompt('${sup.name}')" class="w-full py-1.5 rounded bg-atelier-card hover:bg-white/10 border border-white/10 text-xs text-luxe-gold font-semibold uppercase tracking-wider transition">
                    + Order Stock
                </button>
            </div>
        </div>
    `).join('');
}

function restockSuppliesPrompt(supplyName = 'Botanicals') {
    showToast(`Supplier requisition dispatched for ${supplyName}.`);
}

// --- Concierge Queue ---
function renderConciergeQueue() {
    const container = document.getElementById('concierge-inquiries-container');
    if (!container) return;

    if (adminState.concierge.length === 0) {
        container.innerHTML = `<div class="p-6 text-center text-atelier-muted">No pending bespoke studio commissions in queue.</div>`;
        return;
    }

    container.innerHTML = adminState.concierge.map(c => `
        <div class="rounded-xl border border-white/10 bg-atelier-surface p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs text-luxe-gold font-bold">${c.id}</span>
                    <span class="text-xs text-atelier-cream font-semibold">${c.customer}</span>
                    <span class="text-[10px] text-atelier-dim">· ${c.date}</span>
                </div>
                <div class="text-xs text-atelier-muted mt-1">
                    Formula: <strong class="text-atelier-cream">${c.blend}</strong>
                </div>
                <div class="text-[11px] text-atelier-dim mt-0.5">
                    Specs: ${c.vessel} · ${c.wick} Wick
                </div>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button onclick="approveConciergeFormula('${c.id}')" class="px-3.5 py-1.5 rounded-lg bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition">
                    Approve Pour
                </button>
            </div>
        </div>
    `).join('');
}

function approveConciergeFormula(id) {
    adminState.concierge = adminState.concierge.filter(c => c.id !== id);
    renderConciergeQueue();
    showToast(`Bespoke commission ${id} approved and routed to the pouring bench!`);
}

// --- Modal & Toast Utilities ---
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

    setTimeout(() => {
        toast.classList.add('opacity-0', 'pointer-events-none');
    }, 3200);
}
