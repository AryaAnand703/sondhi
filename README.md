# Sondhi — Handcrafted Luxury Candles & Fragrances (Python Django)

Sondhi is an artisan e-commerce platform for luxury soy wax candles, botanical room diffusers, and bespoke gift hampers built with **Python 3 & Django**.

## Features

- **Storefront & Catalog**: Filter by categories (`Wax Candle`, `Glass Candle`, `Jar Candle`, `Romantic Candle`, `Special Candle`), search queries, and sorting.
- **Brand Story Page**: Dedicated `/about/` page exploring Sondhi's heritage, monsoon-inspired philosophy, and artisanal hand-pouring process.
- **Session Shopping Cart**: Add, update quantity, remove, and clear cart items with real-time subtotal and shipping calculations.
- **Checkout & Order Creation**: Complete order placement with address selection and automatic product stock reduction.
- **Live Order Tracking Pipeline**: Visual delivery tracking pipeline (Pending -> Processing -> Shipped -> Delivered).
- **Customer Auth & Profile**: Account registration, login, profile management, and saved address book.
- **Support Desk Ticket System**: Submit inquiries, track ticket progress, and participate in discussion threads.
- **Admin Management Desk**: Comprehensive admin dashboard for store operations, analytics, product catalog management, category organization, order status updates, support desk responses, and customer directory.

---

## Quick Start Instructions

1. **Install Dependencies**:
   ```bash
   pip install -r requirements.txt
   ```

2. **Run Migrations**:
   ```bash
   python3 manage.py makemigrations
   python3 manage.py migrate
   ```

3. **Seed Default Categories, Products & Accounts**:
   ```bash
   python3 seed_data.py
   ```

4. **Launch Development Server**:
   ```bash
   python3 manage.py runserver 8000
   ```

5. **Access Application**:
   - **Storefront**: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)
   - **Customer Login**: `user@example.com` / `password123`
   - **Admin Management Desk**: [http://127.0.0.1:8000/admin-desk/login/](http://127.0.0.1:8000/admin-desk/login/) (`admin@sondhi.com` / `password123`)
