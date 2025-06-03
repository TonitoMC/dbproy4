<?php

namespace Database\Seeders;

use App\Models\Address;        // FIXED: Backslashes
use App\Models\AddressUser;     // FIXED: Backslashes
use App\Models\AddressSupplier; // FIXED: Backslashes
use App\Models\Cart;            // FIXED: Backslashes
use App\Models\CartItem;        // FIXED: Backslashes
use App\Models\Inventory;       // FIXED: Backslashes
use App\Models\Order;           // FIXED: Backslashes
use App\Models\Product;         // FIXED: Backslashes
use App\Models\Review;          // FIXED: Backslashes
use App\Models\User;            // FIXED: Backslashes
use App\Models\Supplier;        // FIXED: Backslashes
use App\Models\Warehouse;       // FIXED: Backslashes
use App\Models\Role;            // FIXED: Backslashes
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // FIXED: Backslashes
use Illuminate\Database\Seeder; // FIXED: Backslashes
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class RelationalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding relational data...');

        $faker = app(\Faker\Generator::class);

        $users = User::all();
        $roles = Role::all();
        $products = Product::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();


        $this->command->info('Seeding Addresses and Address Junctions...');

        $genericAddresses = [];
        for ($i = 0; $i < 50; $i++) {
            $genericAddresses[] = Address::create([
                'street' => $faker->unique()->streetAddress(),
                'city' => $faker->city(),
                'postal_code' => $faker->postcode(),
                'country' => $faker->country(),
            ]);
        }
        $genericAddresses = collect($genericAddresses);

        $users->each(function ($user) use ($genericAddresses, $faker) {
            $numAddresses = rand(1, 2);
            $assignedAddresses = $genericAddresses->random($numAddresses);
            $typeOptions = ['Shipping', 'Billing', 'Home', 'Work'];
            $defaultSet = false;

            $typesUsedForUser = [];

            foreach ($assignedAddresses as $address) {
                $availableTypes = array_diff($typeOptions, $typesUsedForUser);
                $type = !empty($availableTypes) ? $faker->randomElement($availableTypes) : $faker->randomElement($typeOptions); // Fallback if all types used
                $typesUsedForUser[] = $type;

                $isDefault = false;
                if (!$defaultSet) {
                    if ($faker->boolean(70)) {
                        $isDefault = true;
                        $defaultSet = true;
                    } elseif (count($assignedAddresses) == 1 || ($assignedAddresses->last()->is($address) && $faker->boolean(50))) {
                        $isDefault = true;
                        $defaultSet = true;
                    }
                }

                AddressUser::create([
                    'address_id' => $address->id,
                    'user_id' => $user->id,
                    'type' => $type,
                    'is_default' => $isDefault,
                ]);
            }
        });

        $suppliers->each(function ($supplier) use ($genericAddresses, $faker) {
            $address = $faker->randomElement($genericAddresses);
            if (!AddressSupplier::where('supplier_id', $supplier->id)->where('address_id', $address->id)->exists()) {
                AddressSupplier::create([
                    'address_id' => $address->id,
                    'supplier_id' => $supplier->id,
                ]);
            }
        });


        $this->command->info('Seeding Inventories...');
        $products->each(function ($product) use ($warehouses, $faker) {
            Inventory::factory()->create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouses->random()->id,
                'quantity' => $faker->numberBetween(10, 100),
            ]);
        });


        $this->command->info('Seeding Carts and Cart Items...');
        $users->each(function ($user) use ($products, $faker) {
            Cart::factory()->count(rand(1, 2))->create(['user_id' => $user->id])->each(function ($cart) use ($products, $faker) {
                $productsInCartCount = rand(1, min(5, $products->count()));
                $productsInCart = $products->random($productsInCartCount);

                foreach ($productsInCart as $product) {
                    CartItem::factory()->create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 2),
                        'unit_price' => $product->price,
                    ]);
                }
            });
        });


        $this->command->info('Seeding Orders...');
        $totalCarts = Cart::count();
        if ($totalCarts > 0) {
            $cartsToConvertCount = round($totalCarts * $faker->randomFloat(1, 0.4, 0.7));
            Cart::inRandomOrder()->take($cartsToConvertCount)->update(['status' => 'converted']);
        }

        Cart::where('status', 'converted')->get()->each(function ($cart) use ($faker) {
            if (!Order::where('cart_id', $cart->id)->exists()) {
                 Order::factory()->create([
                    'user_id' => $cart->user_id,
                    'cart_id' => $cart->id,
                    'status' => $faker->randomElement(['shipped', 'delivered', 'pending', 'processing']),
                ]);
            }
        });


        $this->command->info('Seeding Reviews...');
        $reviewingUsers = $users->random(round($users->count() * 0.3));
        $reviewingUsers->each(function ($user) use ($products, $faker) {
            $productsToReview = $products->random(rand(1, min(3, $products->count())));
            foreach ($productsToReview as $product) {
                if (!Review::where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
                    Review::factory()->create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                    ]);
                }
            }
        });

        $this->command->info('Seeding Pivot Tables: role_user, product_supplier, category_product...');

        $users->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1, min(2, $roles->count())))->pluck('id')->toArray()
            );
        });

        $products->each(function ($product) use ($suppliers, $faker) {
            $productSuppliers = $suppliers->random(rand(1, min(2, $suppliers->count())));
            foreach ($productSuppliers as $supplier) {
                if (!$product->suppliers->contains($supplier)) {
                    $product->suppliers()->attach(
                        $supplier->id,
                        ['cost_price' => $faker->randomFloat(2, $product->price * 0.5, $product->price * 0.9), 'is_primary' => $faker->boolean(20)]
                    );
                }
            }
        });

        $this->command->info('Relational data seeding complete.');
    }
}
