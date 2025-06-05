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
        // VISTA 1: Resumen de productos con información completa
        DB::unprepared("
            CREATE VIEW product_summary AS
            SELECT 
                p.id,
                p.name AS product_name,
                p.description,
                p.price,
                p.is_active,
                b.name AS brand_name,
                b.id AS brand_id,
                get_primary_supplier_name(p.id) AS primary_supplier,
                calculate_product_margin(p.id) AS margin_percentage,
                get_available_stock(p.id) AS available_stock,
                STRING_AGG(DISTINCT c.name, ', ') AS categories
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN category_product cp ON p.id = cp.product_id
            LEFT JOIN categories c ON cp.category_id = c.id
            GROUP BY p.id, p.name, p.description, p.price, p.is_active, b.name, b.id
        ");

        // VISTA 2: Dashboard de inventario
        DB::unprepared("
            CREATE VIEW inventory_dashboard AS
            SELECT 
                p.id AS product_id,
                p.name AS product_name,
                b.name AS brand_name,
                SUM(i.quantity) AS total_quantity,
                SUM(i.reserved_quantity) AS total_reserved,
                SUM(i.quantity - i.reserved_quantity) AS available_quantity,
                COUNT(i.id) AS warehouse_locations,
                AVG(ps.cost_price) AS avg_cost_price,
                p.price AS selling_price,
                calculate_product_margin(p.id) AS margin_percentage
            FROM products p
            LEFT JOIN inventories i ON p.id = i.product_id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN product_supplier ps ON p.id = ps.product_id
            WHERE p.is_active = true
            GROUP BY p.id, p.name, b.name, p.price
        ");

        // VISTA 3: Análisis de usuarios activos
        DB::unprepared("
            CREATE VIEW active_users_analysis AS
            SELECT 
                u.id,
                u.name,
                u.email,
                u.is_active,
                COUNT(DISTINCT c.id) AS total_carts,
                COUNT(DISTINCT o.id) AS total_orders,
                COUNT(DISTINCT r.id) AS total_reviews,
                COALESCE(SUM(calculate_cart_total(c.id)), 0) AS total_cart_value,
                (
                    SELECT COUNT(*) FROM cart_items ci 
                    JOIN carts c2 ON ci.cart_id = c2.id 
                    WHERE c2.user_id = u.id
                ) AS total_cart_items,
                STRING_AGG(DISTINCT role.name, ', ') AS user_roles
            FROM users u
            LEFT JOIN carts c ON u.id = c.user_id
            LEFT JOIN orders o ON u.id = o.user_id
            LEFT JOIN reviews r ON u.id = r.user_id
            LEFT JOIN role_user ru ON u.id = ru.user_id
            LEFT JOIN roles role ON ru.role_id = role.id
            GROUP BY u.id, u.name, u.email, u.is_active
        ");

        // VISTA 4: Reporte de ventas por marca
        DB::unprepared("
            CREATE VIEW brand_sales_report AS
            SELECT 
                b.id AS brand_id,
                b.name AS brand_name,
                COUNT(DISTINCT p.id) AS total_products,
                count_active_products_by_brand(b.id) AS active_products,
                COUNT(DISTINCT ci.id) AS total_cart_items,
                SUM(ci.quantity) AS total_quantity_sold,
                AVG(p.price) AS avg_product_price,
                MIN(p.price) AS min_product_price,
                MAX(p.price) AS max_product_price,
                SUM(ci.quantity * p.price) AS total_revenue
            FROM brands b
            LEFT JOIN products p ON b.id = p.brand_id
            LEFT JOIN cart_items ci ON p.id = ci.product_id
            GROUP BY b.id, b.name
        ");

        // VISTA 5: Stock crítico (productos con poco inventario)
        DB::unprepared("
            CREATE VIEW critical_stock_alert AS
            SELECT 
                p.id AS product_id,
                p.name AS product_name,
                b.name AS brand_name,
                get_available_stock(p.id) AS available_stock,
                SUM(i.reserved_quantity) AS reserved_stock,
                SUM(i.quantity) AS total_stock,
                get_primary_supplier_name(p.id) AS primary_supplier,
                CASE 
                    WHEN get_available_stock(p.id) = 0 THEN 'SIN_STOCK'
                    WHEN get_available_stock(p.id) <= 5 THEN 'CRITICO'
                    WHEN get_available_stock(p.id) <= 10 THEN 'BAJO'
                    ELSE 'NORMAL'
                END AS stock_status
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN inventories i ON p.id = i.product_id
            WHERE p.is_active = true
            GROUP BY p.id, p.name, b.name
            HAVING get_available_stock(p.id) <= 10
            ORDER BY available_stock ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS product_summary");
        DB::unprepared("DROP VIEW IF EXISTS inventory_dashboard");
        DB::unprepared("DROP VIEW IF EXISTS active_users_analysis");
        DB::unprepared("DROP VIEW IF EXISTS brand_sales_report");
        DB::unprepared("DROP VIEW IF EXISTS critical_stock_alert");
    }
};