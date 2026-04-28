<?php

declare(strict_types=1);

namespace WpEcommerceApi;

use WpEcommerceApi\Repositories\UserRepository;
use WpEcommerceApi\Services\UserService;
use WpEcommerceApi\Controllers\UserController;
use WpEcommerceApi\Routes\UserRoutes;

use WpEcommerceApi\Repositories\ProductRepository;
use WpEcommerceApi\Services\ProductService;
use WpEcommerceApi\Controllers\ProductController;
use WpEcommerceApi\Routes\ProductRoutes;

use WpEcommerceApi\Repositories\TransactionRepository;
use WpEcommerceApi\Services\TransactionService;
use WpEcommerceApi\Controllers\TransactionController;
use WpEcommerceApi\Routes\TransactionRoutes;

final class App {

    public static function init(): void {
        add_action('rest_api_init', [self::class, 'registerRoutes']);
    }

    public static function registerRoutes(): void {
        global $wpdb;

        $userRepository = new UserRepository();
        $userService    = new UserService($userRepository);
        $userController = new UserController($userService);
        UserRoutes::register($userController);

        $productRepository = new ProductRepository($wpdb);
        $productService    = new ProductService($productRepository);
        $productController = new ProductController($productService);
        ProductRoutes::register($productController);

        $transactionRepository = new TransactionRepository($wpdb);
        $transactionService    = new TransactionService($transactionRepository, $productRepository);
        $transactionController = new TransactionController($transactionService);
        TransactionRoutes::register($transactionController);
    }
}