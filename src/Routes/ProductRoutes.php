<?php

declare(strict_types=1);

namespace WpEcommerceApi\Routes;

use WpEcommerceApi\Controllers\ProductController;

final class ProductRoutes {

    public static function register(ProductController $controller): void {
        register_rest_route('api/v1', '/products', [
            [
                'methods'             => 'GET',
                'callback'            => [$controller, 'list'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => 'POST',
                'callback'            => [$controller, 'create'],
                'permission_callback' => 'is_user_logged_in',
            ]
        ]);

        register_rest_route('api/v1', '/products/(?P<id>\d+)', [
            [
                'methods'             => 'GET',
                'callback'            => [$controller, 'getOne'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => 'DELETE',
                'callback'            => [$controller, 'delete'],
                'permission_callback' => 'is_user_logged_in',
            ]
        ]);
    }
}