// ==========================================================================
// SONDHI ATELIER — CENTRALIZED AUTHENTICATION & MULTI-USER SYSTEM
// ==========================================================================

(function (window) {
    'use strict';

    // Storage Keys
    const USERS_KEY = 'sondhi_users';
    const CURRENT_USER_KEY = 'sondhi_current_user';
    const ORDERS_KEY = 'sondhi_global_orders';

    // Section Passwords
    const SECTION_PASSWORDS = {
        admin: 'atelier2026',
        superadmin: 'sovereign2026'
    };

    // Pre-seeded initial accounts
    const INITIAL_USERS = [
        {
            id: 'USR-001',
            username: 'arya',
            fullName: 'Arya Anand',
            email: 'arya@example.com',
            password: 'arya123',
            role: 'customer',
            tier: 'VIP Collector',
            points: 1450,
            phone: '+91 98765 43210',
            createdAt: '2024-10-15',
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
                }
            ]
        },
        {
            id: 'USR-002',
            username: 'meera',
            fullName: 'Meera Rajput',
            email: 'meera@sondhi.co',
            password: 'meera123',
            role: 'admin',
            tier: 'Master Artisan & Manager',
            points: 820,
            phone: '+91 91234 56789',
            createdAt: '2025-01-10',
            orders: [
                {
                    id: 'SND-9015',
                    date: 'September 18, 2026',
                    status: 'Pending',
                    statusCode: 'pending',
                    statusDesc: 'Awaiting artisan bench allocation',
                    itemsCount: 1,
                    total: 1299,
                    estimatedDelivery: 'Sep 25, 2026',
                    candles: [
                        'Sandalwood & Velvet Oud (300g) × 1'
                    ]
                }
            ],
            addresses: [
                {
                    id: 'addr-meera-1',
                    label: 'Atelier Workshop',
                    street: '14 Craft Guild Lane, Fort',
                    city: 'Mumbai',
                    pincode: '400001',
                    isDefault: true
                }
            ],
            formulas: []
        },
        {
            id: 'USR-003',
            username: 'superadmin',
            fullName: 'System Governor',
            email: 'governor@sondhi.co',
            password: 'admin123',
            role: 'superadmin',
            tier: 'Super Admin',
            points: 5000,
            phone: '+91 99999 00000',
            createdAt: '2024-01-01',
            orders: [],
            addresses: [
                {
                    id: 'addr-super-1',
                    label: 'Headquarters Sanctuary',
                    street: '1 Heritage Boulevard, Colaba',
                    city: 'Mumbai',
                    pincode: '400005',
                    isDefault: true
                }
            ],
            formulas: []
        }
    ];

    const Auth = {
        // --- Initialization ---
        init: function () {
            // Initialize users in localStorage if not present
            if (!localStorage.getItem(USERS_KEY)) {
                localStorage.setItem(USERS_KEY, JSON.stringify(INITIAL_USERS));
            } else {
                // Ensure initial seed users exist if storage was partially initialized
                const existing = this.getAllUsers();
                let modified = false;
                INITIAL_USERS.forEach(seed => {
                    if (!existing.some(u => u.username.toLowerCase() === seed.username.toLowerCase())) {
                        existing.push(seed);
                        modified = true;
                    }
                });
                if (modified) {
                    localStorage.setItem(USERS_KEY, JSON.stringify(existing));
                }
            }

            // Sync global orders
            this.syncGlobalOrders();

            // Setup Auth Modal in DOM
            this.ensureAuthModalInDOM();

            // Update Navigation UI
            this.updateNavUI();
        },

        // --- Data Access ---
        getAllUsers: function () {
            try {
                return JSON.parse(localStorage.getItem(USERS_KEY)) || [];
            } catch (e) {
                console.error('Failed to parse users:', e);
                return [];
            }
        },

        saveAllUsers: function (users) {
            localStorage.setItem(USERS_KEY, JSON.stringify(users));
        },

        getCurrentUser: function () {
            try {
                const user = JSON.parse(localStorage.getItem(CURRENT_USER_KEY));
                if (!user) return null;

                // Sync current user with latest in all users
                const all = this.getAllUsers();
                const matched = all.find(u => u.id === user.id || u.username.toLowerCase() === user.username.toLowerCase());
                return matched || user;
            } catch (e) {
                return null;
            }
        },

        setCurrentUser: function (user) {
            if (user) {
                // Don't store password in session
                const sessionUser = { ...user };
                delete sessionUser.password;
                localStorage.setItem(CURRENT_USER_KEY, JSON.stringify(sessionUser));
            } else {
                localStorage.removeItem(CURRENT_USER_KEY);
            }
            this.updateNavUI();
            if (typeof window !== 'undefined' && typeof window.dispatchEvent === 'function') {
                window.dispatchEvent(new CustomEvent('sondhi_auth_change', { detail: { user } }));
            }
        },

        isAuthenticated: function () {
            return this.getCurrentUser() !== null;
        },

        hasRole: function (role) {
            const user = this.getCurrentUser();
            if (!user) return false;
            if (user.role === 'superadmin') return true; // Superadmin has all roles
            if (role === 'admin' && (user.role === 'admin' || user.role === 'superadmin')) return true;
            return user.role === role;
        },

        // --- Auth Actions ---
        login: function (usernameOrEmail, password) {
            const trimmedIdent = (usernameOrEmail || '').trim().toLowerCase();
            const trimmedPass = (password || '').trim();

            if (!trimmedIdent || !trimmedPass) {
                return { success: false, message: 'Please enter both username/email and password.' };
            }

            const users = this.getAllUsers();
            const user = users.find(u =>
                u.username.toLowerCase() === trimmedIdent ||
                (u.email && u.email.toLowerCase() === trimmedIdent)
            );

            if (!user) {
                return { success: false, message: 'No account found with this username or email.' };
            }

            if (user.password !== trimmedPass) {
                return { success: false, message: 'Incorrect password. Please try again.' };
            }

            this.setCurrentUser(user);
            return { success: true, user: user, message: `Welcome back, ${user.fullName}!` };
        },

        register: function ({ fullName, username, email, password, role = 'customer' }) {
            const cleanName = (fullName || '').trim();
            const cleanUser = (username || '').trim().toLowerCase();
            const cleanEmail = (email || '').trim().toLowerCase();
            const cleanPass = (password || '').trim();

            if (!cleanName || !cleanUser || !cleanEmail || !cleanPass) {
                return { success: false, message: 'Please complete all required fields.' };
            }

            if (cleanUser.length < 3) {
                return { success: false, message: 'Username must be at least 3 characters long.' };
            }

            if (!/^[a-zA-Z0-9_.-]+$/.test(cleanUser)) {
                return { success: false, message: 'Username can only contain letters, numbers, hyphens, and underscores.' };
            }

            if (!cleanEmail.includes('@') || !cleanEmail.includes('.')) {
                return { success: false, message: 'Please enter a valid email address.' };
            }

            if (cleanPass.length < 6) {
                return { success: false, message: 'Password must be at least 6 characters long.' };
            }

            const users = this.getAllUsers();

            // Check duplicates
            if (users.some(u => u.username.toLowerCase() === cleanUser)) {
                return { success: false, message: 'Username is already taken. Please choose another.' };
            }

            if (users.some(u => u.email.toLowerCase() === cleanEmail)) {
                return { success: false, message: 'An account with this email already exists.' };
            }

            // Create new user
            const newUser = {
                id: 'USR-' + String(Date.now()).slice(-5),
                username: cleanUser,
                fullName: cleanName,
                email: cleanEmail,
                password: cleanPass,
                role: role,
                tier: 'Patron',
                points: 100, // Welcome gift points
                phone: '',
                createdAt: new Date().toISOString().split('T')[0],
                orders: [],
                addresses: [],
                formulas: []
            };

            users.push(newUser);
            this.saveAllUsers(users);
            this.setCurrentUser(newUser);

            return { success: true, user: newUser, message: `Account created! Welcome to Sondhi Atelier, ${cleanName}.` };
        },

        logout: function () {
            const user = this.getCurrentUser();
            this.setCurrentUser(null);
            return { success: true, message: 'You have been logged out.' };
        },

        updateUser: function (updatedFields) {
            const current = this.getCurrentUser();
            if (!current) return { success: false, message: 'No active session.' };

            const users = this.getAllUsers();
            const idx = users.findIndex(u => u.id === current.id);
            if (idx === -1) return { success: false, message: 'User not found in records.' };

            users[idx] = { ...users[idx], ...updatedFields };
            this.saveAllUsers(users);
            this.setCurrentUser(users[idx]);

            return { success: true, user: users[idx] };
        },

        // --- Per-User Order Placement & History ---
        getUserOrders: function (userIdOrUsername) {
            const user = userIdOrUsername
                ? this.getAllUsers().find(u => u.id === userIdOrUsername || u.username.toLowerCase() === userIdOrUsername.toLowerCase())
                : this.getCurrentUser();

            return (user && user.orders) ? user.orders : [];
        },

        addUserOrder: function (orderData) {
            const current = this.getCurrentUser();
            if (!current) {
                return { success: false, message: 'Please log in to place an order.' };
            }

            const users = this.getAllUsers();
            const userIndex = users.findIndex(u => u.id === current.id);
            if (userIndex === -1) {
                return { success: false, message: 'User record not found.' };
            }

            const newOrder = {
                id: orderData.id || 'SND-' + Math.floor(1000 + Math.random() * 9000),
                date: orderData.date || new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }),
                status: orderData.status || 'Pouring & Curing',
                statusCode: orderData.statusCode || 'pouring',
                statusDesc: orderData.statusDesc || 'Artisan bench allocated; botanicals hand-infused into soy wax',
                itemsCount: orderData.itemsCount || (orderData.items ? orderData.items.reduce((s, i) => s + (i.quantity || 1), 0) : 1),
                total: orderData.total || 0,
                estimatedDelivery: orderData.estimatedDelivery || this.calculateEstimatedDelivery(7),
                candles: orderData.candles || (orderData.items ? orderData.items.map(i => `${i.name} × ${i.quantity || 1}`) : ['Signature Candle']),
                customerName: current.fullName,
                customerUsername: current.username,
                customerEmail: current.email
            };

            // Prepend to user's orders (most recent first)
            if (!users[userIndex].orders) users[userIndex].orders = [];
            users[userIndex].orders.unshift(newOrder);

            // Add bonus patron points (1 point per ₹10 spent)
            const earnedPoints = Math.floor(newOrder.total / 10);
            users[userIndex].points = (users[userIndex].points || 0) + earnedPoints;

            this.saveAllUsers(users);
            this.setCurrentUser(users[userIndex]);

            // Also add to global orders for admin
            this.addGlobalOrder(newOrder);

            if (typeof window !== 'undefined' && typeof window.dispatchEvent === 'function') {
                window.dispatchEvent(new CustomEvent('sondhi_order_placed', { detail: { order: newOrder } }));
            }
            return { success: true, order: newOrder };
        },

        calculateEstimatedDelivery: function (daysFromNow) {
            const d = new Date();
            d.setDate(d.getDate() + daysFromNow);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        // --- Global Orders (For Admin View) ---
        syncGlobalOrders: function () {
            let globalOrders = [];
            try {
                globalOrders = JSON.parse(localStorage.getItem(ORDERS_KEY)) || [];
            } catch (e) {
                globalOrders = [];
            }

            // Consolidate orders from all users into global orders if missing
            const users = this.getAllUsers();
            let added = false;
            users.forEach(u => {
                if (u.orders && Array.isArray(u.orders)) {
                    u.orders.forEach(o => {
                        if (!globalOrders.some(go => go.id === o.id)) {
                            globalOrders.push({
                                ...o,
                                customer: u.fullName,
                                customerUsername: u.username,
                                tier: u.tier || 'Patron'
                            });
                            added = true;
                        }
                    });
                }
            });

            if (added || !localStorage.getItem(ORDERS_KEY)) {
                localStorage.setItem(ORDERS_KEY, JSON.stringify(globalOrders));
            }
        },

        getAllOrders: function () {
            this.syncGlobalOrders();
            try {
                return JSON.parse(localStorage.getItem(ORDERS_KEY)) || [];
            } catch (e) {
                return [];
            }
        },

        addGlobalOrder: function (order) {
            const orders = this.getAllOrders();
            const current = this.getCurrentUser();
            const entry = {
                ...order,
                customer: current ? current.fullName : 'Guest Patron',
                customerUsername: current ? current.username : 'guest',
                tier: current ? current.tier : 'Patron'
            };
            orders.unshift(entry);
            localStorage.setItem(ORDERS_KEY, JSON.stringify(orders));
        },

        updateOrderStatus: function (orderId, newStatus, newStatusCode) {
            // Update in global orders
            const orders = this.getAllOrders();
            const gIdx = orders.findIndex(o => o.id === orderId);
            if (gIdx !== -1) {
                orders[gIdx].status = newStatus;
                if (newStatusCode) orders[gIdx].statusCode = newStatusCode;
                localStorage.setItem(ORDERS_KEY, JSON.stringify(orders));
            }

            // Update in user orders
            const users = this.getAllUsers();
            let updated = false;
            users.forEach(u => {
                if (u.orders) {
                    const uOrder = u.orders.find(o => o.id === orderId);
                    if (uOrder) {
                        uOrder.status = newStatus;
                        if (newStatusCode) uOrder.statusCode = newStatusCode;
                        updated = true;
                    }
                }
            });

            if (updated) {
                this.saveAllUsers(users);
                // If active user owns this order, sync active user
                const current = this.getCurrentUser();
                if (current && current.orders && current.orders.some(o => o.id === orderId)) {
                    this.setCurrentUser(users.find(u => u.id === current.id));
                }
            }
        },

        // --- Section Protection & Password Gate ---
        verifySectionAccess: function (section, enteredPassword) {
            const current = this.getCurrentUser();

            // If user has direct role access
            if (section === 'admin' && this.hasRole('admin')) return true;
            if (section === 'superadmin' && this.hasRole('superadmin')) return true;

            // Otherwise verify section password
            const requiredPass = SECTION_PASSWORDS[section];
            if (requiredPass && enteredPassword === requiredPass) {
                // Grant temporary section authorization in sessionStorage
                sessionStorage.setItem(`sondhi_section_auth_${section}`, 'true');
                return true;
            }

            return false;
        },

        isSectionUnlocked: function (section) {
            if (section === 'admin' && this.hasRole('admin')) return true;
            if (section === 'superadmin' && this.hasRole('superadmin')) return true;
            return sessionStorage.getItem(`sondhi_section_auth_${section}`) === 'true';
        },

        // --- UI & Modal Components ---
        ensureAuthModalInDOM: function () {
            if (document.getElementById('sondhi-auth-modal')) return;

            const modalHtml = `
            <div id="sondhi-auth-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-2xl bg-atelier-surface border border-luxe-gold/30 p-6 sm:p-8 shadow-2xl scale-95 transition-transform duration-300 text-atelier-cream">
                    <!-- Close button -->
                    <button id="auth-modal-close-btn" class="absolute top-5 right-5 text-atelier-muted hover:text-white transition p-1" aria-label="Close modal">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full border border-luxe-gold/40 bg-flame-soft text-luxe-gold mb-3">
                            <i class="fa-solid fa-fire-flame-curved text-xl"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold tracking-wider text-atelier-cream" id="auth-modal-title">Atelier Sanctuary Access</h3>
                        <p class="text-xs text-atelier-muted mt-1" id="auth-modal-subtitle">Sign in with your patron credentials or create a new account.</p>
                    </div>

                    <!-- Context Banner (e.g. for Checkout / Section Lock) -->
                    <div id="auth-modal-context-banner" class="hidden mb-4 rounded-xl border border-luxe-gold/40 bg-luxe-gold/10 p-3 text-xs text-luxe-gold flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-info text-sm flex-shrink-0"></i>
                        <span id="auth-modal-context-msg">Please log in to continue.</span>
                    </div>

                    <!-- Tabs: Sign In / Create Account -->
                    <div class="flex border-b border-white/10 mb-6 gap-2">
                        <button id="auth-tab-signin" class="flex-1 pb-3 text-xs font-bold uppercase tracking-wider border-b-2 border-luxe-gold text-luxe-gold transition">
                            Sign In
                        </button>
                        <button id="auth-tab-signup" class="flex-1 pb-3 text-xs font-bold uppercase tracking-wider border-b-2 border-transparent text-atelier-muted hover:text-atelier-cream transition">
                            Create Account
                        </button>
                    </div>

                    <!-- Error Alert -->
                    <div id="auth-modal-error" class="hidden mb-4 rounded-xl border border-red-500/40 bg-red-500/10 p-3 text-xs text-red-300 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation flex-shrink-0"></i>
                        <span id="auth-modal-error-msg"></span>
                    </div>

                    <!-- SIGN IN FORM -->
                    <form id="auth-signin-form" class="space-y-4 text-xs" onsubmit="event.preventDefault(); window.sondhiAuth.handleSignInSubmit();">
                        <div>
                            <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1.5" for="signin-ident">Username or Email</label>
                            <div class="relative">
                                <i class="fa-regular fa-user absolute left-3.5 top-3 text-atelier-dim"></i>
                                <input type="text" id="signin-ident" required placeholder="e.g. arya or your@email.com" class="w-full bg-atelier-card border border-white/15 rounded-xl pl-10 pr-4 py-2.5 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block uppercase font-semibold tracking-wider text-atelier-muted" for="signin-pass">Password</label>
                                <button type="button" onclick="window.sondhiAuth.togglePasswordVisibility('signin-pass', this)" class="text-[10px] uppercase text-luxe-gold hover:underline">
                                    Show
                                </button>
                            </div>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-3.5 top-3 text-atelier-dim"></i>
                                <input type="password" id="signin-pass" required placeholder="••••••••" class="w-full bg-atelier-card border border-white/15 rounded-xl pl-10 pr-4 py-2.5 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                            </div>
                        </div>

                        <button type="submit" id="signin-submit-btn" class="w-full mt-2 rounded-xl bg-gradient-to-r from-luxe-gold via-amber-300 to-luxe-gold py-3 text-xs font-bold uppercase tracking-widest text-atelier-base hover:opacity-95 hover:shadow-lg hover:shadow-luxe-gold/20 transition duration-300">
                            Enter Atelier Sanctuary
                        </button>
                    </form>

                    <!-- CREATE ACCOUNT FORM -->
                    <form id="auth-signup-form" class="hidden space-y-3.5 text-xs" onsubmit="event.preventDefault(); window.sondhiAuth.handleSignUpSubmit();">
                        <div>
                            <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="signup-name">Full Name</label>
                            <input type="text" id="signup-name" required placeholder="e.g. Aarav Sharma" class="w-full bg-atelier-card border border-white/15 rounded-xl px-3.5 py-2 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="signup-user">Username</label>
                                <input type="text" id="signup-user" required placeholder="e.g. aarav" class="w-full bg-atelier-card border border-white/15 rounded-xl px-3.5 py-2 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                            </div>
                            <div>
                                <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="signup-email">Email</label>
                                <input type="email" id="signup-email" required placeholder="aarav@sanctuary.in" class="w-full bg-atelier-card border border-white/15 rounded-xl px-3.5 py-2 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block uppercase font-semibold tracking-wider text-atelier-muted" for="signup-pass">Create Password</label>
                                <button type="button" onclick="window.sondhiAuth.togglePasswordVisibility('signup-pass', this)" class="text-[10px] uppercase text-luxe-gold hover:underline">
                                    Show
                                </button>
                            </div>
                            <input type="password" id="signup-pass" required minlength="6" placeholder="At least 6 characters" class="w-full bg-atelier-card border border-white/15 rounded-xl px-3.5 py-2 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                        </div>

                        <div>
                            <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="signup-confirm-pass">Confirm Password</label>
                            <input type="password" id="signup-confirm-pass" required minlength="6" placeholder="Re-enter password" class="w-full bg-atelier-card border border-white/15 rounded-xl px-3.5 py-2 text-sm text-atelier-cream placeholder:text-atelier-dim focus:border-luxe-gold outline-none transition">
                        </div>

                        <button type="submit" id="signup-submit-btn" class="w-full mt-2 rounded-xl bg-gradient-to-r from-luxe-gold via-amber-300 to-luxe-gold py-3 text-xs font-bold uppercase tracking-widest text-atelier-base hover:opacity-95 hover:shadow-lg hover:shadow-luxe-gold/20 transition duration-300">
                            Create Patron Account
                        </button>
                    </form>

                    <!-- Quick Demo Accounts -->
                    <div class="mt-6 pt-4 border-t border-white/10 text-center">
                        <div class="text-[10px] uppercase tracking-widest text-atelier-dim font-bold mb-2.5">
                            Quick Demo Sign-In (1-Click Fill)
                        </div>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button type="button" onclick="window.sondhiAuth.fillDemoAccount('arya', 'arya123')" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 hover:border-luxe-gold text-atelier-cream hover:text-luxe-gold text-[10px] font-semibold transition">
                                <i class="fa-solid fa-user text-[9px] text-luxe-gold mr-1"></i> Patron: arya
                            </button>
                            <button type="button" onclick="window.sondhiAuth.fillDemoAccount('meera', 'meera123')" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 hover:border-flame-glow text-atelier-cream hover:text-flame-glow text-[10px] font-semibold transition">
                                <i class="fa-solid fa-shield-halved text-[9px] text-flame-glow mr-1"></i> Admin: meera
                            </button>
                            <button type="button" onclick="window.sondhiAuth.fillDemoAccount('superadmin', 'admin123')" class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 hover:border-red-400 text-atelier-cream hover:text-red-400 text-[10px] font-semibold transition">
                                <i class="fa-solid fa-crown text-[9px] text-red-400 mr-1"></i> Super Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION PASSWORD CHALLENGE MODAL -->
            <div id="sondhi-section-pass-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-2xl bg-atelier-surface border border-flame-glow/50 p-6 sm:p-8 shadow-2xl scale-95 transition-transform duration-300 text-atelier-cream">
                    <button id="section-modal-close-btn" class="absolute top-5 right-5 text-atelier-muted hover:text-white transition p-1" aria-label="Close modal">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>

                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full border border-flame-glow/40 bg-flame-soft text-flame-glow mb-3">
                            <i class="fa-solid fa-lock text-2xl animate-pulse"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold tracking-wider text-atelier-cream" id="section-pass-title">Restricted Atelier Portal</h3>
                        <p class="text-xs text-atelier-muted mt-1" id="section-pass-subtitle">Enter the section authorization password or log in with an authorized account.</p>
                    </div>

                    <div id="section-modal-error" class="hidden mb-4 rounded-xl border border-red-500/40 bg-red-500/10 p-3 text-xs text-red-300 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
                        <span id="section-modal-error-msg">Incorrect section password.</span>
                    </div>

                    <form id="section-pass-form" class="space-y-4 text-xs" onsubmit="event.preventDefault(); window.sondhiAuth.handleSectionPassSubmit();">
                        <div>
                            <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1.5" for="section-pass-input">Section Password</label>
                            <input type="password" id="section-pass-input" required placeholder="Enter section password" class="w-full bg-atelier-card border border-white/15 rounded-xl px-4 py-2.5 text-sm text-atelier-cream focus:border-flame-glow outline-none font-mono">
                            <div class="text-[10px] text-atelier-dim mt-1.5 flex items-center justify-between">
                                <span id="section-pass-hint">Hint: atelier2026</span>
                                <button type="button" onclick="window.sondhiAuth.openAuthModal('signin')" class="text-luxe-gold hover:underline">Log in with account instead</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-flame-soft border border-flame-glow/50 py-3 text-xs font-bold uppercase tracking-widest text-flame-glow hover:bg-flame-glow hover:text-atelier-base transition duration-200">
                            Authorize & Unlock Section
                        </button>
                    </form>
                </div>
            </div>

            <!-- ORDER CONFIRMATION MODAL -->
            <div id="sondhi-order-success-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg rounded-2xl bg-atelier-surface border border-luxe-gold/40 p-6 sm:p-8 shadow-2xl scale-95 transition-transform duration-300 text-atelier-cream text-center">
                    <button onclick="window.sondhiAuth.closeOrderSuccessModal()" class="absolute top-5 right-5 text-atelier-muted hover:text-white transition p-1" aria-label="Close modal">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>

                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full border border-luxe-gold/40 bg-flame-soft text-luxe-gold mb-4 shadow-lg shadow-luxe-gold/10">
                        <i class="fa-solid fa-wand-magic-sparkles text-2xl"></i>
                    </div>

                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] bg-luxe-gold/15 text-luxe-gold border border-luxe-gold/30 mb-2">
                        Commission Confirmed
                    </span>

                    <h3 class="font-display text-2xl font-bold tracking-wider text-atelier-cream">Your Artisan Candles Are Being Poured</h3>
                    <p class="text-xs text-atelier-muted max-w-sm mx-auto mt-2">
                        Thank you for commissioning Sondhi Botanicals. Your bespoke candles have been scheduled for hand-pouring and ambient wax curing.
                    </p>

                    <!-- Order Summary Card -->
                    <div class="my-6 rounded-xl border border-white/10 bg-atelier-card p-4 text-left text-xs space-y-2">
                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                            <span class="text-atelier-muted uppercase tracking-wider text-[10px]">Commission ID</span>
                            <span class="font-mono font-bold text-luxe-gold" id="order-success-id">SND-9020</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                            <span class="text-atelier-muted uppercase tracking-wider text-[10px]">Patron</span>
                            <span class="font-semibold text-atelier-cream" id="order-success-patron">Arya Anand</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                            <span class="text-atelier-muted uppercase tracking-wider text-[10px]">Total Amount</span>
                            <span class="font-bold text-atelier-cream" id="order-success-total">₹2,647</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-atelier-muted uppercase tracking-wider text-[10px]">Estimated Delivery</span>
                            <span class="text-atelier-muted" id="order-success-delivery">7-9 Business Days</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="profile.html#orders" class="flex-1 rounded-xl bg-luxe-gold py-3 text-xs font-bold uppercase tracking-widest text-atelier-base hover:bg-white transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-box-archive text-xs"></i> View in Order History
                        </a>
                        <button onclick="window.sondhiAuth.closeOrderSuccessModal()" class="flex-1 rounded-xl bg-atelier-hover border border-white/10 py-3 text-xs font-bold uppercase tracking-widest text-atelier-cream hover:border-luxe-gold/40 transition">
                            Continue Browsing
                        </button>
                    </div>
                </div>
            </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Bind events for tabs
            const tabSignIn = document.getElementById('auth-tab-signin');
            const tabSignUp = document.getElementById('auth-tab-signup');
            const closeAuthBtn = document.getElementById('auth-modal-close-btn');
            const closeSecBtn = document.getElementById('section-modal-close-btn');

            if (tabSignIn) tabSignIn.addEventListener('click', () => this.switchAuthTab('signin'));
            if (tabSignUp) tabSignUp.addEventListener('click', () => this.switchAuthTab('signup'));
            if (closeAuthBtn) closeAuthBtn.addEventListener('click', () => this.closeAuthModal());
            if (closeSecBtn) closeSecBtn.addEventListener('click', () => this.closeSectionPassModal());
        },

        switchAuthTab: function (tab) {
            const signinTab = document.getElementById('auth-tab-signin');
            const signupTab = document.getElementById('auth-tab-signup');
            const signinForm = document.getElementById('auth-signin-form');
            const signupForm = document.getElementById('auth-signup-form');
            const errorDiv = document.getElementById('auth-modal-error');
            if (errorDiv) errorDiv.classList.add('hidden');

            if (tab === 'signin') {
                signinTab.classList.add('border-luxe-gold', 'text-luxe-gold');
                signinTab.classList.remove('border-transparent', 'text-atelier-muted');
                signupTab.classList.add('border-transparent', 'text-atelier-muted');
                signupTab.classList.remove('border-luxe-gold', 'text-luxe-gold');

                signinForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
                document.getElementById('auth-modal-title').textContent = 'Atelier Sanctuary Access';
                document.getElementById('auth-modal-subtitle').textContent = 'Sign in with your patron credentials.';
            } else {
                signupTab.classList.add('border-luxe-gold', 'text-luxe-gold');
                signupTab.classList.remove('border-transparent', 'text-atelier-muted');
                signinTab.classList.add('border-transparent', 'text-atelier-muted');
                signinTab.classList.remove('border-luxe-gold', 'text-luxe-gold');

                signupForm.classList.remove('hidden');
                signinForm.classList.add('hidden');
                document.getElementById('auth-modal-title').textContent = 'Create Patron Sanctuary';
                document.getElementById('auth-modal-subtitle').textContent = 'Register a new account to commission bespoke candles and track your orders.';
            }
        },

        openAuthModal: function (tab = 'signin', contextMsg = null, onAuthSuccess = null) {
            this.ensureAuthModalInDOM();
            this.switchAuthTab(tab);

            const banner = document.getElementById('auth-modal-context-banner');
            const bannerMsg = document.getElementById('auth-modal-context-msg');
            if (contextMsg) {
                bannerMsg.textContent = contextMsg;
                banner.classList.remove('hidden');
            } else {
                banner.classList.add('hidden');
            }

            this._onAuthSuccess = onAuthSuccess;

            const modal = document.getElementById('sondhi-auth-modal');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-95');
            if (inner) {
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }
        },

        closeAuthModal: function () {
            const modal = document.getElementById('sondhi-auth-modal');
            if (!modal) return;
            modal.classList.add('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-100');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
        },

        togglePasswordVisibility: function (inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Hide';
            } else {
                input.type = 'password';
                btn.textContent = 'Show';
            }
        },

        fillDemoAccount: function (username, password) {
            this.switchAuthTab('signin');
            const identInput = document.getElementById('signin-ident');
            const passInput = document.getElementById('signin-pass');
            if (identInput && passInput) {
                identInput.value = username;
                passInput.value = password;
                identInput.classList.add('border-luxe-gold');
                passInput.classList.add('border-luxe-gold');
            }
        },

        handleSignInSubmit: function () {
            const ident = document.getElementById('signin-ident').value;
            const pass = document.getElementById('signin-pass').value;
            const errorDiv = document.getElementById('auth-modal-error');
            const errorMsg = document.getElementById('auth-modal-error-msg');

            const res = this.login(ident, pass);
            if (!res.success) {
                errorMsg.textContent = res.message;
                errorDiv.classList.remove('hidden');
            } else {
                errorDiv.classList.add('hidden');
                this.closeAuthModal();
                this.showToast(res.message);

                if (typeof this._onAuthSuccess === 'function') {
                    this._onAuthSuccess(res.user);
                    this._onAuthSuccess = null;
                }
            }
        },

        handleSignUpSubmit: function () {
            const name = document.getElementById('signup-name').value;
            const user = document.getElementById('signup-user').value;
            const email = document.getElementById('signup-email').value;
            const pass = document.getElementById('signup-pass').value;
            const confirmPass = document.getElementById('signup-confirm-pass').value;
            const errorDiv = document.getElementById('auth-modal-error');
            const errorMsg = document.getElementById('auth-modal-error-msg');

            if (pass !== confirmPass) {
                errorMsg.textContent = 'Passwords do not match. Please verify.';
                errorDiv.classList.remove('hidden');
                return;
            }

            const res = this.register({ fullName: name, username: user, email: email, password: pass });
            if (!res.success) {
                errorMsg.textContent = res.message;
                errorDiv.classList.remove('hidden');
            } else {
                errorDiv.classList.add('hidden');
                this.closeAuthModal();
                this.showToast(res.message);

                if (typeof this._onAuthSuccess === 'function') {
                    this._onAuthSuccess(res.user);
                    this._onAuthSuccess = null;
                }
            }
        },

        // --- Section Password Modal Handlers ---
        openSectionPassModal: function (section, onUnlocked) {
            this.ensureAuthModalInDOM();
            this._pendingSection = section;
            this._onSectionUnlocked = onUnlocked;

            const modal = document.getElementById('sondhi-section-pass-modal');
            const title = document.getElementById('section-pass-title');
            const hint = document.getElementById('section-pass-hint');
            const errorDiv = document.getElementById('section-modal-error');

            if (errorDiv) errorDiv.classList.add('hidden');

            if (section === 'admin') {
                title.textContent = 'Atelier Admin Authorization';
                hint.textContent = 'Section Pass: atelier2026 (or login as meera)';
            } else if (section === 'superadmin') {
                title.textContent = 'Super Admin Governance Access';
                hint.textContent = 'Section Pass: sovereign2026 (or login as superadmin)';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-95');
            if (inner) {
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }
        },

        closeSectionPassModal: function () {
            const modal = document.getElementById('sondhi-section-pass-modal');
            if (!modal) return;
            modal.classList.add('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-100');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
        },

        handleSectionPassSubmit: function () {
            const input = document.getElementById('section-pass-input');
            const pass = input ? input.value : '';
            const errorDiv = document.getElementById('section-modal-error');
            const errorMsg = document.getElementById('section-modal-error-msg');

            const section = this._pendingSection || 'admin';
            const ok = this.verifySectionAccess(section, pass);

            if (ok) {
                errorDiv.classList.add('hidden');
                this.closeSectionPassModal();
                this.showToast(`Access granted to ${section.toUpperCase()} portal.`);
                if (typeof this._onSectionUnlocked === 'function') {
                    this._onSectionUnlocked();
                }
            } else {
                errorMsg.textContent = 'Incorrect section password. Access denied.';
                errorDiv.classList.remove('hidden');
            }
        },

        // --- Order Confirmation Modal ---
        showOrderSuccessModal: function (order) {
            this.ensureAuthModalInDOM();
            const idEl = document.getElementById('order-success-id');
            const patronEl = document.getElementById('order-success-patron');
            const totalEl = document.getElementById('order-success-total');
            const delEl = document.getElementById('order-success-delivery');

            if (idEl) idEl.textContent = order.id;
            if (patronEl) patronEl.textContent = order.customerName || 'Patron';
            if (totalEl) totalEl.textContent = `₹${(order.total || 0).toLocaleString()}`;
            if (delEl) delEl.textContent = order.estimatedDelivery || '7-9 Business Days';

            const modal = document.getElementById('sondhi-order-success-modal');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-95');
            if (inner) {
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }
        },

        closeOrderSuccessModal: function () {
            const modal = document.getElementById('sondhi-order-success-modal');
            if (!modal) return;
            modal.classList.add('opacity-0', 'pointer-events-none');
            const inner = modal.querySelector('.scale-100');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
        },

        // --- Update Navigation & Header UI Across Pages ---
        updateNavUI: function () {
            const user = this.getCurrentUser();

            // 1. Update Account Dropdown button in index.html if exists
            const accountBtn = document.getElementById('account-dropdown-btn');
            if (accountBtn) {
                if (user) {
                    accountBtn.innerHTML = `
                        <div class="w-5 h-5 rounded-full bg-luxe-gold/20 text-luxe-gold border border-luxe-gold/50 flex items-center justify-center text-[9px] font-bold">
                            ${(user.fullName[0] || 'U').toUpperCase()}
                        </div>
                        <span class="hidden md:inline text-atelier-cream font-medium">Hi, ${user.fullName.split(' ')[0]}</span>
                        <i class="fa-solid fa-chevron-down text-[8px] text-atelier-dim group-hover:text-luxe-gold transition"></i>
                    `;
                } else {
                    accountBtn.innerHTML = `
                        <i class="fa-regular fa-user text-xs text-luxe-gold"></i>
                        <span class="hidden md:inline">Sign In</span>
                        <i class="fa-solid fa-chevron-down text-[8px] text-atelier-dim group-hover:text-luxe-gold transition"></i>
                    `;
                }
            }

            // 2. Update dynamic user links in dropdown menu if exists
            const dropdownContent = document.getElementById('account-dropdown-content');
            if (dropdownContent) {
                if (user) {
                    dropdownContent.innerHTML = `
                        <div class="px-3 py-2 border-b border-white/10 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-xs text-atelier-cream">${user.fullName}</div>
                                <div class="text-[10px] text-luxe-gold font-medium tracking-wider uppercase">@${user.username} · ${user.tier || 'Patron'}</div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] bg-luxe-gold/15 text-luxe-gold font-mono">${user.points || 0} pts</span>
                        </div>
                        <a href="profile.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs text-atelier-cream hover:bg-luxe-gold/10 hover:text-luxe-gold transition">
                            <div class="w-7 h-7 rounded-lg bg-luxe-gold/10 flex items-center justify-center text-luxe-gold">
                                <i class="fa-solid fa-user text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Client Sanctuary Profile</div>
                                <div class="text-[10px] text-atelier-muted">Addresses, Formulas & Settings</div>
                            </div>
                        </a>
                        <a href="profile.html#orders" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs text-atelier-cream hover:bg-luxe-gold/10 hover:text-luxe-gold transition">
                            <div class="w-7 h-7 rounded-lg bg-luxe-gold/10 flex items-center justify-center text-luxe-gold">
                                <i class="fa-solid fa-box-archive text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">My Order History</div>
                                <div class="text-[10px] text-atelier-muted">Live Tracking & Invoices (${(user.orders || []).length})</div>
                            </div>
                        </a>
                        <div class="px-3 py-1.5 border-t border-b border-white/10 text-[9px] uppercase tracking-widest text-atelier-dim font-bold mt-1">
                            Atelier Portals
                        </div>
                        <a href="admin.html" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs text-atelier-cream hover:bg-flame-soft hover:text-flame-glow transition">
                            <div class="w-7 h-7 rounded-lg bg-flame-soft flex items-center justify-center text-flame-glow">
                                <i class="fa-solid fa-shield-halved text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Atelier Admin</div>
                                <div class="text-[10px] text-atelier-muted">Orders & Payouts (Pass Required)</div>
                            </div>
                        </a>
                        <a href="superadmin.html" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs text-atelier-cream hover:bg-red-500/10 hover:text-red-400 transition">
                            <div class="w-7 h-7 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400">
                                <i class="fa-solid fa-crown text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Super Admin</div>
                                <div class="text-[10px] text-atelier-muted">RBAC & Governance (Pass Required)</div>
                            </div>
                        </a>
                        <div class="mt-1 pt-1.5 border-t border-white/10 flex items-center justify-between px-2">
                            <button onclick="window.sondhiAuth.openAuthModal('signin', 'Switching to another patron account')" class="text-[11px] text-atelier-muted hover:text-luxe-gold transition py-1">
                                <i class="fa-solid fa-arrow-right-arrow-left text-[10px] mr-1"></i> Switch Account
                            </button>
                            <button onclick="window.sondhiAuth.logout(); window.sondhiAuth.showToast('Signed out of sanctuary');" class="text-[11px] text-red-400 hover:underline py-1">
                                Sign Out
                            </button>
                        </div>
                    `;
                } else {
                    dropdownContent.innerHTML = `
                        <div class="px-3 py-2 border-b border-white/10 text-center">
                            <div class="font-bold text-xs text-atelier-cream">Welcome to Sondhi Atelier</div>
                            <div class="text-[10px] text-atelier-muted mt-0.5">Handcrafted botanical candle sanctuary</div>
                        </div>
                        <div class="p-2 space-y-2">
                            <button onclick="window.sondhiAuth.openAuthModal('signin')" class="w-full py-2.5 rounded-xl bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-right-to-bracket text-xs"></i> Sign In to Account
                            </button>
                            <button onclick="window.sondhiAuth.openAuthModal('signup')" class="w-full py-2 rounded-xl bg-atelier-card border border-white/10 text-atelier-cream text-xs font-semibold uppercase tracking-wider hover:border-luxe-gold transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-user-plus text-xs"></i> Create New Account
                            </button>
                        </div>
                        <div class="px-3 py-1.5 border-t border-b border-white/10 text-[9px] uppercase tracking-widest text-atelier-dim font-bold">
                            Workspaces (Protected)
                        </div>
                        <a href="admin.html" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs text-atelier-cream hover:bg-flame-soft hover:text-flame-glow transition">
                            <div class="w-7 h-7 rounded-lg bg-flame-soft flex items-center justify-center text-flame-glow">
                                <i class="fa-solid fa-shield-halved text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Atelier Admin</div>
                                <div class="text-[10px] text-atelier-muted">Password: atelier2026</div>
                            </div>
                        </a>
                        <a href="superadmin.html" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs text-atelier-cream hover:bg-red-500/10 hover:text-red-400 transition">
                            <div class="w-7 h-7 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400">
                                <i class="fa-solid fa-crown text-[11px]"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Super Admin</div>
                                <div class="text-[10px] text-atelier-muted">Password: sovereign2026</div>
                            </div>
                        </a>
                    `;
                }
            }

            // 3. Update Portal Switcher bar if exists in admin / superadmin / profile
            const portalUserEl = document.getElementById('portal-user-badge');
            if (portalUserEl) {
                if (user) {
                    portalUserEl.innerHTML = `
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white/5 border border-white/10 text-atelier-cream">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Logged in: <strong class="text-luxe-gold">@${user.username}</strong> (${user.role})
                        </span>
                        <button onclick="window.sondhiAuth.logout(); window.location.reload();" class="text-[10px] text-atelier-muted hover:text-red-400 underline ml-1">
                            Sign Out
                        </button>
                    `;
                } else {
                    portalUserEl.innerHTML = `
                        <button onclick="window.sondhiAuth.openAuthModal('signin')" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-luxe-gold/20 text-luxe-gold border border-luxe-gold/40 hover:bg-luxe-gold hover:text-atelier-base transition">
                            <i class="fa-regular fa-user text-[9px]"></i> Sign In
                        </button>
                    `;
                }
            }
        },

        // --- Generic Toast Helper ---
        showToast: function (message, isError = false) {
            let toast = document.getElementById('toast');
            let msg = document.getElementById('toast-message');
            let icon = document.getElementById('toast-icon');

            if (!toast) {
                const toastHtml = `
                    <div id="toast" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 rounded-xl bg-atelier-surface border border-luxe-gold px-4 py-3 shadow-2xl text-xs text-atelier-cream opacity-0 pointer-events-none transition-all duration-300">
                        <i class="fa-solid fa-circle-check text-luxe-gold text-sm" id="toast-icon"></i>
                        <span id="toast-message"></span>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', toastHtml);
                toast = document.getElementById('toast');
                msg = document.getElementById('toast-message');
                icon = document.getElementById('toast-icon');
            }

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

            if (this._toastTimer) clearTimeout(this._toastTimer);
            this._toastTimer = setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
            }, 3500);
        }
    };

    // Auto initialize on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Auth.init());
    } else {
        Auth.init();
    }

    // Expose globally
    window.sondhiAuth = Auth;

})(window);
