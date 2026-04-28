<?php

declare(strict_types=1);

namespace WpEcommerceApi\Http;

use WP_REST_Response;

final class ApiResponse {

    public static function success(mixed $data = null, string $message = '', int $status = 200): WP_REST_Response {
        return new WP_REST_Response([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], $status);
    }

    public static function error(string $message = '', mixed $data = null, int $status = 400): WP_REST_Response {
        return new WP_REST_Response([
            'success' => false,
            'data'    => $data,
            'message' => $message,
        ], $status);
    }

    public static function created(mixed $data = null): WP_REST_Response {
        return self::success($data, 'Created successfully', 201);
    }

    public static function paginated(array $data, int $totalCount, int $status = 200): WP_REST_Response {
        $response = self::success($data, '', $status);
        
        $response->header('X-Total-Count', (string) $totalCount);
        
        return $response;
    }
}