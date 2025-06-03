<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

// This file takes care of the 'core data' which cannot be easily replicated
// or set to random generated values for it to make sense. This includes warehouses,
// roles, etc.
class CoreDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding core data (approx. 1000 total registries target)...');

        $faker = app(\Faker\Generator::class);

        $this->command->warn('Truncating all tables...');
        DB::statement('TRUNCATE TABLE role_user RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE category_product RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE product_supplier RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE inventories RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE cart_items RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE orders RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE reviews RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE address_user RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE address_supplier RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE carts RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE products RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE addresses RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE users RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE roles RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE brands RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE suppliers RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE warehouses RESTART IDENTITY CASCADE;');
        DB::statement('TRUNCATE TABLE categories RESTART IDENTITY CASCADE;');
        $this->command->info('Tables truncated.');

        $this->command->info('Seeding Predetermined Roles...');
        $rolesData = [
            ['name' => 'Admin', 'description' => 'Full administrative access to the system.'],
            ['name' => 'Customer', 'description' => 'Standard user account for shopping and orders.'],
            ['name' => 'Editor', 'description' => 'Manages products, categories, and content.'],
            ['name' => 'Manager', 'description' => 'Oversees specific departments or functions.'],
            ['name' => 'Support', 'description' => 'Provides customer assistance.'],
            ['name' => 'Guest', 'description' => 'Limited browsing access.'],
        ];
        foreach ($rolesData as $data) {
            Role::create($data);
        }
        $this->command->info('Roles seeded. Count: ' . Role::count());

        $this->command->info('Seeding Predetermined Warehouses...');
        $warehousesData = [
            ['name' => 'Main Distribution Center', 'location' => '123 Global Way, Logistics City, CA', 'manager_name' => 'Alice Johnson', 'is_active' => true],
            ['name' => 'Warehouse Indiana A', 'location' => '456 Industrial Blvd, Indianapolis, IN', 'manager_name' => 'Bob Smith', 'is_active' => true],
            ['name' => 'Regional Hub Texas', 'location' => '789 Trade Lane, Houston, TX', 'manager_name' => 'Carol White', 'is_active' => true],
            ['name' => 'Return Processing Unit', 'location' => '101 Return Drive, Seattle, WA', 'manager_name' => 'David Green', 'is_active' => false],
            ['name' => 'Local Fulfillment NYC', 'location' => '321 Manhattan Ave, New York, NY', 'manager_name' => 'Eva Brown', 'is_active' => true],
            ['name' => 'Northern Storage Depot', 'location' => '876 Northwood Rd, Minneapolis, MN', 'manager_name' => 'Frank Lee', 'is_active' => true],
            ['name' => 'Southeast Logistics Hub', 'location' => '999 South Blvd, Atlanta, GA', 'manager_name' => 'Grace Kim', 'is_active' => true],
            ['name' => 'West Coast Cross-Dock', 'location' => '222 Portside St, Long Beach, CA', 'manager_name' => 'Henry Davis', 'is_active' => true],
            ['name' => 'Central Midwest Facility', 'location' => '333 Heartland Way, Kansas City, MO', 'manager_name' => 'Ivy Chen', 'is_active' => true],
            ['name' => 'East Coast Reserve', 'location' => '444 Seaboard Ave, Boston, MA', 'manager_name' => 'Jack Williams', 'is_active' => false],
        ];
        foreach ($warehousesData as $data) {
            Warehouse::create($data);
        }
        $this->command->info('Warehouses seeded. Count: ' . Warehouse::count());

        $this->command->info('Seeding Predetermined Brands...');
        $brandsData = [
            ['name' => 'TechNova', 'description' => 'Cutting-edge electronics.', 'is_active' => true],
            ['name' => 'Aura Apparel', 'description' => 'Sustainable fashion brand.', 'is_active' => true],
            ['name' => 'KitchenPro', 'description' => 'High-quality kitchenware.', 'is_active' => true],
            ['name' => 'Bookworm Press', 'description' => 'Independent book publisher.', 'is_active' => true],
            ['name' => 'GadgetGlide', 'description' => 'Innovative mobile accessories.', 'is_active' => false],
            ['name' => 'EcoLiving', 'description' => 'Eco-friendly home essentials.', 'is_active' => true],
            ['name' => 'SonicSound', 'description' => 'Premium audio equipment.', 'is_active' => true],
            ['name' => 'PureWater Filters', 'description' => 'Advanced water filtration systems.', 'is_active' => true],
            ['name' => 'UrbanWear Co.', 'description' => 'Modern street fashion.', 'is_active' => true],
            ['name' => 'GreenLeaf Organics', 'description' => 'Organic and natural products.', 'is_active' => true],
            ['name' => 'PowerFit Gear', 'description' => 'Durable fitness equipment.', 'is_active' => true],
            ['name' => 'CreativeCanvas', 'description' => 'Art supplies for all levels.', 'is_active' => true],
            ['name' => 'GloBright Lighting', 'description' => 'Energy-efficient lighting solutions.', 'is_active' => true],
            ['name' => 'QuickFix Tools', 'description' => 'Reliable hand tools for every job.', 'is_active' => true],
            ['name' => 'SleepHaven Mattresses', 'description' => 'Comfort solutions for a perfect sleep.', 'is_active' => false],
        ];
        foreach ($brandsData as $data) {
            Brand::create($data);
        }
        $this->command->info('Brands seeded. Count: ' . Brand::count());

        $this->command->info('Seeding Predetermined Suppliers...');
        $suppliersData = [
            ['name' => 'Global Components Inc.', 'email' => 'contact@globalcomp.com', 'phone' => '1-800-555-0100', 'is_active' => true],
            ['name' => 'Textile Solutions Ltd.', 'email' => 'sales@textilesol.com', 'phone' => '1-800-555-0101', 'is_active' => true],
            ['name' => 'KitchenCraft Supply', 'email' => 'info@kitchencraft.com', 'phone' => '1-800-555-0102', 'is_active' => true],
            ['name' => 'Novelty Nook Distributors', 'email' => 'orders@noveltynook.net', 'phone' => '1-800-555-0103', 'is_active' => true],
            ['name' => 'GreenTech Parts', 'email' => 'support@greentech.org', 'phone' => '1-800-555-0104', 'is_active' => false],
            ['name' => 'Circuit Innovations Corp.', 'email' => 'contact@circuitinnov.com', 'phone' => '1-800-555-0105', 'is_active' => true],
            ['name' => 'HomeGoods Wholesalers', 'email' => 'sales@homegoods.biz', 'phone' => '1-800-555-0106', 'is_active' => true],
            ['name' => 'Apparel Connect', 'email' => 'info@apparelcon.co', 'phone' => '1-800-555-0107', 'is_active' => true],
            ['name' => 'Digital Media Solutions', 'email' => 'support@digimedia.io', 'phone' => '1-800-555-0108', 'is_active' => true],
            ['name' => 'Industrial Fabrication Group', 'email' => 'info@industfab.com', 'phone' => '1-800-555-0109', 'is_active' => true],
            ['name' => 'Raw Materials Express', 'email' => 'sales@rawmat.com', 'phone' => '1-800-555-0110', 'is_active' => true],
            ['name' => 'Logistics Partners United', 'email' => 'contact@logispart.org', 'phone' => '1-800-555-0111', 'is_active' => true],
            ['name' => 'Specialty Chemical Supply', 'email' => 'orders@spec-chem.biz', 'phone' => '1-800-555-0112', 'is_active' => false],
            ['name' => 'Office Essentials Direct', 'email' => 'support@officedirect.net', 'phone' => '1-800-555-0113', 'is_active' => true],
            ['name' => 'Pet Product Purveyors', 'email' => 'info@petpurvey.com', 'phone' => '1-800-555-0114', 'is_active' => true],
        ];
        foreach ($suppliersData as $data) {
            Supplier::create($data);
        }
        $this->command->info('Suppliers seeded. Count: ' . Supplier::count());

        $this->command->info('Seeding Predetermined Categories...');
        $mainCategoriesData = [
            'Electronics' => [
                'description' => 'Devices and gadgets.',
                'subcategories' => ['Smartphones', 'Laptops', 'Audio', 'Gaming', 'Wearables', 'Drones'],
            ],
            'Clothing' => [
                'description' => 'Apparel for all ages.',
                'subcategories' => ['Menswear', 'Womenswear', 'Kids Apparel', 'Footwear', 'Outerwear', 'Activewear'],
            ],
            'Home & Kitchen' => [
                'description' => 'Essentials for home and cooking.',
                'subcategories' => ['Cookware', 'Appliances', 'Decor', 'Furniture', 'Bedding', 'Storage'],
            ],
            'Books' => [
                'description' => 'Written works of all genres.',
                'subcategories' => ['Fiction', 'Non-Fiction', 'Childrens', 'Textbooks', 'Comics', 'Magazines'],
            ],
            'Sports & Outdoors' => [
                'description' => 'Gear for active lifestyles.',
                'subcategories' => ['Camping', 'Cycling', 'Fitness', 'Team Sports', 'Water Sports', 'Winter Sports'],
            ],
            'Health & Beauty' => [
                'description' => 'Products for personal care and wellness.',
                'subcategories' => ['Skincare', 'Haircare', 'Makeup', 'Fragrances', 'Supplements'],
            ],
            'Automotive' => [
                'description' => 'Parts and accessories for vehicles.',
                'subcategories' => ['Exterior Parts', 'Interior Accessories', 'Tools & Equipment', 'Tires & Wheels'],
            ],
            'Toys & Games' => [
                'description' => 'Entertainment for all ages.',
                'subcategories' => ['Board Games', 'Action Figures', 'Puzzles', 'Building Blocks', 'Dolls & Playsets'],
            ],
        ];

        foreach ($mainCategoriesData as $mainName => $data) {
            $mainCat = Category::create([
                'name' => $mainName,
                'description' => $data['description'],
                'is_active' => true,
                'parent_id' => null,
            ]);

            foreach ($data['subcategories'] as $subName) {
                Category::create([
                    'name' => $subName,
                    'description' => 'Subcategory of ' . $mainName,
                    'is_active' => true,
                    'parent_id' => $mainCat->id,
                ]);
            }
        }
        $this->command->info('Categories seeded. Count: ' . Category::count());


        $this->command->info('Seeding General Users...');
        User::factory()->count(75)->create();
        $this->command->info('Users seeded. Count: ' . User::count());

        $this->command->info('Core data seeding complete.');
    }
}
