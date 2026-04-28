<?php
/**
 * Plugin Name: WP E-commerce API
 * Description: API RESTful moderna e escalável para e-commerce. Abandona os CPTs em favor de tabelas relacionais customizadas de alta performance.
 * Version: 1.0.0
 * Author: Bruno Almeida
 * Author URI: https://github.com/BrunoAlmeidadev
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use WpEcommerceApi\App;
use WpEcommerceApi\Database\Migrations;

register_activation_hook(__FILE__, [Migrations::class, 'createTables']);

add_action('plugins_loaded', [App::class, 'init']);