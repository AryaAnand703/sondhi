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
    orders: [
        {
            id: 'SND-9014',
            date: 'September 12, 2026',
            status: 'Pouring & Curing',
            statusCode: 'pouring',
            statusDesc: 'Botanical soy wax setting in ceramic vessels under ambient temperature control',
            itemsCount: 3,
            total: 2647,
            estimatedDelivery: 'Sep 21, 2026',
            candles: [
                'Lavender & Golden Amber (280g) × 2',
                'Rain on Earth Mitti Attar (260g) × 1'
            ]
        },
        {
            id: 'SND-8890',
            date: 'August 15, 2026',
            status: 'Delivered',
            statusCode: 'delivered',
            statusDesc: 'Delivered via White-Glove Courier to Mumbai Sanctuary',
            itemsCount: 1,
            total: 2499,
            estimatedDelivery: 'Delivered Aug 18, 2026',
            candles: [
                'Flame Circle Q3 Reserve Box (Monsoon Vetiver)'
            ]
        },
        {
            id: 'SND-8412',
            date: 'June 10, 2026',
            status: 'Delivered',
            statusCode: 'delivered',
            statusDesc: 'Delivered with bespoke wax sealing',
            itemsCount: 2,
            total: 2248,
            estimatedDelivery: 'Delivered Jun 14, 2026',
            candles: [
                'Sandalwood & Velvet Oud (300g) × 1',
                'Neroli Blossom & Petitgrain (260g) × 1'
            ]
        }
    ],
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

// --- DOM Loaded Initialization ---
document.addEventListener('DOMContentLoaded', () => {
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

// --- Render Orders ---
function renderOrders() {
    const container = document.getElementById('orders-list-container');
    if (!container) return;

    container.innerHTML = profileState.orders.map(order => {
        const isPouring = order.statusCode === 'pouring';
        const badgeColor = isPouring 
            ? 'bg-flame-soft text-flame-glow border-flame-glow/30' 
            : 'bg-luxe-sage/20 text-luxe-sage border-luxe-sage/30';

        return `
            <div class="rounded-xl border border-white/10 bg-atelier-surface/80 p-5 hover:border-white/20 transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/10 pb-3 mb-3">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-sm font-bold text-luxe-gold">${order.id}</span>
                        <span class="text-xs text-atelier-muted">${order.date}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border ${badgeColor}">
                            ${isPouring ? '<i class="fa-solid fa-fire text-[9px] animate-pulse"></i>' : '<i class="fa-solid fa-check text-[9px]"></i>'}
                            ${order.status}
                        </span>
                        <span class="text-sm font-semibold text-atelier-cream">₹${order.total.toLocaleString()}</span>
                    </div>
                </div>

                <div class="text-xs text-atelier-muted space-y-1 mb-4">
                    ${order.candles.map(c => `<div class="flex items-center gap-2"><i class="fa-regular fa-circle-dot text-[8px] text-luxe-gold"></i><span>${c}</span></div>`).join('')}
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs pt-3 border-t border-white/5">
                    <div class="text-atelier-dim flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-xs"></i>
                        <span>${order.statusDesc} · <strong class="text-atelier-muted">${order.estimatedDelivery}</strong></span>
                    </div>
                    <button onclick="reorderBatch('${order.id}')" class="px-3 py-1.5 rounded-lg border border-luxe-gold/30 text-luxe-gold hover:bg-luxe-gold hover:text-atelier-base font-semibold uppercase tracking-wider text-[10px] transition self-start sm:self-auto">
                        Commission Reorder
                    </button>
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

    profileState.user.firstName = first;
    profileState.user.lastName = last;
    profileState.user.email = email;

    updateIdentityHeader();
    showToast('Patron profile credentials updated.');
}

function updateIdentityHeader() {
    const fullName = `${profileState.user.firstName} ${profileState.user.lastName}`;
    const initials = `${profileState.user.firstName[0] || ''}${profileState.user.lastName[0] || ''}`;

    const heroName = document.getElementById('hero-user-name');
    const headerName = document.getElementById('header-user-name');
    const heroEmail = document.getElementById('hero-user-email');
    const initialsEl = document.getElementById('profile-avatar-initials');

    if (heroName) heroName.textContent = fullName;
    if (headerName) headerName.textContent = fullName;
    if (heroEmail) heroEmail.textContent = `${profileState.user.email} · Client since October 2024`;
    if (initialsEl) initialsEl.textContent = initials;
}

function manageMembershipModal() {
    showToast('Flame Circle membership is active until November 15, 2026.');
}

function reorderBatch(orderId) {
    showToast(`Order ${orderId} added to your commission bag.`);
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
