<?php

declare(strict_types=1);

namespace WpEcommerceApi\Database;

final class Migrations {

    public static function createTables(): void {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $queries = [];

        $tableProducts = $wpdb->prefix . 'ec_products';
        $queries[] = "CREATE TABLE $tableProducts (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            seller_id bigint(20) UNSIGNED NOT NULL,
            name varchar(255) NOT NULL,
            description text NOT NULL,
            price decimal(10,2) NOT NULL DEFAULT '0.00',
            status varchar(20) NOT NULL DEFAULT 'available',
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY seller_id (seller_id)
        ) $charsetCollate;";

        $tableImages = $wpdb->prefix . 'ec_product_images';
        $queries[] = "CREATE TABLE $tableImages (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id bigint(20) UNSIGNED NOT NULL,
            wp_attachment_id bigint(20) UNSIGNED NOT NULL,
            image_order int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY  (id),
            KEY product_id (product_id)
        ) $charsetCollate;";

        $tableTransactions = $wpdb->prefix . 'ec_transactions';
        $queries[] = "CREATE TABLE $tableTransactions (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            buyer_id bigint(20) UNSIGNED NOT NULL,
            seller_id bigint(20) UNSIGNED NOT NULL,
            product_id bigint(20) UNSIGNED NOT NULL,
            shipping_address json NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY buyer_id (buyer_id),
            KEY seller_id (seller_id),
            KEY product_id (product_id)
        ) $charsetCollate;";

        foreach ($queries as $query) {
            dbDelta($query);
        }
    }
}