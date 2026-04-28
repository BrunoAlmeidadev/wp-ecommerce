<?php

declare(strict_types=1);

namespace WpEcommerceApi\Services;

use WpEcommerceApi\DTOs\TransactionCreateDTO;
use WpEcommerceApi\Repositories\TransactionRepository;
use WpEcommerceApi\Repositories\ProductRepository;
use Exception;

final class TransactionService {

    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly ProductRepository $productRepository
    ) {}

    public function checkout(TransactionCreateDTO $dto): int {
        $product = $this->productRepository->getById($dto->productId);

        if (!$product) {
            throw new Exception('Product not found.');
        }

        if ($product->status !== 'available') {
            throw new Exception('This product is already sold.');
        }

        if ((int) $product->seller_id === $dto->buyerId) {
            throw new Exception('You cannot buy your own product.');
        }

        $transactionId = $this->transactionRepository->create($dto, (int) $product->seller_id);

        $this->productRepository->markAsSold($dto->productId);

        return $transactionId;
    }

    public function getBuyerHistory(int $buyerId): array {
        return $this->transactionRepository->getHistoryByRole($buyerId, 'buyer');
    }

    public function getSellerHistory(int $sellerId): array {
        return $this->transactionRepository->getHistoryByRole($sellerId, 'seller');
    }
}