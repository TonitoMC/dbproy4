<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding product data...');

        $brands = Brand::all()->keyBy('name');
        $categories = Category::all()->keyBy('name');

        $specificProducts = [
            [
                'name' => 'iPhone 15 Pro Max',
                'brand' => 'TechNova',
                'categories' => ['Smartphones', 'Electronics'],
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'brand' => 'TechNova',
                'categories' => ['Smartphones', 'Electronics'],
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'brand' => 'TechNova',
                'categories' => ['Smartphones', 'Electronics'],
            ],
            [
                'name' => 'Dell XPS 15 Laptop',
                'brand' => 'TechNova',
                'categories' => ['Laptops', 'Electronics'],
            ],
            [
                'name' => 'MacBook Pro 16-inch',
                'brand' => 'TechNova',
                'categories' => ['Laptops', 'Electronics'],
            ],
            [
                'name' => 'HP Spectre x360',
                'brand' => 'TechNova',
                'categories' => ['Laptops', 'Electronics'],
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'brand' => 'SonicSound',
                'categories' => ['Audio', 'Electronics'],
            ],
            [
                'name' => 'Bose QuietComfort Earbuds II',
                'brand' => 'SonicSound',
                'categories' => ['Audio', 'Electronics'],
            ],
            [
                'name' => 'JBL Flip 6 Portable Speaker',
                'brand' => 'SonicSound',
                'categories' => ['Audio', 'Electronics'],
            ],
            [
                'name' => 'PlayStation 5 Console',
                'brand' => 'TechNova',
                'categories' => ['Gaming', 'Electronics'],
            ],
            [
                'name' => 'Xbox Series X Console',
                'brand' => 'TechNova',
                'categories' => ['Gaming', 'Electronics'],
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'brand' => 'TechNova',
                'categories' => ['Gaming', 'Electronics'],
            ],
            [
                'name' => 'DJI Mavic 3 Pro Drone',
                'brand' => 'TechNova',
                'categories' => ['Drones', 'Electronics'],
            ],
            [
                'name' => 'GoPro HERO11 Black',
                'brand' => 'TechNova',
                'categories' => ['Drones', 'Electronics'],
            ],
            [
                'name' => 'Apple Watch Series 9',
                'brand' => 'TechNova',
                'categories' => ['Wearables', 'Electronics'],
            ],
            [
                'name' => 'Fitbit Charge 6',
                'brand' => 'TechNova',
                'categories' => ['Wearables', 'Electronics'],
            ],
            [
                'name' => 'Samsung 65-inch Neo QLED 4K TV',
                'brand' => 'TechNova',
                'categories' => ['Electronics'],
            ],
            [
                'name' => 'LG C3 OLED 55-inch TV',
                'brand' => 'TechNova',
                'categories' => ['Electronics'],
            ],
            [
                'name' => 'Logitech MX Master 3S Mouse',
                'brand' => 'TechNova',
                'categories' => ['Gaming', 'Electronics'],
            ],
            [
                'name' => 'Razer BlackWidow V4 Keyboard',
                'brand' => 'TechNova',
                'categories' => ['Gaming', 'Electronics'],
            ],
            [
                'name' => 'Men\'s Classic Fit Jeans',
                'brand' => 'Aura Apparel',
                'categories' => ['Menswear', 'Clothing'],
            ],
            [
                'name' => 'Men\'s Performance T-Shirt',
                'brand' => 'Aura Apparel',
                'categories' => ['Menswear', 'Clothing', 'Activewear'],
            ],
            [
                'name' => 'Men\'s Winter Puffer Jacket',
                'brand' => 'Aura Apparel',
                'categories' => ['Menswear', 'Clothing', 'Outerwear'],
            ],
            [
                'name' => 'Women\'s Yoga Pants',
                'brand' => 'Aura Apparel',
                'categories' => ['Womenswear', 'Clothing', 'Activewear'],
            ],
            [
                'name' => 'Women\'s Casual Summer Dress',
                'brand' => 'Aura Apparel',
                'categories' => ['Womenswear', 'Clothing'],
            ],
            [
                'name' => 'Women\'s Waterproof Raincoat',
                'brand' => 'Aura Apparel',
                'categories' => ['Womenswear', 'Clothing', 'Outerwear'],
            ],
            [
                'name' => 'Kids Dino Hoodie',
                'brand' => 'Aura Apparel',
                'categories' => ['Kids Apparel', 'Clothing', 'Outerwear'],
            ],
            [
                'name' => 'Kids Playtime Shorts',
                'brand' => 'Aura Apparel',
                'categories' => ['Kids Apparel', 'Clothing'],
            ],
            [
                'name' => 'Unisex Running Shoes',
                'brand' => 'Aura Apparel',
                'categories' => ['Footwear', 'Clothing', 'Activewear'],
            ],
            [
                'name' => 'Leather Ankle Boots',
                'brand' => 'Aura Apparel',
                'categories' => ['Footwear', 'Clothing'],
            ],
            [
                'name' => 'Men\'s Slim Fit Chinos',
                'brand' => 'UrbanWear Co.',
                'categories' => ['Menswear', 'Clothing'],
            ],
            [
                'name' => 'Women\'s High-Waisted Skirt',
                'brand' => 'UrbanWear Co.',
                'categories' => ['Womenswear', 'Clothing'],
            ],
            [
                'name' => 'Unisex Graphic Tee',
                'brand' => 'UrbanWear Co.',
                'categories' => ['Menswear', 'Womenswear', 'Clothing'],
            ],
            [
                'name' => 'Winter Knit Beanie',
                'brand' => 'UrbanWear Co.',
                'categories' => ['Outerwear', 'Clothing'],
            ],
            [
                'name' => 'Comfort Fit Socks (6-pack)',
                'brand' => 'UrbanWear Co.',
                'categories' => ['Clothing'],
            ],
            [
                'name' => 'Non-stick Fry Pan Set',
                'brand' => 'KitchenPro',
                'categories' => ['Cookware', 'Home & Kitchen'],
            ],
            [
                'name' => 'Stainless Steel Pot Set',
                'brand' => 'KitchenPro',
                'categories' => ['Cookware', 'Home & Kitchen'],
            ],
            [
                'name' => 'Smart Air Fryer XL',
                'brand' => 'KitchenPro',
                'categories' => ['Appliances', 'Home & Kitchen'],
            ],
            [
                'name' => 'High-Speed Blender',
                'brand' => 'KitchenPro',
                'categories' => ['Appliances', 'Home & Kitchen'],
            ],
            [
                'name' => 'Ceramic Dinnerware Set (4-person)',
                'brand' => 'KitchenPro',
                'categories' => ['Decor', 'Home & Kitchen'],
            ],
            [
                'name' => 'Organic Cotton Sheet Set (Queen)',
                'brand' => 'EcoLiving',
                'categories' => ['Bedding', 'Home & Kitchen'],
            ],
            [
                'name' => 'Memory Foam Pillow Pair',
                'brand' => 'EcoLiving',
                'categories' => ['Bedding', 'Home & Kitchen'],
            ],
            [
                'name' => 'Modular Storage Cubes (4-Pack)',
                'brand' => 'EcoLiving',
                'categories' => ['Storage', 'Home & Kitchen'],
            ],
            [
                'name' => 'Bamboo Drawer Organizers',
                'brand' => 'EcoLiving',
                'categories' => ['Storage', 'Home & Kitchen'],
            ],
            [
                'name' => 'Modern Velvet Armchair',
                'brand' => 'EcoLiving',
                'categories' => ['Furniture', 'Home & Kitchen'],
            ],
            [
                'name' => 'Scandinavian Dining Table',
                'brand' => 'EcoLiving',
                'categories' => ['Furniture', 'Home & Kitchen'],
            ],
            [
                'name' => 'LED Strip Lights (10ft)',
                'brand' => 'GloBright Lighting',
                'categories' => ['Decor', 'Home & Kitchen'],
            ],
            [
                'name' => 'Smart Wi-Fi Light Bulbs (4-pack)',
                'brand' => 'GloBright Lighting',
                'categories' => ['Appliances', 'Home & Kitchen'],
            ],
            [
                'name' => 'Aroma Diffuser with Essential Oils',
                'brand' => 'EcoLiving',
                'categories' => ['Decor', 'Health & Beauty', 'Home & Kitchen'],
            ],
            [
                'name' => 'Robotic Floor Cleaner',
                'brand' => 'KitchenPro',
                'categories' => ['Appliances', 'Home & Kitchen'],
            ],
            [
                'name' => 'The Midnight Library',
                'brand' => 'Bookworm Press',
                'categories' => ['Fiction', 'Books'],
            ],
            [
                'name' => 'Project Hail Mary',
                'brand' => 'Bookworm Press',
                'categories' => ['Fiction', 'Books'],
            ],
            [
                'name' => 'Dune (Paperback)',
                'brand' => 'Bookworm Press',
                'categories' => ['Fiction', 'Books'],
            ],
            [
                'name' => 'Sapiens: A Brief History',
                'brand' => 'Bookworm Press',
                'categories' => ['Non-Fiction', 'Books'],
            ],
            [
                'name' => 'Atomic Habits',
                'brand' => 'Bookworm Press',
                'categories' => ['Non-Fiction', 'Books'],
            ],
            [
                'name' => 'The Power of Habit',
                'brand' => 'Bookworm Press',
                'categories' => ['Non-Fiction', 'Books'],
            ],
            [
                'name' => 'The Adventures of Captain Underpants',
                'brand' => 'Bookworm Press',
                'categories' => ['Childrens', 'Books', 'Comics'],
            ],
            [
                'name' => 'Dog Man: Twenty Thousand Fleas Under the Sea',
                'brand' => 'Bookworm Press',
                'categories' => ['Childrens', 'Books', 'Comics'],
            ],
            [
                'name' => 'Intro to Computer Science: A Modern Approach',
                'brand' => 'Bookworm Press',
                'categories' => ['Textbooks', 'Books'],
            ],
            [
                'name' => 'Popular Science Magazine (Latest Issue)',
                'brand' => 'Bookworm Press',
                'categories' => ['Magazines', 'Books'],
            ],
            [
                'name' => '2-Person Backpacking Tent',
                'brand' => 'PowerFit Gear',
                'categories' => ['Camping', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Lightweight Sleeping Bag',
                'brand' => 'PowerFit Gear',
                'categories' => ['Camping', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Advanced Road Bike',
                'brand' => 'PowerFit Gear',
                'categories' => ['Cycling', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Mountain Bike Helmet',
                'brand' => 'PowerFit Gear',
                'categories' => ['Cycling', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Pro Resistance Band Set',
                'brand' => 'PowerFit Gear',
                'categories' => ['Fitness', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Adjustable Dumbbell Set (5-50lbs)',
                'brand' => 'PowerFit Gear',
                'categories' => ['Fitness', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Official Size Basketball',
                'brand' => 'PowerFit Gear',
                'categories' => ['Team Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Soccer Ball (Size 5)',
                'brand' => 'PowerFit Gear',
                'categories' => ['Team Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Inflatable Stand Up Paddleboard',
                'brand' => 'PowerFit Gear',
                'categories' => ['Water Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Snorkeling Mask and Fin Set',
                'brand' => 'PowerFit Gear',
                'categories' => ['Water Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Adult Ski Goggles',
                'brand' => 'PowerFit Gear',
                'categories' => ['Winter Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Snowboard Boots (Men\'s)',
                'brand' => 'PowerFit Gear',
                'categories' => ['Winter Sports', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Yoga Mat with Carrying Strap',
                'brand' => 'PowerFit Gear',
                'categories' => ['Fitness', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Portable Camping Stove',
                'brand' => 'PowerFit Gear',
                'categories' => ['Camping', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Waterproof Backpack 30L',
                'brand' => 'PowerFit Gear',
                'categories' => ['Camping', 'Sports & Outdoors'],
            ],
            [
                'name' => 'Daily Hydrating Serum',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Skincare', 'Health & Beauty'],
            ],
            [
                'name' => 'Vitamin C Brightening Cleanser',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Skincare', 'Health & Beauty'],
            ],
            [
                'name' => 'Organic Shampoo & Conditioner Set',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Haircare', 'Health & Beauty'],
            ],
            [
                'name' => 'Anti-Dandruff Tea Tree Shampoo',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Haircare', 'Health & Beauty'],
            ],
            [
                'name' => 'Natural Mineral Sunscreen SPF 50',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Skincare', 'Health & Beauty'],
            ],
            [
                'name' => 'Daily Multi-Vitamin (60 count)',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Supplements', 'Health & Beauty'],
            ],
            [
                'name' => 'Omega-3 Fish Oil Capsules',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Supplements', 'Health & Beauty'],
            ],
            [
                'name' => 'Herbal Sleep Aid',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Supplements', 'Health & Beauty'],
            ],
            [
                'name' => 'Matte Liquid Lipstick (Ruby Red)',
                'brand' => 'CreativeCanvas',
                'categories' => ['Makeup', 'Health & Beauty'],
            ],
            [
                'name' => 'Volumizing Mascara',
                'brand' => 'CreativeCanvas',
                'categories' => ['Makeup', 'Health & Beauty'],
            ],
            [
                'name' => 'Eau de Parfum (Floral Breeze)',
                'brand' => 'CreativeCanvas',
                'categories' => ['Fragrances', 'Health & Beauty'],
            ],
            [
                'name' => 'Citrus Burst Hand Soap',
                'brand' => 'EcoLiving',
                'categories' => ['Skincare', 'Health & Beauty'],
            ],
            [
                'name' => 'Bamboo Toothbrush (4-Pack)',
                'brand' => 'EcoLiving',
                'categories' => ['Health & Beauty'],
            ],
            [
                'name' => 'Reusable Cotton Pads (10-Pack)',
                'brand' => 'EcoLiving',
                'categories' => ['Health & Beauty'],
            ],
            [
                'name' => 'Aromatherapy Diffuser',
                'brand' => 'GreenLeaf Organics',
                'categories' => ['Health & Beauty', 'Home & Kitchen'],
            ],
            [
                'name' => 'Universal Car Floor Mats',
                'brand' => 'QuickFix Tools',
                'categories' => ['Interior Accessories', 'Automotive'],
            ],
            [
                'name' => '100-Piece Mechanics Tool Set',
                'brand' => 'QuickFix Tools',
                'categories' => ['Tools & Equipment', 'Automotive'],
            ],
            [
                'name' => 'Portable Car Jump Starter',
                'brand' => 'QuickFix Tools',
                'categories' => ['Tools & Equipment', 'Automotive'],
            ],
            [
                'name' => 'Heavy-Duty Car Jack',
                'brand' => 'QuickFix Tools',
                'categories' => ['Tools & Equipment', 'Automotive'],
            ],
            [
                'name' => 'All-Season Radial Tire (17 inch)',
                'brand' => 'QuickFix Tools',
                'categories' => ['Tires & Wheels', 'Automotive'],
            ],
            [
                'name' => 'Premium Car Wash Kit',
                'brand' => 'QuickFix Tools',
                'categories' => ['Exterior Parts', 'Automotive'],
            ],
            [
                'name' => 'Smartphone Car Mount',
                'brand' => 'GadgetGlide',
                'categories' => ['Interior Accessories', 'Automotive'],
            ],
            [
                'name' => 'Dash Cam with Parking Monitor',
                'brand' => 'GadgetGlide',
                'categories' => ['Interior Accessories', 'Automotive'],
            ],
            [
                'name' => 'LED Headlight Conversion Kit',
                'brand' => 'GloBright Lighting',
                'categories' => ['Exterior Parts', 'Automotive'],
            ],
            [
                'name' => 'Car Trunk Organizer',
                'brand' => 'EcoLiving',
                'categories' => ['Interior Accessories', 'Automotive'],
            ],
            [
                'name' => 'The Settlers of Catan Board Game',
                'brand' => 'CreativeCanvas',
                'categories' => ['Board Games', 'Toys & Games'],
            ],
            [
                'name' => 'Ticket to Ride Europe',
                'brand' => 'CreativeCanvas',
                'categories' => ['Board Games', 'Toys & Games'],
            ],
            [
                'name' => 'Deluxe Building Blocks Set (1000 pcs)',
                'brand' => 'CreativeCanvas',
                'categories' => ['Building Blocks', 'Toys & Games'],
            ],
            [
                'name' => 'Remote Control Race Car',
                'brand' => 'CreativeCanvas',
                'categories' => ['Action Figures', 'Toys & Games'],
            ],
            [
                'name' => 'Superhero Action Figure (8-inch)',
                'brand' => 'CreativeCanvas',
                'categories' => ['Action Figures', 'Toys & Games'],
            ],
            [
                'name' => '3D Wooden Puzzle - Eiffel Tower',
                'brand' => 'CreativeCanvas',
                'categories' => ['Puzzles', 'Toys & Games'],
            ],
            [
                'name' => '1000 Piece Jigsaw Puzzle - Mountain Landscape',
                'brand' => 'CreativeCanvas',
                'categories' => ['Puzzles', 'Toys & Games'],
            ],
            [
                'name' => 'Baby Doll with Accessories',
                'brand' => 'CreativeCanvas',
                'categories' => ['Dolls & Playsets', 'Toys & Games'],
            ],
            [
                'name' => 'Kids Play Kitchen Set',
                'brand' => 'CreativeCanvas',
                'categories' => ['Dolls & Playsets', 'Toys & Games'],
            ],
            [
                'name' => 'Strategy Card Game: Dominion',
                'brand' => 'CreativeCanvas',
                'categories' => ['Board Games', 'Toys & Games'],
            ],
            [
                'name' => 'Large Building Baseplate',
                'brand' => 'CreativeCanvas',
                'categories' => ['Building Blocks', 'Toys & Games'],
            ],
            [
                'name' => 'Educational Robot Kit',
                'brand' => 'GadgetGlide',
                'categories' => ['Building Blocks', 'Toys & Games', 'Electronics'],
            ],
            [
                'name' => 'Flying Mini Drone for Kids',
                'brand' => 'GadgetGlide',
                'categories' => ['Drones', 'Toys & Games', 'Electronics'],
            ],
            [
                'name' => 'Plush Toy Unicorn',
                'brand' => 'Aura Apparel',
                'categories' => ['Dolls & Playsets', 'Toys & Games'],
            ],
            [
                'name' => 'Classic Checkers & Chess Set',
                'brand' => 'Bookworm Press',
                'categories' => ['Board Games', 'Toys & Games'],
            ],
        ];

        foreach ($specificProducts as $productData) {
            $brandId = $brands->get($productData['brand'])?->id;

            if (is_null($brandId)) {
                $this->command->warn("Skipping product '{$productData['name']}' because brand '{$productData['brand']}' not found. Please ensure all brands are seeded.");
                continue;
            }

            $product = Product::factory()->create([
                'name' => $productData['name'],
                'brand_id' => $brandId,
            ]);

            $categoryIds = [];
            foreach ($productData['categories'] as $catName) {
                $categoryId = $categories->get($catName)?->id;
                if ($categoryId) {
                    $categoryIds[] = $categoryId;
                } else {
                    $this->command->warn("Category '{$catName}' not found for product '{$productData['name']}'. Please ensure all categories are seeded.");
                }
            }

            if (!empty($categoryIds)) {
                $product->categories()->attach($categoryIds);
            }
        }

        $this->command->info('Specific product data seeded successfully.');
    }
}
