<?php

declare(strict_types=1);

namespace WpEcommerceApi\DTOs;

readonly class UserCreateDTO {
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName
    ) {}
}