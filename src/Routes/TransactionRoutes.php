<?php

declare(strict_types=1);

namespace WpEcommerceApi\Routes;

use WpEcommerceApi\Controllers\TransactionController;

final class TransactionRoutes {

    public static function register(TransactionController $controller): void {
        register_rest_route('api/v1', '/transactions', [
            'methods'             => 'POST',
            'callback'            => [$controller, 'checkout'],
            'permission_callback' => 'is_user_logged_in',
        ]);

        register_rest_route('api/v1', '/transactions/purchases', [
            'methods'             => 'GET',
            'callback'            => [$controller, 'myPurchases'],
            'permission_callback' => 'is_user_logged_in',
        ]);

        register_rest_route('api/v1', '/transactions/sales', [
            'methods'             => 'GET',
            'callback'            => [$controller, 'mySales'],
            'permission_callback' => 'is_user_logged_in',
        ]);
    }
}