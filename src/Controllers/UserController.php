<?php

declare(strict_types=1);

namespace WpEcommerceApi\Controllers;

use WpEcommerceApi\Services\UserService;
use WpEcommerceApi\DTOs\UserCreateDTO;
use WpEcommerceApi\DTOs\UserUpdateDTO;
use WpEcommerceApi\Http\ApiResponse;
use WP_REST_Request;
use WP_REST_Response;
use Exception;

final class UserController {

    public function __construct(private readonly UserService $service) {}

    public function register(WP_REST_Request $request): WP_REST_Response {
        try {
            $dto = new UserCreateDTO(
                sanitize_text_field($request->get_param('username') ?? ''),
                sanitize_email($request->get_param('email') ?? ''),
                $request->get_param('password') ?? '',
                sanitize_text_field($request->get_param('firstName') ?? ''),
                sanitize_text_field($request->get_param('lastName') ?? '')
            );

            $userId = $this->service->registerUser($dto);

            return ApiResponse::created(['id' => $userId]);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function getProfile(WP_REST_Request $request): WP_REST_Response {
        try {
            $userId = get_current_user_id();
            $profile = $this->service->getProfile($userId);

            return ApiResponse::success($profile);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 404);
        }
    }

    public function updateProfile(WP_REST_Request $request): WP_REST_Response {
        try {
            $userId = get_current_user_id();
            $password = $request->get_param('password');

            $dto = new UserUpdateDTO(
                $userId,
                sanitize_email($request->get_param('email') ?? ''),
                sanitize_text_field($request->get_param('firstName') ?? ''),
                sanitize_text_field($request->get_param('lastName') ?? ''),
                $password ? (string) $password : null
            );

            $this->service->updateProfile($dto, $userId);

            return ApiResponse::success(null, 'Profile updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 403);
        }
    }
}