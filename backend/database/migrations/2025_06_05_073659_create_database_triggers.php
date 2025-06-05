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
        // TRIGGER 1: Actualizar stock en inventario cuando se agrega/modifica un CartItem
        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_insert
            AFTER INSERT ON cart_items
            FOR EACH ROW
            BEGIN
                UPDATE inventories 
                SET reserved_quantity = reserved_quantity + NEW.quantity
                WHERE product_id = NEW.product_id;
            END
        ");

        // TRIGGER 2: Actualizar stock cuando se elimina un CartItem
        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_delete
            AFTER DELETE ON cart_items
            FOR EACH ROW
            BEGIN
                UPDATE inventories 
                SET reserved_quantity = reserved_quantity - OLD.quantity
                WHERE product_id = OLD.product_id;
            END
        ");

        // TRIGGER 3: Actualizar stock cuando se modifica la cantidad en CartItem
        DB::unprepared("
            CREATE TRIGGER update_inventory_on_cart_item_update
            AFTER UPDATE ON cart_items
            FOR EACH ROW
            BEGIN
                IF NEW.quantity != OLD.quantity THEN
                    UPDATE inventories 
                    SET reserved_quantity = reserved_quantity - OLD.quantity + NEW.quantity
                    WHERE product_id = NEW.product_id;
                END IF;
            END
        ");

        // TRIGGER 4: Actualizar fecha de última actividad del usuario
        DB::unprepared("
            CREATE TRIGGER update_user_last_activity_on_order
            AFTER INSERT ON orders
            FOR EACH ROW
            BEGIN
                UPDATE users 
                SET updated_at = NOW()
                WHERE id = NEW.user_id;
            END
        ");

        // TRIGGER 5: Validar que el precio de venta sea mayor al costo
        DB::unprepared("
            CREATE TRIGGER validate_product_price_before_insert
            BEFORE INSERT ON products
            FOR EACH ROW
            BEGIN
                DECLARE min_cost DECIMAL(10,2);
                
                SELECT MIN(cost_price) INTO min_cost
                FROM product_supplier 
                WHERE product_id = NEW.id;
                
                IF min_cost IS NOT NULL AND NEW.price < min_cost THEN
                    SIGNAL SQLSTATE '45000' 
                    SET MESSAGE_TEXT = 'El precio de venta no puede ser menor al costo más bajo';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS update_inventory_on_cart_item_update");
        DB::unprepared("DROP TRIGGER IF EXISTS update_user_last_activity_on_order");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_product_price_before_insert");
    }
};