<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNull();
            $table->string('email')->unique()->notNull();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(false);
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->notNull();
            $table->text('description')->nullable();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNull();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->notNull();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNull();
            $table->string('email')->unique()->notNull();
            $table->string('phone')->notNull();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNull();
            $table->string('location')->notNull();
            $table->string('manager_name')->notNull();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street')->notNull();
            $table->string('city')->notNull();
            $table->string('postal_code')->notNull();
            $table->string('country')->notNull();
            $table->unique(['street', 'city', 'postal_code', 'country']);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNull();
            $table->text('description')->notNull();
            $table->decimal('price', 10, 2)->notNull();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('active');
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);

            $table->index(['user_id', 'status']);
        });


        Schema::create('address_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type')->notNull();
            $table->boolean('is_default')->default(false);
            $table->unique(['address_id', 'user_id']);
        });

        Schema::create('address_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->unique(['address_id', 'supplier_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->unique(['user_id', 'role_id']);
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->unique(['product_id', 'category_id']);
        });

        Schema::create('product_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->decimal('cost_price', 10, 2)->notNull();
            $table->boolean('is_primary')->default(false);
            $table->unique(['product_id', 'supplier_id']);
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->integer('quantity')->notNull()->default(0);
            $table->unique(['product_id', 'warehouse_id']);
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->notNull()->default(1);
            $table->decimal('unit_price', 10, 2)->notNull();
            $table->unique(['cart_id', 'product_id']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->string('status')->notNull();
            $table->text('notes')->nullable();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating')->notNull();
            $table->text('comment')->notNull();
            $table->boolean('is_approved')->default(true);
            $table->unique(['product_id', 'user_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                  ->references('id')->on('categories')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('product_supplier');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('address_user');
        Schema::dropIfExists('address_supplier');
        Schema::dropIfExists('addresses');
        Schema::table('categories', function (Blueprint $table) {
             $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists('categories');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('users');
    }
};
