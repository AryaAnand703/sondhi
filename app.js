const products = [
    { id: 1, name: 'Lavender & Amber', category: 'Floral', fragrance: 'Lavender, amber, cedar', price: 899, rating: 4.9, image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85' },
    { id: 2, name: 'Rose Petal', category: 'Floral', fragrance: 'Damask rose, musk', price: 849, rating: 4.8, image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85' },
    { id: 3, name: 'Vanilla Cloud', category: 'Warm', fragrance: 'Vanilla, tonka, sandalwood', price: 799, rating: 4.9, image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85' },
    { id: 4, name: 'Premium Oud', category: 'Woody', fragrance: 'Oud, saffron, dark wood', price: 1299, rating: 5, image: 'https://images.unsplash.com/photo-1608181831718-c9e7d8a2a3a5?auto=format&fit=crop&w=800&q=85' },
    { id: 5, name: 'Rain on Earth', category: 'Fresh', fragrance: 'Vetiver, green leaf, rain', price: 749, rating: 4.8, image: 'https://images.unsplash.com/photo-1602874801006-e26d6e8f0b15?auto=format&fit=crop&w=800&q=85' },
    { id: 6, name: 'Neroli Bloom', category: 'Floral', fragrance: 'Neroli, orange blossom', price: 949, rating: 4.7, image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85' },
    { id: 7, name: 'Cedar Smoke', category: 'Woody', fragrance: 'Cedar, cardamom, smoke', price: 1199, rating: 4.9, image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85' },
    { id: 8, name: 'Citrus Peel', category: 'Fresh', fragrance: 'Bitter orange, cedar, lime', price: 699, rating: 4.6, image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85' }
];

const state = { category: 'All', query: '', cart: JSON.parse(localStorage.getItem('sondhi-cart') || '[]') };
const productGrid = document.querySelector('#product-grid');
const categoryFilter = document.querySelector('#category-filter');
const catalogSearch = document.querySelector('#catalog-search');
const cartDrawer = document.querySelector('#cart-drawer');
const cartBackdrop = document.querySelector('#cart-backdrop');
const cartItems = document.querySelector('#cart-items');
const cartCount = document.querySelector('#cart-count');
const cartTotal = document.querySelector('#cart-total');
const money = (value) => `₹${value.toLocaleString('en-IN')}`;

function renderProducts() {
    const visible = products.filter((product) => {
        const matchesCategory = state.category === 'All' || product.category === state.category;
        return matchesCategory && `${product.name} ${product.fragrance}`.toLowerCase().includes(state.query.toLowerCase());
    });
    productGrid.innerHTML = visible.length ? visible.map((product) => `
        <article class="group"><div class="relative overflow-hidden bg-white"><img class="aspect-[4/5] w-full object-cover transition duration-700 group-hover:scale-105" src="${product.image}" alt="${product.name} candle"><span class="absolute left-3 top-3 bg-linen px-3 py-1 text-[10px] font-bold uppercase tracking-widest">${product.category}</span><div class="absolute bottom-4 right-4 flex gap-2"><button class="buy-now flex h-10 items-center gap-2 bg-ink px-4 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-ember" data-id="${product.id}">Buy now</button><button class="add-to-cart flex h-10 w-10 items-center justify-center bg-white text-ink shadow-lg transition hover:bg-ember hover:text-white" data-id="${product.id}" aria-label="Add ${product.name} to cart"><i class="fa-solid fa-plus"></i></button></div></div><div class="flex items-start justify-between gap-3 border-b border-ink/10 pb-5 pt-4"><div><p class="text-[10px] font-bold uppercase tracking-widest text-ember">${product.fragrance}</p><h3 class="mt-1 font-display text-2xl">${product.name}</h3><p class="mt-2 text-xs text-gold">${'★'.repeat(Math.floor(product.rating))} <span class="text-ink/45">${product.rating}</span></p></div><span class="pt-1 text-sm font-bold">${money(product.price)}</span></div></article>
    `).join('') : '<p class="col-span-full py-16 text-center text-sm text-ink/55">No candles match your search.</p>';
}

function persistCart() { localStorage.setItem('sondhi-cart', JSON.stringify(state.cart)); }
function renderCart() {
    const quantity = state.cart.reduce((sum, item) => sum + item.quantity, 0);
    const total = state.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    cartCount.textContent = quantity;
    cartCount.classList.toggle('hidden', quantity === 0);
    cartTotal.textContent = money(total);
    cartItems.innerHTML = state.cart.length ? state.cart.map((item) => `<div class="mb-6 flex gap-4"><img class="h-24 w-20 object-cover" src="${item.image}" alt="${item.name}"><div class="flex-1"><div class="flex justify-between gap-3"><h3 class="font-display text-xl">${item.name}</h3><span class="text-sm font-bold">${money(item.price * item.quantity)}</span></div><p class="mt-1 text-xs text-ink/55">${item.fragrance}</p><div class="mt-4 flex items-center gap-3"><button class="quantity-button h-7 w-7 border border-ink/20" data-id="${item.id}" data-change="-1" aria-label="Decrease quantity">−</button><span class="text-sm">${item.quantity}</span><button class="quantity-button h-7 w-7 border border-ink/20" data-id="${item.id}" data-change="1" aria-label="Increase quantity">+</button><button class="remove-item ml-auto text-[10px] font-bold uppercase tracking-widest text-ember" data-id="${item.id}">Remove</button></div></div></div>`).join('') : '<div class="flex h-full items-center justify-center text-center text-sm text-ink/55">Your cart is waiting for something lovely.</div>';
}
function showToast(message) { const toast = document.querySelector('#toast'); toast.textContent = message; toast.classList.remove('hidden'); window.setTimeout(() => toast.classList.add('hidden'), 2400); }
function setCartOpen(open) { cartDrawer.classList.toggle('translate-x-0', open); cartDrawer.classList.toggle('translate-x-full', !open); cartBackdrop.classList.toggle('pointer-events-none', !open); cartBackdrop.classList.toggle('opacity-100', open); }
function addToCart(id, openCart = false) { const product = products.find((entry) => entry.id === id); const existing = state.cart.find((entry) => entry.id === id); existing ? existing.quantity += 1 : state.cart.push({ ...product, quantity: 1 }); persistCart(); renderCart(); showToast(`${product.name} added to your cart`); if (openCart) setCartOpen(true); }

document.addEventListener('click', (event) => {
    const addButton = event.target.closest('.add-to-cart');
    const buyButton = event.target.closest('.buy-now');
    const quantityButton = event.target.closest('.quantity-button');
    const removeButton = event.target.closest('.remove-item');
    if (addButton) addToCart(Number(addButton.dataset.id));
    if (buyButton) addToCart(Number(buyButton.dataset.id), true);
    if (quantityButton) { const item = state.cart.find((entry) => entry.id === Number(quantityButton.dataset.id)); item.quantity += Number(quantityButton.dataset.change); if (item.quantity <= 0) state.cart = state.cart.filter((entry) => entry.id !== item.id); persistCart(); renderCart(); }
    if (removeButton) { state.cart = state.cart.filter((entry) => entry.id !== Number(removeButton.dataset.id)); persistCart(); renderCart(); }
});

categoryFilter.addEventListener('change', () => { state.category = categoryFilter.value; renderProducts(); });
catalogSearch.addEventListener('input', () => { state.query = catalogSearch.value; renderProducts(); });
document.querySelector('#search-input').addEventListener('input', (event) => { catalogSearch.value = event.target.value; state.query = event.target.value; renderProducts(); document.querySelector('#collection').scrollIntoView({ behavior: 'smooth' }); });
document.querySelector('#search-toggle').addEventListener('click', () => document.querySelector('#search-panel').classList.toggle('hidden'));
document.querySelector('#cart-toggle').addEventListener('click', () => setCartOpen(true));
document.querySelector('#cart-close').addEventListener('click', () => setCartOpen(false));
cartBackdrop.addEventListener('click', () => setCartOpen(false));
document.querySelector('#menu-toggle').addEventListener('click', (event) => { const nav = document.querySelector('#mobile-nav'); const open = nav.classList.toggle('hidden') === false; event.currentTarget.textContent = open ? 'Close' : 'Menu'; event.currentTarget.setAttribute('aria-expanded', String(open)); });
document.querySelectorAll('#mobile-nav a').forEach((link) => link.addEventListener('click', () => { document.querySelector('#mobile-nav').classList.add('hidden'); document.querySelector('#menu-toggle').textContent = 'Menu'; }));
document.querySelector('#personalized-form').addEventListener('submit', (event) => { event.preventDefault(); event.target.reset(); showToast('Your personalized candle request is ready'); });
document.querySelector('#newsletter-form').addEventListener('submit', (event) => { event.preventDefault(); event.target.reset(); document.querySelector('#newsletter-message').classList.remove('hidden'); });
document.querySelector('#checkout-button').addEventListener('click', () => showToast(state.cart.length ? 'Checkout is ready to connect' : 'Add a candle before checking out'));

const observer = new IntersectionObserver((entries) => entries.forEach((entry) => { if (entry.isIntersecting) entry.target.classList.add('visible'); }), { threshold: 0.12 });
document.querySelectorAll('section').forEach((section) => { section.classList.add('reveal'); observer.observe(section); });
renderProducts();
renderCart();
