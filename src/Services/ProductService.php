<?php

declare(strict_types=1);

namespace WpEcommerceApi\Services;

use WpEcommerceApi\DTOs\ProductCreateDTO;
use WpEcommerceApi\Repositories\ProductRepository;
use Exception;

final class ProductService {

    public function __construct(private readonly ProductRepository $repository) {}

    public function createProduct(ProductCreateDTO $dto): object {
        $productId = $this->repository->create($dto);
        return $this->getProductById($productId);
    }

    public function getProductById(int $id): object {
        $product = $this->repository->getById($id);

        if (!$product) {
            throw new Exception('Product not found.');
        }

        return $this->formatProductOutput($product);
    }

    public function listProducts(int $page, int $limit, string $search, int $sellerId): array {
        $result = $this->repository->listProducts($page, $limit, $search, $sellerId);

        $formattedData = array_map(function($product) {
            return $this->formatProductOutput($product);
        }, $result['data']);

        return [
            'data'  => $formattedData,
            'total' => $result['total']
        ];
    }

    public function deleteProduct(int $productId, int $currentUserId): void {
        $product = $this->repository->getById($productId);

        if (!$product) {
            throw new Exception('Product not found.');
        }

        if ((int) $product->seller_id !== $currentUserId) {
            throw new Exception('You do not have permission to delete this product.');
        }

        $imageIds = $this->repository->getImagesIds($productId);

        foreach ($imageIds as $attachmentId) {
            wp_delete_attachment($attachmentId, true);
        }

        $this->repository->delete($productId);
    }

    public function uploadImages(): array {
        if (empty($_FILES)) {
            return [];
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $uploadedIds = [];

        foreach ($_FILES as $key => $file) {
            $attachmentId = media_handle_upload($key, 0);

            if (!is_wp_error($attachmentId)) {
                $uploadedIds[] = (int) $attachmentId;
            }
        }

        return $uploadedIds;
    }

    private function formatProductOutput(object $product): object {
        $formattedImages = [];

        if (!empty($product->images)) {
            foreach ($product->images as $img) {
                $formattedImages[] = [
                    'id'    => (int) $img->wp_attachment_id,
                    'url'   => wp_get_attachment_image_url((int) $img->wp_attachment_id, 'large'),
                    'order' => (int) $img->image_order
                ];
            }
        }

        $product->images = $formattedImages;
        return $product;
    }
}