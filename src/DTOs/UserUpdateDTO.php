<?php

declare(strict_types=1);

namespace WpEcommerceApi\DTOs;

readonly class UserUpdateDTO {
    public function __construct(
        public int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public ?string $password = null
    ) {}
}