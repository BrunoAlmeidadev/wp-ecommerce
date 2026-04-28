<?php

declare(strict_types=1);

namespace WpEcommerceApi\Repositories;

use WpEcommerceApi\DTOs\ProductCreateDTO;
use wpdb;
use Exception;

final class ProductRepository {

    public function __construct(private readonly wpdb $db) {}

    public function create(ProductCreateDTO $dto): int {
        $tableName = $this->db->prefix . 'ec_products';

        $inserted = $this->db->insert(
            $tableName,
            [
                'seller_id'   => $dto->sellerId,
                'name'        => $dto->name,
                'description' => $dto->description,
                'price'       => $dto->price,
                'status'      => 'available',
                'created_at'  => current_time('mysql'),
                'updated_at'  => current_time('mysql'),
            ],
            ['%d', '%s', '%s', '%f', '%s', '%s', '%s']
        );

        if ($inserted === false) {
            throw new Exception('Failed to insert product into database.');
        }

        $productId = (int) $this->db->insert_id;

        if (!empty($dto->imageIds)) {
            $this->syncImages($productId, $dto->imageIds);
        }

        return $productId;
    }

    public function getById(int $id): ?object {
        $tableName = $this->db->prefix . 'ec_products';
        $query = $this->db->prepare("SELECT * FROM $tableName WHERE id = %d", $id);
        $product = $this->db->get_row($query);

        if (!$product) {
            return null;
        }

        $product->images = $this->getImagesData($id);
        return $product;
    }

    public function delete(int $id): void {
        $tableName = $this->db->prefix . 'ec_products';
        $imagesTable = $this->db->prefix . 'ec_product_images';

        $this->db->delete($imagesTable, ['product_id' => $id], ['%d']);
        $this->db->delete($tableName, ['id' => $id], ['%d']);
    }

    public function listProducts(int $page = 1, int $limit = 10, string $search = '', int $sellerId = 0): array {
        $tableName = $this->db->prefix . 'ec_products';
        $offset = ($page - 1) * $limit;
        
        $whereFilters = ["status = 'available'"];
        $queryParams = [];

        if ($search !== '') {
            $whereFilters[] = "name LIKE %s";
            $queryParams[] = '%' . $this->db->esc_like($search) . '%';
        }

        if ($sellerId > 0) {
            $whereFilters[] = "seller_id = %d";
            $queryParams[] = $sellerId;
        }

        $whereClause = implode(' AND ', $whereFilters);
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tableName WHERE $whereClause ORDER BY created_at DESC LIMIT %d OFFSET %d";
        
        $queryParams[] = $limit;
        $queryParams[] = $offset;

        $preparedQuery = $this->db->prepare($query, ...$queryParams);
        $products = $this->db->get_results($preparedQuery);
        $totalCount = (int) $this->db->get_var("SELECT FOUND_ROWS()");

        foreach ($products as $product) {
            $product->images = $this->getImagesData((int) $product->id);
        }

        return [
            'data'  => $products,
            'total' => $totalCount
        ];
    }

    public function getImagesIds(int $productId): array {
        $imagesTable = $this->db->prefix . 'ec_product_images';
        $query = $this->db->prepare("SELECT wp_attachment_id FROM $imagesTable WHERE product_id = %d", $productId);
        $results = $this->db->get_col($query);
        
        return array_map('intval', $results);
    }

    private function syncImages(int $productId, array $imageIds): void {
        $imagesTable = $this->db->prefix . 'ec_product_images';
        $this->db->delete($imagesTable, ['product_id' => $productId], ['%d']);

        foreach ($imageIds as $index => $attachmentId) {
            $this->db->insert(
                $imagesTable,
                [
                    'product_id'       => $productId,
                    'wp_attachment_id' => $attachmentId,
                    'image_order'      => $index
                ],
                ['%d', '%d', '%d']
            );
        }
    }

    private function getImagesData(int $productId): array {
        $imagesTable = $this->db->prefix . 'ec_product_images';
        $query = $this->db->prepare(
            "SELECT wp_attachment_id, image_order FROM $imagesTable WHERE product_id = %d ORDER BY image_order ASC",
            $productId
        );
        
        $results = $this->db->get_results($query);
        return $results ? $results : [];
    }

    public function markAsSold(int $id): void {
        $tableName = $this->db->prefix . 'ec_products';
        
        $this->db->update(
            $tableName,
            [
                'status'     => 'sold',
                'updated_at' => current_time('mysql')
            ],
            ['id' => $id],
            ['%s', '%s'],
            ['%d']
        );
    }
}