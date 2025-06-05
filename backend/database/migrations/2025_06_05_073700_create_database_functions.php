<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // FUNCIÓN 1: Calcular el total de un carrito
        DB::unprepared("
            CREATE OR REPLACE FUNCTION calculate_cart_total(cart_id BIGINT)
            RETURNS NUMERIC(10,2) AS $$
            DECLARE
                total NUMERIC(10,2) := 0;
            BEGIN
                SELECT COALESCE(SUM(ci.quantity * p.price), 0)
                INTO total
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.cart_id = cart_id;

                RETURN total;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // FUNCIÓN 2: Obtener stock disponible de un producto
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_available_stock(prod_id BIGINT)
            RETURNS INT AS $$
            DECLARE
                available_stock INT := 0;
            BEGIN
                SELECT COALESCE(SUM(quantity - reserved_quantity), 0)
                INTO available_stock
                FROM inventories
                WHERE product_id = prod_id AND quantity > reserved_quantity;

                RETURN available_stock;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // FUNCIÓN 3: Calcular el margen de ganancia de un producto
        DB::unprepared("
            CREATE OR REPLACE FUNCTION calculate_product_margin(prod_id BIGINT)
            RETURNS NUMERIC(5,2) AS $$
            DECLARE
                selling_price NUMERIC(10,2);
                min_cost NUMERIC(10,2);
                margin_percentage NUMERIC(5,2) := 0;
            BEGIN
                SELECT price INTO selling_price
                FROM products
                WHERE id = prod_id;

                SELECT MIN(cost_price) INTO min_cost
                FROM product_supplier
                WHERE product_id = prod_id;

                IF selling_price IS NOT NULL AND min_cost IS NOT NULL AND min_cost > 0 THEN
                    margin_percentage := ((selling_price - min_cost) / min_cost) * 100;
                END IF;

                RETURN margin_percentage;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // FUNCIÓN 4: Contar productos activos por marca
        DB::unprepared("
            CREATE OR REPLACE FUNCTION count_active_products_by_brand(brand_id BIGINT)
            RETURNS INT AS $$
            DECLARE
                product_count INT := 0;
            BEGIN
                SELECT COUNT(*) INTO product_count
                FROM products
                WHERE brand_id = brand_id AND is_active = TRUE;

                RETURN product_count;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // FUNCIÓN 5: Obtener el proveedor primario de un producto
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_primary_supplier_name(prod_id BIGINT)
            RETURNS VARCHAR AS $$
            DECLARE
                supplier_name VARCHAR := 'Sin proveedor primario';
            BEGIN
                SELECT s.name INTO supplier_name
                FROM suppliers s
                JOIN product_supplier ps ON s.id = ps.supplier_id
                WHERE ps.product_id = prod_id AND ps.is_primary = TRUE
                ORDER BY ps.id
                LIMIT 1;

                RETURN COALESCE(supplier_name, 'Sin proveedor primario');
            END;
            $$ LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS calculate_cart_total(BIGINT)");
        DB::unprepared("DROP FUNCTION IF EXISTS get_available_stock(BIGINT)");
        DB::unprepared("DROP FUNCTION IF EXISTS calculate_product_margin(BIGINT)");
        DB::unprepared("DROP FUNCTION IF EXISTS count_active_products_by_brand(BIGINT)");
        DB::unprepared("DROP FUNCTION IF EXISTS get_primary_supplier_name(BIGINT)");
    }
};
