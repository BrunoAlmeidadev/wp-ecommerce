<?php

declare(strict_types=1);

namespace WpEcommerceApi\DTOs;

readonly class TransactionCreateDTO {
    public function __construct(
        public int $buyerId,
        public int $productId,
        public array $shippingAddress
    ) {}
}