<?php

declare(strict_types=1);

namespace WpEcommerceApi\Repositories;

use WpEcommerceApi\DTOs\UserCreateDTO;
use WpEcommerceApi\DTOs\UserUpdateDTO;
use Exception;
use WP_User;

final class UserRepository {

    public function emailExists(string $email): bool {
        return email_exists($email) !== false;
    }

    public function usernameExists(string $username): bool {
        return username_exists($username) !== false;
    }

    public function create(UserCreateDTO $dto): int {
        $userData = [
            'user_login' => $dto->username,
            'user_email' => $dto->email,
            'user_pass'  => $dto->password,
            'first_name' => $dto->firstName,
            'last_name'  => $dto->lastName,
            'role'       => 'customer'
        ];

        $userId = wp_insert_user($userData);

        if (is_wp_error($userId)) {
            throw new Exception($userId->get_error_message());
        }

        return $userId;
    }

    public function update(UserUpdateDTO $dto): void {
        $userData = [
            'ID'         => $dto->id,
            'user_email' => $dto->email,
            'first_name' => $dto->firstName,
            'last_name'  => $dto->lastName,
        ];

        if ($dto->password !== null) {
            $userData['user_pass'] = $dto->password;
        }

        $result = wp_update_user($userData);

        if (is_wp_error($result)) {
            throw new Exception($result->get_error_message());
        }
    }

    public function getById(int $id): ?WP_User {
        $user = get_user_by('id', $id);
        return $user !== false ? $user : null;
    }
}