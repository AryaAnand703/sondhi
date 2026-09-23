// ==========================================================================
// SONDHI ATELIER — SUPER ADMIN GOVERNANCE & GLOBAL BILLING LOGIC
// ==========================================================================

const superAdminState = {
    users: [
        {
            id: 'USR-001',
            name: 'Arya Anand',
            email: 'arya@example.com',
            role: 'Super Admin',
            permissions: 'Tier 0 · Full Platform Root Access',
            status: 'Active',
            lastActive: 'Just now'
        },
        {
            id: 'USR-002',
            name: 'Meera Rajput',
            email: 'meera@sondhi.co',
            role: 'Admin',
            permissions: 'Tier 1 · Atelier Artisan & Order Manager',
            status: 'Active',
            lastActive: '18 mins ago'
        },
        {
            id: 'USR-003',
            name: 'Rohan Deshmukh',
            email: 'rohan@deshmukh.in',
            role: 'Customer',
            permissions: 'Tier 3 · Patron & Collector',
            status: 'Active',
            lastActive: '2 hours ago'
        },
        {
            id: 'USR-004',
            name: 'Kavita Iyer',
            email: 'kavita@sondhi.co',
            role: 'Admin',
            permissions: 'Tier 1 · Master Pourer & Inventory Lead',
            status: 'Active',
            lastActive: '5 hours ago'
        },
        {
            id: 'USR-005',
            name: 'Vikramaditya Rao',
            email: 'vikram@rao-holdings.com',
            role: 'Customer',
            permissions: 'Tier 3 · Patron & Collector',
            status: 'Active',
            lastActive: '1 day ago'
        },
        {
            id: 'USR-006',
            name: 'Spam Account Simulation',
            email: 'bot98@tempmail.xyz',
            role: 'Customer',
            permissions: 'Tier 3 · Restricted Patron',
            status: 'Suspended',
            lastActive: '3 days ago'
        }
    ],
    auditLogs: [
        {
            time: '2026-09-19 00:04:12',
            actor: 'Arya Anand (Super Admin)',
            event: 'ROLE_MODIFICATION',
            delta: 'Granted [Admin] privileges to Kavita Iyer',
            ip: '127.0.0.1 (Localhost)',
            severity: 'warning'
        },
        {
            time: '2026-09-18 22:45:01',
            actor: 'System Auto-Billing',
            event: 'PAYOUT_SCHEDULE_TRIGGER',
            delta: 'Settled ₹1,84,520 to HDFC Bank A/C ••9942',
            ip: 'Gateway Webhook',
            severity: 'info'
        },
        {
            time: '2026-09-18 20:12:44',
            actor: 'Meera Rajput (Admin)',
            event: 'CATALOG_PRICE_UPDATE',
            delta: 'Adjusted Sandalwood & Velvet Oud price to ₹1,299',
            ip: '49.36.112.44 (Mumbai)',
            severity: 'info'
        },
        {
            time: '2026-09-18 18:30:19',
            actor: 'Security Radar Shield',
            event: 'SUSPICIOUS_CARD_BURST',
            delta: 'Blocked 3 velocity attempts from IP 185.220.101.5',
            ip: '185.220.101.5 (Tor Exit)',
            severity: 'critical'
        },
        {
            time: '2026-09-18 15:10:00',
            actor: 'Arya Anand (Super Admin)',
            event: 'GATEWAY_SECRET_ROTATION',
            delta: 'Rotated live Stripe webhook signing secret',
            ip: '127.0.0.1 (Localhost)',
            severity: 'warning'
        }
    ],
    subscriptionTiers: [
        {
            id: 'TIER-FLAME',
            name: 'The Flame Circle',
            price: 2499,
            frequency: 'Quarterly',
            members: 171,
            features: [
                '1x Curated 280g seasonal reserve candle',
                'Complimentary bespoke gift wrapping',
                'Priority private pour allocations',
                'Free white-glove courier shipping'
            ]
        },
        {
            id: 'TIER-STUDIO',
            name: 'Artisan Bespoke Fellowship',
            price: 5999,
            frequency: 'Quarterly',
            members: 48,
            features: [
                'Quarterly 1-on-1 perfumer consultation',
                '2x 300g Bespoke custom hand-poured candles',
                'Hand-stamped brass personal monogramming',
                'Invitation to annual Mumbai Atelier Salon'
            ]
        },
        {
            id: 'TIER-ARCHIVE',
            name: 'Atelier Corporate & Hospitality',
            price: 18500,
            frequency: 'Annual',
            members: 14,
            features: [
                'Bulk luxury gift box customization',
                'Custom ceramic glazing with corporate seal',
                'Dedicated Concierge Account Manager',
                'GST tax credits with bulk invoicing'
            ]
        }
    ],
    switches: {
        storefront: true,
        studio: true,
        maintenance: false
    }
};

