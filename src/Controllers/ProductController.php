<?php

declare(strict_types=1);

namespace WpEcommerceApi\Controllers;

use WpEcommerceApi\Services\ProductService;
use WpEcommerceApi\DTOs\ProductCreateDTO;
use WpEcommerceApi\Http\ApiResponse;
use WP_REST_Request;
use WP_REST_Response;
use Exception;

final class ProductController {

    public function __construct(private readonly ProductService $service) {}

    public function create(WP_REST_Request $request): WP_REST_Response {
        try {
            $sellerId = get_current_user_id();
            
            $imageIds = $this->service->uploadImages();

            $dto = new ProductCreateDTO(
                $sellerId,
                sanitize_text_field($request->get_param('name') ?? ''),
                (float) ($request->get_param('price') ?? 0),
                sanitize_textarea_field($request->get_param('description') ?? ''),
                $imageIds
            );

            $product = $this->service->createProduct($dto);

            return ApiResponse::created($product);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 500);
        }
    }

    public function list(WP_REST_Request $request): WP_REST_Response {
        try {
            $page     = (int) ($request->get_param('page') ?? 1);
            $limit    = (int) ($request->get_param('limit') ?? 10);
            $search   = sanitize_text_field($request->get_param('q') ?? '');
            $sellerId = (int) ($request->get_param('sellerId') ?? 0);

            $result = $this->service->listProducts($page, $limit, $search, $sellerId);

            return ApiResponse::paginated($result['data'], $result['total']);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 500);
        }
    }

    public function getOne(WP_REST_Request $request): WP_REST_Response {
        try {
            $id = (int) $request->get_param('id');
            $product = $this->service->getProductById($id);

            return ApiResponse::success($product);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 404);
        }
    }

    public function delete(WP_REST_Request $request): WP_REST_Response {
        try {
            $id = (int) $request->get_param('id');
            $currentUserId = get_current_user_id();

            $this->service->deleteProduct($id, $currentUserId);

            return ApiResponse::success(null, 'Product deleted successfully.');
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 403);
        }
    }
}