<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // FUNCTION para insertar/modificar cart_items
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_update_inventory_on_cart_item_insert()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE inventories
                SET reserved_quantity = reserved_quantity + NEW.quantity
                WHERE product_id = NEW.product_id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_insert
            AFTER INSERT ON cart_items
            FOR EACH ROW
            EXECUTE FUNCTION fn_update_inventory_on_cart_item_insert();
        ");

        // FUNCTION para eliminar cart_items
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_update_inventory_on_cart_item_delete()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE inventories
                SET reserved_quantity = reserved_quantity - OLD.quantity
                WHERE product_id = OLD.product_id;
                RETURN OLD;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_delete
            AFTER DELETE ON cart_items
            FOR EACH ROW
            EXECUTE FUNCTION fn_update_inventory_on_cart_item_delete();
        ");

        // FUNCTION para actualizar cart_items
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_update_inventory_on_cart_item_update()
            RETURNS TRIGGER AS $$
            BEGIN
                IF NEW.quantity != OLD.quantity THEN
                    UPDATE inventories
                    SET reserved_quantity = reserved_quantity - OLD.quantity + NEW.quantity
                    WHERE product_id = NEW.product_id;
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_update
            AFTER UPDATE ON cart_items
            FOR EACH ROW
            EXECUTE FUNCTION fn_update_inventory_on_cart_item_update();
        ");

        // FUNCTION para actualizar updated_at del usuario al hacer pedido
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_update_user_last_activity_on_order()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE users
                SET updated_at = CURRENT_TIMESTAMP
                WHERE id = NEW.user_id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER update_user_last_activity_on_order
            AFTER INSERT ON orders
            FOR EACH ROW
            EXECUTE FUNCTION fn_update_user_last_activity_on_order();
        ");

        // FUNCTION para validar precio antes de insertar producto
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_validate_product_price_before_insert()
            RETURNS TRIGGER AS $$
            DECLARE
                min_cost NUMERIC(10,2);
            BEGIN
                SELECT MIN(cost_price) INTO min_cost
                FROM product_supplier
                WHERE product_id = NEW.id;

                IF min_cost IS NOT NULL AND NEW.price < min_cost THEN
                    RAISE EXCEPTION 'El precio de venta no puede ser menor al costo más bajo';
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER validate_product_price_before_insert
            BEFORE INSERT ON products
            FOR EACH ROW
            EXECUTE FUNCTION fn_validate_product_price_before_insert();
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_insert ON cart_items");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_update_inventory_on_cart_item_insert");

        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_delete ON cart_items");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_update_inventory_on_cart_item_delete");

        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_update ON cart_items");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_update_inventory_on_cart_item_update");

        DB::unprepared("DROP TRIGGER IF EXISTS update_user_last_activity_on_order ON orders");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_update_user_last_activity_on_order");

        DB::unprepared("DROP TRIGGER IF EXISTS validate_product_price_before_insert ON products");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_validate_product_price_before_insert");
    }
};