// --- Section Auth Check & Initialization ---
function initSuperAdminPage() {
    if (window.sondhiAuth) {
        const storedUsers = window.sondhiAuth.getAllUsers();
        if (storedUsers && storedUsers.length) {
            superAdminState.users = storedUsers.map(u => ({
                id: u.id,
                name: u.fullName,
                email: u.email,
                role: u.role === 'superadmin' ? 'Super Admin' : (u.role === 'admin' ? 'Admin' : 'Customer'),
                permissions: u.role === 'superadmin' ? 'Tier 0 · Full Platform Root Access' : (u.role === 'admin' ? 'Tier 1 · Atelier Artisan & Order Manager' : 'Tier 3 · Patron & Collector'),
                status: 'Active',
                lastActive: 'Active session'
            }));
        }
    }

    renderUsers();
    renderAuditLogs();
    renderSubscriptionTiers();

    const hash = window.location.hash.replace('#', '');
    if (['users', 'billing', 'audit', 'settings'].includes(hash)) {
        switchSuperAdminTab(hash);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.sondhiAuth) {
        if (!window.sondhiAuth.isSectionUnlocked('superadmin')) {
            window.sondhiAuth.openSectionPassModal('superadmin', () => {
                initSuperAdminPage();
            });
        } else {
            initSuperAdminPage();
        }

        window.addEventListener('sondhi_auth_change', () => {
            initSuperAdminPage();
        });
    } else {
        initSuperAdminPage();
    }
});

