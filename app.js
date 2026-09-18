// --- Candle Catalog Data ---
const products = [
    {
        id: 1,
        name: 'Lavender & Amber',
        category: 'Floral',
        fragrance: 'Lavender, amber, cedar',
        price: 899,
        rating: 4.9,
        image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 2,
        name: 'Rose Noir',
        category: 'Floral',
        fragrance: 'Damask rose, musk',
        price: 849,
        rating: 4.8,
        image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 3,
        name: 'Vanilla Oud',
        category: 'Warm',
        fragrance: 'Vanilla, tonka, sandalwood',
        price: 799,
        rating: 4.9,
        image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 4,
        name: 'Sandalwood',
        category: 'Woody',
        fragrance: 'Oud, saffron, dark wood',
        price: 1299,
        rating: 5,
        image: 'https://images.unsplash.com/photo-1608181831718-c9e7d8a2a3a5?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 5,
        name: 'Rain on Earth',
        category: 'Fresh',
        fragrance: 'Vetiver, green leaf, rain',
        price: 749,
        rating: 4.8,
        image: 'https://images.unsplash.com/photo-1602874801006-e26d6e8f0b15?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 6,
        name: 'Neroli Bloom',
        category: 'Floral',
        fragrance: 'Neroli, orange blossom',
        price: 949,
        rating: 4.7,
        image: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 7,
        name: 'Cedar Smoke',
        category: 'Woody',
        fragrance: 'Cedar, cardamom, smoke',
        price: 1199,
        rating: 4.9,
        image: 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85'
    },
    {
        id: 8,
        name: 'Citrus Peel',
        category: 'Fresh',
        fragrance: 'Bitter orange, cedar, lime',
        price: 699,
        rating: 4.6,
        image: 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85'
    }
];

// --- State Management ---
const state = {
    category: 'All',
    query: ''
};

// --- DOM Elements ---
const productGrid = document.querySelector('#product-grid');
const categoryFilter = document.querySelector('#category-filter');
const catalogSearch = document.querySelector('#catalog-search');
const moodFilters = document.querySelectorAll('.mood-filter');
const searchToggle = document.querySelector('#search-toggle');
const searchPanel = document.querySelector('#search-panel');
const searchInput = document.querySelector('#search-input');
const menuToggle = document.querySelector('#menu-toggle');
const mobileNav = document.querySelector('#mobile-nav');
const newsletterForm = document.querySelector('#newsletter-form');
const newsletterMessage = document.querySelector('#newsletter-message');
const toast = document.querySelector('#toast');

// --- Helper Functions ---
const money = (value) => `₹${value.toLocaleString('en-IN')}`;

function showToast(message) {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.remove('hidden');
    window.setTimeout(() => {
        toast.classList.add('hidden');
    }, 2400);
}

// --- Product Rendering ---
function renderProducts() {
    if (!productGrid) return;

    const visible = products.filter((product) => {
        const matchesCategory = state.category === 'All' || product.category === state.category;
        const matchesSearch = `${product.name} ${product.fragrance}`
            .toLowerCase()
            .includes(state.query.toLowerCase());
        return matchesCategory && matchesSearch;
    });

    if (!visible.length) {
        productGrid.innerHTML = `
            <p class="col-span-full py-16 text-center text-sm text-brown/55">
                No candles match your search.
            </p>
        `;
        return;
    }

    productGrid.innerHTML = visible.map((product) => `
        <article class="group grid gap-4 sm:grid-cols-[minmax(0,1fr)_minmax(150px,.65fr)]">
            <div class="relative overflow-hidden bg-white">
                <img class="aspect-[4/5] w-full object-cover transition duration-700 group-hover:scale-105" 
                     src="${product.image}" 
                     alt="${product.name} candle">
                <span class="absolute left-3 top-3 bg-ivory px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-brown">
                    ${product.category}
                </span>
            </div>
            <div class="flex flex-col justify-between border-b border-brown/10 pb-5 pt-1 sm:border-b-0 sm:border-l sm:pl-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-rose">
                        ${product.fragrance}
                    </p>
                    <h3 class="mt-2 font-display text-3xl leading-none text-brown">
                        ${product.name}
                    </h3>
                    <p class="mt-3 text-xs text-gold">
                        ${'★'.repeat(Math.floor(product.rating))} 
                        <span class="text-brown/45">${product.rating}</span>
                    </p>
                </div>
                <span class="mt-6 text-sm font-bold text-brown">
                    ${money(product.price)}
                </span>
            </div>
        </article>
    `).join('');
}

// --- Event Listeners: Filter & Search ---
if (categoryFilter) {
    categoryFilter.addEventListener('change', () => {
        state.category = categoryFilter.value;
        renderProducts();
    });
}

moodFilters.forEach((filter) => {
    filter.addEventListener('click', () => {
        state.category = filter.dataset.category;
        if (categoryFilter) {
            categoryFilter.value = state.category;
        }
        moodFilters.forEach((item) => {
            item.setAttribute('aria-pressed', String(item === filter));
        });
        renderProducts();
    });
});

if (catalogSearch) {
    catalogSearch.addEventListener('input', () => {
        state.query = catalogSearch.value;
        renderProducts();
    });
}

if (searchInput) {
    searchInput.addEventListener('input', (event) => {
        if (catalogSearch) {
            catalogSearch.value = event.target.value;
        }
        state.query = event.target.value;
        renderProducts();
        document.querySelector('#collection')?.scrollIntoView({ behavior: 'smooth' });
    });
}

if (searchToggle && searchPanel) {
    searchToggle.addEventListener('click', () => {
        searchPanel.classList.toggle('hidden');
        if (!searchPanel.classList.contains('hidden')) {
            searchInput?.focus();
        }
    });
}

// --- Event Listeners: Mobile Navigation ---
if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', (event) => {
        const isOpen = mobileNav.classList.toggle('hidden') === false;
        event.currentTarget.textContent = isOpen ? 'Close' : 'Menu';
        event.currentTarget.setAttribute('aria-expanded', String(isOpen));
    });
}

document.querySelectorAll('#mobile-nav a').forEach((link) => {
    link.addEventListener('click', () => {
        mobileNav?.classList.add('hidden');
        if (menuToggle) {
            menuToggle.textContent = 'Menu';
            menuToggle.setAttribute('aria-expanded', 'false');
        }
    });
});

// --- Event Listeners: Newsletter ---
if (newsletterForm) {
    newsletterForm.addEventListener('submit', (event) => {
        event.preventDefault();
        event.target.reset();
        if (newsletterMessage) {
            newsletterMessage.classList.remove('hidden');
        }
    });
}

// --- Scroll Reveal Animations ---
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('section').forEach((section) => {
    section.classList.add('reveal');
    observer.observe(section);
});

// --- Initial Render ---
renderProducts();
