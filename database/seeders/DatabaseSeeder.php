<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\AuditLog;
use App\Models\BespokeFormula;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $arya = User::updateOrCreate(
            ['email' => 'arya@example.com'],
            [
                'name' => 'Arya Anand',
                'username' => 'arya',
                'password' => Hash::make('arya123'),
                'role' => 'customer',
                'tier' => 'VIP Collector',
                'points' => 1450,
                'phone' => '+91 98765 43210',
            ]
        );

        $meera = User::updateOrCreate(
            ['email' => 'meera@sondhi.co'],
            [
                'name' => 'Meera Rajput',
                'username' => 'meera',
                'password' => Hash::make('meera123'),
                'role' => 'admin',
                'tier' => 'Master Artisan & Manager',
                'points' => 820,
                'phone' => '+91 91234 56789',
            ]
        );

        $superadmin = User::updateOrCreate(
            ['email' => 'governor@sondhi.co'],
            [
                'name' => 'System Governor',
                'username' => 'superadmin',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'tier' => 'Super Admin',
                'points' => 5000,
                'phone' => '+91 99999 00000',
            ]
        );

        // 2. Seed Luxury Fragrance Catalog (Products)
        $productsData = [
            [
                'name' => 'Lavender & Golden Amber',
                'slug' => 'lavender-golden-amber',
                'category' => 'Floral',
                'fragrance' => 'French Lavender, Golden Amber, Spiced Cedar',
                'top_notes' => 'Wild Provence Lavender, Bergamot Zest',
                'heart_notes' => 'Golden Amber, Chamomile Blossom',
                'base_notes' => 'Smoked Cedarwood, White Musk',
                'price' => 899.00,
                'rating' => 4.9,
                'reviews_count' => 184,
                'burn_time' => '50 Hours',
                'weight' => '280g',
                'badge' => 'Bestseller',
                'image' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=85',
                'description' => 'An intimate lullaby of French highlands lavender bathed in resinous molten amber. Formulated for evening un-winding and restful sleep sanctuaries.',
                'stock' => 45,
            ],
            [
                'name' => 'Rose Noir & Velvet Musk',
                'slug' => 'rose-noir-velvet-musk',
                'category' => 'Floral',
                'fragrance' => 'Damask Rose, Midnight Oud, Velvet Musk',
                'top_notes' => 'Crushed Pink Peppercorn, Damask Rose',
                'heart_notes' => 'Black Violet, Saffron Silk',
                'base_notes' => 'Patchouli Leaf, Smoked Vetiver',
                'price' => 949.00,
                'rating' => 4.8,
                'reviews_count' => 142,
                'burn_time' => '52 Hours',
                'weight' => '280g',
                'badge' => 'Staff Favorite',
                'image' => 'https://images.unsplash.com/photo-1602607207252-4c2b2f07a5d3?auto=format&fit=crop&w=800&q=85',
                'description' => 'Deep, brooding, and unapologetically romantic. Dark Turkish petals steeped in velvety botanical musk for dinner parties and romantic evenings.',
                'stock' => 38,
            ],
            [
                'name' => 'Vanilla Tonka & Bourbon',
                'slug' => 'vanilla-tonka-bourbon',
                'category' => 'Warm',
                'fragrance' => 'Bourbon Vanilla, Roasted Tonka, Sandalwood',
                'top_notes' => 'Cardamom Pods, Warm Milk',
                'heart_notes' => 'Madagascar Vanilla Bean, Tonka Bean',
                'base_notes' => 'Creamy Mysore Sandalwood, Cocoa Husk',
                'price' => 799.00,
                'rating' => 4.9,
                'reviews_count' => 218,
                'burn_time' => '48 Hours',
                'weight' => '260g',
                'badge' => 'Essential',
                'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=85',
                'description' => 'Warm, culinary, and deeply nostalgic. Unlike synthetic vanilla, this features pure bean caviar wrapped in slow-roasted tonka and sandalwood.',
                'stock' => 52,
            ],
            [
                'name' => 'Sandalwood & Velvet Oud',
                'slug' => 'sandalwood-velvet-oud',
                'category' => 'Woody',
                'fragrance' => 'Mysore Sandalwood, Royal Agarwood, Smoked Leather',
                'top_notes' => 'Nutmeg, Frankincense Tear',
                'heart_notes' => 'Aged Mysore Sandalwood, Cashmere',
                'base_notes' => 'Royal Assam Agarwood, Black Amber',
                'price' => 1299.00,
                'rating' => 5.0,
                'reviews_count' => 96,
                'burn_time' => '55 Hours',
                'weight' => '300g',
                'badge' => 'Reserve',
                'image' => 'https://images.unsplash.com/photo-1595867818082-083862f3d630?auto=format&fit=crop&w=800&q=85',
                'description' => 'The jewel of the Sondhi archive. Aged Mysore heartwood and ethically sourced Assam oud produce a reverent, sacred atmosphere.',
                'stock' => 20,
            ],
            [
                'name' => 'Rain on Earth (Mitti Attar)',
                'slug' => 'rain-on-earth-mitti-attar',
                'category' => 'Earthy',
                'fragrance' => 'Baked Clay, Summer Petrichor, Vetiver Root',
                'top_notes' => 'Summer Ozone, Wet River Stones',
                'heart_notes' => 'Sun-Baked Kannauj Clay, Fresh Moss',
                'base_notes' => 'Ruh Khus Vetiver, Damp Loam',
                'price' => 849.00,
                'rating' => 4.9,
                'reviews_count' => 310,
                'burn_time' => '48 Hours',
                'weight' => '260g',
                'badge' => 'Iconic Heritage',
                'image' => 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=85',
                'description' => 'The purest olfactory tribute to the first drops of monsoon rain striking parched northern soil. Pure nostalgic tranquility.',
                'stock' => 60,
            ],
            [
                'name' => 'Neroli Blossom & Petitgrain',
                'slug' => 'neroli-blossom-petitgrain',
                'category' => 'Fresh',
                'fragrance' => 'Bitter Orange Blossom, Crushed Leaves, Sunlit Citrus',
                'top_notes' => 'Italian Petitgrain, Green Mandarin',
                'heart_notes' => 'Tunisian Neroli, Orange Blossom',
                'base_notes' => 'Blonde Woods, Sheer White Amber',
                'price' => 799.00,
                'rating' => 4.7,
                'reviews_count' => 115,
                'burn_time' => '46 Hours',
                'weight' => '260g',
                'badge' => 'Morning Ritual',
                'image' => 'https://images.unsplash.com/photo-1572726729437-3732efed3f8a?auto=format&fit=crop&w=800&q=85',
                'description' => 'Crisp morning terrace breeze across citrus groves. Revitalizes mental clarity, elevates creative workflow spaces, and lifts mood effortlessly.',
                'stock' => 40,
            ],
            [
                'name' => 'Cardamom, Saffron & Kashmiri Chai',
                'slug' => 'cardamom-saffron-kashmiri-chai',
                'category' => 'Warm',
                'fragrance' => 'Green Cardamom, Mongra Saffron, Spiced Tea',
                'top_notes' => 'Crushed Cardamom Pods, Ginger Root',
                'heart_notes' => 'Kashmiri Mongra Saffron, Cinnamon Bark',
                'base_notes' => 'Steeped Assam Tea Leaf, Sweet Milk Amber',
                'price' => 899.00,
                'rating' => 4.9,
                'reviews_count' => 167,
                'burn_time' => '50 Hours',
                'weight' => '280g',
                'badge' => 'Winter Haven',
                'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?auto=format&fit=crop&w=800&q=85',
                'description' => 'An opulent, comforting spice blend honoring royal tea salons. Fills living spaces with a generous, hospitality-laden glow.',
                'stock' => 35,
            ],
            [
                'name' => 'Eucalyptus, Sea Salt & Coastal Pine',
                'slug' => 'eucalyptus-sea-salt-coastal-pine',
                'category' => 'Fresh',
                'fragrance' => 'Blue Eucalyptus, Crashing Surf, Cypress Needle',
                'top_notes' => 'Mineral Sea Salt, Tasmanian Eucalyptus',
                'heart_notes' => 'Blue Sage, Wild Juniper Berry',
                'base_notes' => 'Coastal Cypress, Driftwood Shore',
                'price' => 749.00,
                'rating' => 4.8,
                'reviews_count' => 89,
                'burn_time' => '48 Hours',
                'weight' => '260g',
                'badge' => null,
                'image' => 'https://images.unsplash.com/photo-1508746829417-e6f548d8d6ed?auto=format&fit=crop&w=800&q=85',
                'description' => 'Breathe deep in a cliffside conservatory overlooking tempestuous waves. Calming, refreshing, and clarifying.',
                'stock' => 28,
            ],
        ];

        $seededProducts = [];
        foreach ($productsData as $data) {
            $product = Product::updateOrCreate(['slug' => $data['slug']], $data);
            $seededProducts[$product->slug] = $product;
        }

        // 3. Seed Addresses for Arya
        Address::updateOrCreate(
            ['user_id' => $arya->id, 'label' => 'Primary Sanctuary Residence'],
            [
                'street' => '7B, Sea Face Promenade, Worli',
                'city' => 'Mumbai',
                'pincode' => '400018',
                'is_default' => true,
            ]
        );

        Address::updateOrCreate(
            ['user_id' => $arya->id, 'label' => 'Art & Design Studio'],
            [
                'street' => '402 The Loft, Industrial Estate, Lower Parel',
                'city' => 'Mumbai',
                'pincode' => '400013',
                'is_default' => false,
            ]
        );

        // Address for Meera
        Address::updateOrCreate(
            ['user_id' => $meera->id, 'label' => 'Atelier Workshop'],
            [
                'street' => '14 Craft Guild Lane, Fort',
                'city' => 'Mumbai',
                'pincode' => '400001',
                'is_default' => true,
            ]
        );

        // 4. Seed Bespoke Formula for Arya
        BespokeFormula::updateOrCreate(
            ['user_id' => $arya->id, 'name' => 'Midnight Monsoon & Oud'],
            [
                'vessel' => 'Matte Obsidian Ceramic',
                'wick' => 'Dual Crackling Cedar Wood',
                'top' => 'Mitti Attar Petrichor & Ozone',
                'heart' => 'Midnight Damask Rose & Nutmeg',
                'base' => 'Smoked Cambodian Oud & Sandalwood',
                'notes' => 'Intimate evening meditation candle with deep earthy petrichor throw.',
            ]
        );

        // 5. Seed Discounts
        Discount::updateOrCreate(
            ['code' => 'ATELIER10'],
            [
                'type' => 'percent',
                'value' => 10,
                'min_spend' => 1000,
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'FIRSTLOVE'],
            [
                'type' => 'percent',
                'value' => 15,
                'min_spend' => 1500,
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'SANCTUARY'],
            [
                'type' => 'fixed',
                'value' => 300,
                'min_spend' => 2000,
                'is_active' => true,
            ]
        );

        // 6. Seed Orders for Arya
        $order1 = Order::updateOrCreate(
            ['order_number' => 'SND-9014'],
            [
                'user_id' => $arya->id,
                'customer_name' => $arya->name,
                'customer_email' => $arya->email,
                'status' => 'Pouring & Curing',
                'status_code' => 'pouring',
                'status_desc' => 'Botanical soy wax setting in ceramic vessels under ambient temperature control',
                'items_count' => 3,
                'subtotal' => 2647.00,
                'discount_amount' => 0.00,
                'total' => 2647.00,
                'estimated_delivery' => 'Sep 21, 2026',
                'shipping_address' => '7B, Sea Face Promenade, Worli, Mumbai - 400018',
                'payment_method' => 'UPI / Card',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_name' => 'Lavender & Golden Amber (280g)'],
            [
                'product_id' => $seededProducts['lavender-golden-amber']->id ?? null,
                'price' => 899.00,
                'quantity' => 2,
                'subtotal' => 1798.00,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_name' => 'Rain on Earth Mitti Attar (260g)'],
            [
                'product_id' => $seededProducts['rain-on-earth-mitti-attar']->id ?? null,
                'price' => 849.00,
                'quantity' => 1,
                'subtotal' => 849.00,
            ]
        );

        $order2 = Order::updateOrCreate(
            ['order_number' => 'SND-8890'],
            [
                'user_id' => $arya->id,
                'customer_name' => $arya->name,
                'customer_email' => $arya->email,
                'status' => 'Delivered',
                'status_code' => 'delivered',
                'status_desc' => 'Delivered via White-Glove Courier to Mumbai Sanctuary',
                'items_count' => 1,
                'subtotal' => 2499.00,
                'discount_amount' => 0.00,
                'total' => 2499.00,
                'estimated_delivery' => 'Delivered Aug 18, 2026',
                'shipping_address' => '7B, Sea Face Promenade, Worli, Mumbai - 400018',
                'payment_method' => 'Card',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_name' => 'Flame Circle Q3 Reserve Box (Monsoon Vetiver)'],
            [
                'product_id' => null,
                'price' => 2499.00,
                'quantity' => 1,
                'subtotal' => 2499.00,
            ]
        );

        $order3 = Order::updateOrCreate(
            ['order_number' => 'SND-8412'],
            [
                'user_id' => $arya->id,
                'customer_name' => $arya->name,
                'customer_email' => $arya->email,
                'status' => 'Delivered',
                'status_code' => 'delivered',
                'status_desc' => 'Delivered with bespoke wax sealing',
                'items_count' => 2,
                'subtotal' => 2248.00,
                'discount_amount' => 150.00,
                'total' => 2098.00,
                'estimated_delivery' => 'Delivered Jun 14, 2026',
                'shipping_address' => '402 The Loft, Industrial Estate, Lower Parel, Mumbai - 400013',
                'payment_method' => 'Card',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_name' => 'Sandalwood & Velvet Oud (300g)'],
            [
                'product_id' => $seededProducts['sandalwood-velvet-oud']->id ?? null,
                'price' => 1299.00,
                'quantity' => 1,
                'subtotal' => 1299.00,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_name' => 'Neroli Blossom & Petitgrain (260g)'],
            [
                'product_id' => $seededProducts['neroli-blossom-petitgrain']->id ?? null,
                'price' => 799.00,
                'quantity' => 1,
                'subtotal' => 799.00,
            ]
        );

        // Order for Meera
        $orderMeera = Order::updateOrCreate(
            ['order_number' => 'SND-9015'],
            [
                'user_id' => $meera->id,
                'customer_name' => $meera->name,
                'customer_email' => $meera->email,
                'status' => 'Pending',
                'status_code' => 'pending',
                'status_desc' => 'Awaiting artisan bench allocation',
                'items_count' => 1,
                'subtotal' => 1299.00,
                'discount_amount' => 0.00,
                'total' => 1299.00,
                'estimated_delivery' => 'Sep 25, 2026',
                'shipping_address' => '14 Craft Guild Lane, Fort, Mumbai - 400001',
                'payment_method' => 'Artisan Internal',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $orderMeera->id, 'product_name' => 'Sandalwood & Velvet Oud (300g)'],
            [
                'product_id' => $seededProducts['sandalwood-velvet-oud']->id ?? null,
                'price' => 1299.00,
                'quantity' => 1,
                'subtotal' => 1299.00,
            ]
        );

        // 7. Seed Audit Logs
        AuditLog::create([
            'user_id' => $superadmin->id,
            'action' => 'SYSTEM_INITIALIZED',
            'details' => 'Sondhi Atelier Laravel instance initialized with luxury fragrance catalog.',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
