const products = [
    { id: 1, name: 'Lavender & Amber', category: 'Floral', fragrance: 'Lavender, amber, cedar', price: 899, rating: 4.9, image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85' },
    { id: 2, name: 'Rose Noir', category: 'Floral', fragrance: 'Damask rose, musk', price: 849, rating: 4.8, image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85' },
    { id: 3, name: 'Vanilla Oud', category: 'Warm', fragrance: 'Vanilla, tonka, sandalwood', price: 799, rating: 4.9, image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85' },
    { id: 4, name: 'Sandalwood', category: 'Woody', fragrance: 'Oud, saffron, dark wood', price: 1299, rating: 5, image: 'https://images.unsplash.com/photo-1608181831718-c9e7d8a2a3a5?auto=format&fit=crop&w=800&q=85' },
    { id: 5, name: 'Rain on Earth', category: 'Fresh', fragrance: 'Vetiver, green leaf, rain', price: 749, rating: 4.8, image: 'https://images.unsplash.com/photo-1602874801006-e26d6e8f0b15?auto=format&fit=crop&w=800&q=85' },
    { id: 6, name: 'Neroli Bloom', category: 'Floral', fragrance: 'Neroli, orange blossom', price: 949, rating: 4.7, image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85' },
    { id: 7, name: 'Cedar Smoke', category: 'Woody', fragrance: 'Cedar, cardamom, smoke', price: 1199, rating: 4.9, image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85' },
    { id: 8, name: 'Citrus Peel', category: 'Fresh', fragrance: 'Bitter orange, cedar, lime', price: 699, rating: 4.6, image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85' }
];

const state = { category: 'All', query: '' };
const productGrid = document.querySelector('#product-grid');
const categoryFilter = document.querySelector('#category-filter');
const catalogSearch = document.querySelector('#catalog-search');
const money = (value) => `₹${value.toLocaleString('en-IN')}`;

function renderProducts() {
    const visible = products.filter((product) => {
        const matchesCategory = state.category === 'All' || product.category === state.category;
        return matchesCategory && `${product.name} ${product.fragrance}`.toLowerCase().includes(state.query.toLowerCase());
    });
    productGrid.innerHTML = visible.length ? visible.map((product) => `
        <article class="group"><div class="relative overflow-hidden bg-white"><img class="aspect-[4/5] w-full object-cover transition duration-700 group-hover:scale-105" src="${product.image}" alt="${product.name} candle"><span class="absolute left-3 top-3 bg-linen px-3 py-1 text-[10px] font-bold uppercase tracking-widest">${product.category}</span></div><div class="flex items-start justify-between gap-3 border-b border-ink/10 pb-5 pt-4"><div><p class="text-[10px] font-bold uppercase tracking-widest text-ember">${product.fragrance}</p><h3 class="mt-1 font-display text-2xl">${product.name}</h3><p class="mt-2 text-xs text-gold">${'★'.repeat(Math.floor(product.rating))} <span class="text-ink/45">${product.rating}</span></p></div><span class="pt-1 text-sm font-bold">${money(product.price)}</span></div></article>
    `).join('') : '<p class="col-span-full py-16 text-center text-sm text-ink/55">No candles match your search.</p>';
}

function showToast(message) { const toast = document.querySelector('#toast'); toast.textContent = message; toast.classList.remove('hidden'); window.setTimeout(() => toast.classList.add('hidden'), 2400); }

categoryFilter.addEventListener('change', () => { state.category = categoryFilter.value; renderProducts(); });
catalogSearch.addEventListener('input', () => { state.query = catalogSearch.value; renderProducts(); });
document.querySelector('#search-input').addEventListener('input', (event) => { catalogSearch.value = event.target.value; state.query = event.target.value; renderProducts(); document.querySelector('#collection').scrollIntoView({ behavior: 'smooth' }); });
document.querySelector('#search-toggle').addEventListener('click', () => document.querySelector('#search-panel').classList.toggle('hidden'));
document.querySelector('#menu-toggle').addEventListener('click', (event) => { const nav = document.querySelector('#mobile-nav'); const open = nav.classList.toggle('hidden') === false; event.currentTarget.textContent = open ? 'Close' : 'Menu'; event.currentTarget.setAttribute('aria-expanded', String(open)); });
document.querySelectorAll('#mobile-nav a').forEach((link) => link.addEventListener('click', () => { document.querySelector('#mobile-nav').classList.add('hidden'); document.querySelector('#menu-toggle').textContent = 'Menu'; }));
document.querySelector('#newsletter-form').addEventListener('submit', (event) => { event.preventDefault(); event.target.reset(); document.querySelector('#newsletter-message').classList.remove('hidden'); });

const observer = new IntersectionObserver((entries) => entries.forEach((entry) => { if (entry.isIntersecting) entry.target.classList.add('visible'); }), { threshold: 0.12 });
document.querySelectorAll('section').forEach((section) => { section.classList.add('reveal'); observer.observe(section); });
renderProducts();
