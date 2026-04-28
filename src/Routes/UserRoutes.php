<?php

declare(strict_types=1);

namespace WpEcommerceApi\Routes;

use WpEcommerceApi\Controllers\UserController;

final class UserRoutes {

    public static function register(UserController $controller): void {
        register_rest_route('api/v1', '/users/register', [
            'methods'             => 'POST',
            'callback'            => [$controller, 'register'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('api/v1', '/users/me', [
            [
                'methods'             => 'GET',
                'callback'            => [$controller, 'getProfile'],
                'permission_callback' => 'is_user_logged_in',
            ],
            [
                'methods'             => 'PUT',
                'callback'            => [$controller, 'updateProfile'],
                'permission_callback' => 'is_user_logged_in',
            ]
        ]);
    }
}