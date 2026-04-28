<?php

declare(strict_types=1);

namespace WpEcommerceApi\DTOs;

readonly class ProductUpdateDTO {
    public function __construct(
        public int $id,
        public int $sellerId,
        public ?string $name = null,
        public ?float $price = null,
        public ?string $description = null,
        public ?array $imageIds = null
    ) {}
}