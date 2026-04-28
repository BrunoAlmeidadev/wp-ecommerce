<?php

declare(strict_types=1);

namespace WpEcommerceApi\Controllers;

use WpEcommerceApi\Services\TransactionService;
use WpEcommerceApi\DTOs\TransactionCreateDTO;
use WpEcommerceApi\Http\ApiResponse;
use WP_REST_Request;
use WP_REST_Response;
use Exception;

final class TransactionController {

    public function __construct(private readonly TransactionService $service) {}

    public function checkout(WP_REST_Request $request): WP_REST_Response {
        try {
            $buyerId = get_current_user_id();
            $address = $request->get_param('shippingAddress');

            if (!is_array($address)) {
                throw new Exception('Invalid shipping address format.');
            }

            $dto = new TransactionCreateDTO(
                $buyerId,
                (int) $request->get_param('productId'),
                $address
            );

            $transactionId = $this->service->checkout($dto);

            return ApiResponse::created(['transactionId' => $transactionId]);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 400);
        }
    }

    public function myPurchases(WP_REST_Request $request): WP_REST_Response {
        try {
            $userId = get_current_user_id();
            $history = $this->service->getBuyerHistory($userId);

            return ApiResponse::success($history);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 500);
        }
    }

    public function mySales(WP_REST_Request $request): WP_REST_Response {
        try {
            $userId = get_current_user_id();
            $history = $this->service->getSellerHistory($userId);

            return ApiResponse::success($history);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 500);
        }
    }
}