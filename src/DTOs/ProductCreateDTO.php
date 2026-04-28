<?php

declare(strict_types=1);

namespace WpEcommerceApi\DTOs;

readonly class ProductCreateDTO {
    public function __construct(
        public int $sellerId,
        public string $name,
        public float $price,
        public string $description,
        public array $imageIds = []
    ) {}
}