// --- Tab Switcher ---
function switchSuperAdminTab(tabId) {
    const tabs = ['users', 'billing', 'audit', 'settings'];
    tabs.forEach(t => {
        const btn = document.getElementById(`tab-super-${t}`);
        const sec = document.getElementById(`section-super-${t}`);
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

// --- User & Role Governance ---
function renderUsers(filterText = '') {
    const tbody = document.getElementById('super-users-table-body');
    if (!tbody) return;

    const filtered = superAdminState.users.filter(u => 
        u.name.toLowerCase().includes(filterText.toLowerCase()) || 
        u.email.toLowerCase().includes(filterText.toLowerCase()) ||
        u.role.toLowerCase().includes(filterText.toLowerCase())
    );

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-atelier-muted">No users found matching query.</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.map(user => {
        let roleBadge = 'bg-white/5 text-atelier-muted border-white/10';
        if (user.role === 'Super Admin') roleBadge = 'bg-red-500/15 text-red-400 border-red-500/30';
        else if (user.role === 'Admin') roleBadge = 'bg-flame-soft text-flame-glow border-flame-glow/30';
        else if (user.role === 'Customer') roleBadge = 'bg-luxe-gold/15 text-luxe-gold border-luxe-gold/30';

        const isActive = user.status === 'Active';

        return `
            <tr class="hover:bg-white/[0.02] transition">
                <td class="py-3.5">
                    <div class="font-semibold text-atelier-cream">${user.name}</div>
                    <div class="text-[11px] text-atelier-muted">${user.email} · <span class="font-mono text-atelier-dim text-[10px]">${user.id}</span></div>
                </td>
                <td class="py-3.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border ${roleBadge}">
                        ${user.role === 'Super Admin' ? '<i class="fa-solid fa-crown text-[8px]"></i>' : (user.role === 'Admin' ? '<i class="fa-solid fa-shield-halved text-[8px]"></i>' : '<i class="fa-solid fa-user text-[8px]"></i>')}
                        ${user.role}
                    </span>
                </td>
                <td class="py-3.5 text-atelier-muted text-[11px]">${user.permissions}</td>
                <td class="py-3.5">
                    <span class="inline-flex items-center gap-1 text-[11px] ${isActive ? 'text-luxe-sage' : 'text-red-400'}">
                        <span class="w-1.5 h-1.5 rounded-full ${isActive ? 'bg-luxe-sage' : 'bg-red-400'}"></span>
                        ${user.status}
                    </span>
                </td>
                <td class="py-3.5 text-atelier-dim text-[11px]">${user.lastActive}</td>
                <td class="py-3.5 text-right space-x-2">
                    <select onchange="changeUserRole('${user.id}', this.value)" class="bg-atelier-surface border border-white/10 rounded px-2 py-1 text-[11px] text-atelier-cream outline-none focus:border-luxe-gold">
                        <option value="Customer" ${user.role === 'Customer' ? 'selected' : ''}>Customer</option>
                        <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Atelier Admin</option>
                        <option value="Super Admin" ${user.role === 'Super Admin' ? 'selected' : ''}>Super Admin</option>
                    </select>
                    <button onclick="toggleUserStatus('${user.id}')" class="p-1 text-xs ${isActive ? 'text-atelier-dim hover:text-red-400' : 'text-luxe-sage'}" title="${isActive ? 'Suspend User' : 'Reactivate User'}">
                        <i class="fa-solid ${isActive ? 'fa-ban' : 'fa-rotate-right'}"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

function filterUsers() {
    const val = document.getElementById('user-search-input').value;
    renderUsers(val);
}

function changeUserRole(userId, newRole) {
    const user = superAdminState.users.find(u => u.id === userId);
    if (!user) return;

    const oldRole = user.role;
    user.role = newRole;
    if (newRole === 'Super Admin') user.permissions = 'Tier 0 · Full Platform Root Access';
    else if (newRole === 'Admin') user.permissions = 'Tier 1 · Atelier Artisan & Order Manager';
    else user.permissions = 'Tier 3 · Patron & Collector';

    // Log to audit trail
    superAdminState.auditLogs.unshift({
        time: new Date().toISOString().replace('T', ' ').slice(0, 19),
        actor: 'Arya Anand (Super Admin)',
        event: 'ROLE_MODIFICATION',
        delta: `Changed ${user.name} role from [${oldRole}] to [${newRole}]`,
        ip: '127.0.0.1 (Localhost)',
        severity: 'warning'
    });

    renderUsers();
    renderAuditLogs();
    showToast(`Access clearance for ${user.name} modified to '${newRole}'.`);
}

function toggleUserStatus(userId) {
    const user = superAdminState.users.find(u => u.id === userId);
    if (!user) return;

    user.status = (user.status === 'Active' ? 'Suspended' : 'Active');
    renderUsers();
    showToast(`User ${user.name} account ${user.status.toLowerCase()}.`);
}

function openNewUserModal() {
    openModal('modal-new-user');
}

function submitNewUser() {
    const name = document.getElementById('user-name-input').value;
    const email = document.getElementById('user-email-input').value;
    const role = document.getElementById('user-role-select').value;

    const newUser = {
        id: 'USR-00' + (superAdminState.users.length + 1),
        name: name,
        email: email,
        role: role,
        permissions: role === 'Super Admin' ? 'Tier 0 · Full Platform Root Access' : (role === 'Admin' ? 'Tier 1 · Atelier Artisan' : 'Tier 3 · Patron'),
        status: 'Active',
        lastActive: 'Just registered'
    };

    superAdminState.users.push(newUser);
    closeModal('modal-new-user');
    document.getElementById('new-user-form').reset();
    renderUsers();
    showToast(`Access privileges granted to ${name} as ${role}.`);
}

// --- Subscription Tiers Architecture ---
function renderSubscriptionTiers() {
    const container = document.getElementById('subscription-tiers-grid');
    if (!container) return;

    container.innerHTML = superAdminState.subscriptionTiers.map(tier => `
        <div class="glass-card rounded-2xl p-6 border border-white/10 flex flex-col justify-between hover:border-luxe-gold/40 transition">
            <div>
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-xl font-bold text-atelier-cream">${tier.name}</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-luxe-gold/20 text-luxe-gold border border-luxe-gold/30">
                        ${tier.members} Active Patrons
                    </span>
                </div>

                <div class="mt-4 flex items-baseline gap-1">
                    <span class="text-2xl font-display font-bold text-luxe-gold">₹${tier.price.toLocaleString()}</span>
                    <span class="text-xs text-atelier-dim">/ ${tier.frequency.toLowerCase()}</span>
                </div>

                <div class="mt-4 pt-4 border-t border-white/5 space-y-2 text-xs text-atelier-muted">
                    ${tier.features.map(f => `
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-luxe-sage text-[10px] mt-1"></i>
                            <span>${f}</span>
                        </div>
                    `).join('')}
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                <button onclick="editTierPricing('${tier.id}')" class="w-full py-2 rounded-lg bg-atelier-card hover:bg-white/10 border border-white/10 text-xs text-atelier-cream font-semibold uppercase tracking-wider transition">
                    Modify Pricing Model
                </button>
            </div>
        </div>
    `).join('');
}

function editTierPricing(tierId) {
    const tier = superAdminState.subscriptionTiers.find(t => t.id === tierId);
    if (!tier) return;
    const newPrice = prompt(`Update rate for ${tier.name} (Current: ₹${tier.price}):`, tier.price);
    if (newPrice && !isNaN(newPrice)) {
        tier.price = parseInt(newPrice, 10);
        renderSubscriptionTiers();
        showToast(`Subscription rate for ${tier.name} adjusted to ₹${tier.price}.`);
    }
}

function openSubscriptionPlanModal() {
    openModal('modal-plan');
}

function openGatewayModal() {
    openModal('modal-gateway');
}

function exportGstReport() {
    showToast('Compiling platform GSTR-1 quarterly report file (JSON/Excel)...');
}

// --- Platform Audit & Security Logs ---
function renderAuditLogs() {
    const tbody = document.getElementById('super-audit-table-body');
    if (!tbody) return;

    tbody.innerHTML = superAdminState.auditLogs.map(log => {
        let badgeColor = 'bg-blue-500/15 text-blue-400 border-blue-500/30';
        if (log.severity === 'warning') badgeColor = 'bg-amber-500/15 text-amber-400 border-amber-500/30';
        else if (log.severity === 'critical') badgeColor = 'bg-red-500/15 text-red-400 border-red-500/30';

        return `
            <tr class="hover:bg-white/[0.02] transition">
                <td class="py-3 text-atelier-dim text-[11px] whitespace-nowrap">${log.time}</td>
                <td class="py-3 font-semibold text-atelier-cream">${log.actor}</td>
                <td class="py-3 text-luxe-gold text-[11px]">${log.event}</td>
                <td class="py-3 text-atelier-muted max-w-sm truncate text-[11px]">${log.delta}</td>
                <td class="py-3 text-atelier-dim text-[10px]">${log.ip}</td>
                <td class="py-3 text-right">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] uppercase tracking-wider border ${badgeColor}">
                        ${log.severity}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

function clearAuditFilter() {
    renderAuditLogs();
    showToast('Audit stream synchronized to head.');
}

// --- Platform Master Controls ---
function togglePlatformSwitch(key) {
    superAdminState.switches[key] = !superAdminState.switches[key];
    const val = superAdminState.switches[key];

    const btn = document.getElementById(`switch-${key}`);
    if (btn) {
        if (key === 'storefront') {
            btn.className = val 
                ? "px-4 py-1.5 rounded-full bg-luxe-sage/20 text-luxe-sage border border-luxe-sage/40 font-bold uppercase text-[10px]"
                : "px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/40 font-bold uppercase text-[10px]";
            btn.textContent = val ? "Live / Open" : "Closed / Private";
        } else if (key === 'studio') {
            btn.className = val 
                ? "px-4 py-1.5 rounded-full bg-luxe-sage/20 text-luxe-sage border border-luxe-sage/40 font-bold uppercase text-[10px]"
                : "px-4 py-1.5 rounded-full bg-white/10 text-atelier-muted border border-white/20 font-bold uppercase text-[10px]";
            btn.textContent = val ? "Active" : "Paused";
        } else if (key === 'maintenance') {
            btn.className = val 
                ? "px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/40 font-bold uppercase text-[10px]"
                : "px-4 py-1.5 rounded-full bg-white/10 text-atelier-muted border border-white/20 font-bold uppercase text-[10px]";
            btn.textContent = val ? "Locked (Super Admin Only)" : "Disabled";
        }
    }

    showToast(`Master platform switch '${key}' set to ${val ? 'ENABLED' : 'DISABLED'}.`);
}

// --- Modal & Toast Helpers ---
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
