<?php

declare(strict_types=1);

namespace WpEcommerceApi\Repositories;

use WpEcommerceApi\DTOs\TransactionCreateDTO;
use wpdb;
use Exception;

final class TransactionRepository {

    public function __construct(private readonly wpdb $db) {}

    public function create(TransactionCreateDTO $dto, int $sellerId): int {
        $tableName = $this->db->prefix . 'ec_transactions';

        $inserted = $this->db->insert(
            $tableName,
            [
                'buyer_id'         => $dto->buyerId,
                'seller_id'        => $sellerId,
                'product_id'       => $dto->productId,
                'shipping_address' => wp_json_encode($dto->shippingAddress),
                'created_at'       => current_time('mysql')
            ],
            ['%d', '%d', '%d', '%s', '%s']
        );

        if ($inserted === false) {
            throw new Exception('Failed to insert transaction into database.');
        }

        return (int) $this->db->insert_id;
    }

    public function getHistoryByRole(int $userId, string $role): array {
        $tableName = $this->db->prefix . 'ec_transactions';
        $column = $role === 'buyer' ? 'buyer_id' : 'seller_id';

        $query = $this->db->prepare("SELECT * FROM $tableName WHERE $column = %d ORDER BY created_at DESC", $userId);
        $results = $this->db->get_results($query);

        return $results ? $results : [];
    }
}