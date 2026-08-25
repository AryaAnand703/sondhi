<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@sondhi.com'],
            [
                'name' => 'Sondhi Admin',
                'password' => Hash::make('password123'),
                'phone' => '+91 9876543210',
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Aarav Sharma',
                'password' => Hash::make('password123'),
                'phone' => '+91 9939628020',
                'role' => 'user',
            ]
        );

        // 2. Saved Address
        $address = Address::firstOrCreate(
            ['user_id' => $user->id, 'recipient_name' => 'Aarav Sharma'],
            [
                'phone' => '+91 9939628020',
                'address_line1' => 'Flat 402, Lotus Heights, Naya Tola',
                'address_line2' => 'Near Rambagh Chowk',
                'city' => 'Purnea',
                'state' => 'Bihar',
                'postal_code' => '854301',
                'is_default' => true,
            ]
        );

        // 3. Categories (Wax Candle, Glass Candle, Jar Candle, Romantic Candle, Special Candle)
        $catWax = Category::firstOrCreate(
            ['slug' => 'wax-candle'],
            [
                'name' => 'Wax Candle',
                'description' => 'Pure natural soy & organic wax candles crafted with lead-free cotton wicks.',
                'image_path' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=600&q=80',
            ]
        );

        $catGlass = Category::firstOrCreate(
            ['slug' => 'glass-candle'],
            [
                'name' => 'Glass Candle',
                'description' => 'Hand-poured artisan candles in premium transparent & amber glass vessels.',
                'image_path' => 'https://images.unsplash.com/photo-1596435707659-ae86628b0751?auto=format&fit=crop&w=600&q=80',
            ]
        );

        $catJar = Category::firstOrCreate(
            ['slug' => 'jar-candle'],
            [
                'name' => 'Jar Candle',
                'description' => 'Aromatic scented soy jar candles with wooden & gold metal airtight lids.',
                'image_path' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=600&q=80',
            ]
        );

        $catRomantic = Category::firstOrCreate(
            ['slug' => 'romantic-candle'],
            [
                'name' => 'Romantic Candle',
                'description' => 'Sensual mood candles infused with French lavender, rose, and warm royal amber.',
                'image_path' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=600&q=80',
            ]
        );

        $catSpecial = Category::firstOrCreate(
            ['slug' => 'special-candle'],
            [
                'name' => 'Special Candle',
                'description' => 'Bespoke celebratory gift sets, wedding favors, and architectural sculptural candles.',
                'image_path' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=600&q=80',
            ]
        );

        // 4. Products mapped to categories
        $p1 = Product::firstOrCreate(
            ['slug' => 'ribbed-arch-soy-wax-candle'],
            [
                'category_id' => $catWax->id,
                'name' => 'Ribbed Arch Soy Wax Candle',
                'description' => 'Minimalist sculptural pillar candle made from 100% natural organic soy wax.',
                'price' => 299.00,
                'stock_quantity' => 150,
                'image_path' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        $p2 = Product::firstOrCreate(
            ['slug' => 'amber-glass-scented-candle'],
            [
                'category_id' => $catGlass->id,
                'name' => 'Amber Glass Scented Candle',
                'description' => 'Hand-poured candle in a reusable amber apothecary glass jar with soothing essential oils.',
                'price' => 499.00,
                'stock_quantity' => 120,
                'image_path' => 'https://images.unsplash.com/photo-1596435707659-ae86628b0751?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        $p3 = Product::firstOrCreate(
            ['slug' => 'french-lavender-vanilla-soy-jar-candle'],
            [
                'category_id' => $catJar->id,
                'name' => 'French Lavender & Vanilla Soy Jar Candle',
                'description' => 'Rich 45+ hour burn time soy wax jar candle with signature wooden lid.',
                'price' => 450.00,
                'stock_quantity' => 200,
                'image_path' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        $p4 = Product::firstOrCreate(
            ['slug' => 'velvet-rose-amber-romantic-candle'],
            [
                'category_id' => $catRomantic->id,
                'name' => 'Velvet Rose & Amber Romantic Candle',
                'description' => 'Romantic sensual candle with warm musk, blooming rose petals, and vanilla essential oil.',
                'price' => 599.00,
                'stock_quantity' => 100,
                'image_path' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        $p5 = Product::firstOrCreate(
            ['slug' => 'deluxe-wedding-favor-special-box'],
            [
                'category_id' => $catSpecial->id,
                'name' => 'Deluxe Wedding Favor Special Box',
                'description' => 'Exclusive magnetic gift box with 2 personalized candles and gold snuffer accessory.',
                'price' => 1250.00,
                'stock_quantity' => 80,
                'image_path' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        // 5. Sample Order
        $order1 = Order::firstOrCreate(
            ['order_number' => 'ORD-10025'],
            [
                'user_id' => $user->id,
                'subtotal' => 5500.00,
                'shipping_fee' => 0.00,
                'total_amount' => 5500.00,
                'status' => 'Processing',
                'payment_method' => 'Online Payment',
                'payment_status' => 'Paid',
                'shipping_address' => [
                    'recipient_name' => $address->recipient_name,
                    'phone' => $address->phone,
                    'address_line1' => $address->address_line1,
                    'address_line2' => $address->address_line2,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postal_code' => $address->postal_code,
                ],
                'notes' => 'Please package carefully with festive ribbon.',
            ]
        );

        if (OrderItem::where('order_id', $order1->id)->count() === 0) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $p3->id,
                'product_name' => $p3->name,
                'price' => 450.00,
                'quantity' => 10,
                'subtotal' => 4500.00,
                'custom_options' => 'Custom label text: "Happy Anniversary"',
            ]);
        }

        // 6. Sample Support Ticket
        $ticket = SupportTicket::firstOrCreate(
            ['ticket_number' => 'TCK-8801'],
            [
                'user_id' => $user->id,
                'order_id' => $order1->id,
                'category' => 'Delivery Query',
                'subject' => 'Estimated Delivery Time for Order ORD-10025',
                'description' => 'Hi Team, could you please provide the dispatch date and courier tracking link for ORD-10025?',
                'priority' => 'Normal',
                'status' => 'In Progress',
            ]
        );

        if (TicketReply::where('ticket_id', $ticket->id)->count() === 0) {
            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'message' => 'Hello Aarav, your order is currently being packed in our facility and will be handed over to BlueDart courier by tomorrow morning!',
                'is_admin' => true,
            ]);
        }
    }
}
