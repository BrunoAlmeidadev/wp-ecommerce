<?php

declare(strict_types=1);

namespace WpEcommerceApi\Services;

use WpEcommerceApi\DTOs\UserCreateDTO;
use WpEcommerceApi\DTOs\UserUpdateDTO;
use WpEcommerceApi\Repositories\UserRepository;
use Exception;

final class UserService {

    public function __construct(private readonly UserRepository $repository) {}

    public function registerUser(UserCreateDTO $dto): int {
        if ($this->repository->emailExists($dto->email)) {
            throw new Exception('Email is already in use.');
        }

        if ($this->repository->usernameExists($dto->username)) {
            throw new Exception('Username is already in use.');
        }

        return $this->repository->create($dto);
    }

    public function getProfile(int $userId): array {
        $user = $this->repository->getById($userId);

        if (!$user) {
            throw new Exception('User not found.');
        }

        return [
            'id'        => $user->ID,
            'username'  => $user->user_login,
            'email'     => $user->user_email,
            'firstName' => $user->first_name,
            'lastName'  => $user->last_name,
        ];
    }

    public function updateProfile(UserUpdateDTO $dto, int $currentUserId): void {
        if ($dto->id !== $currentUserId) {
            throw new Exception('You can only update your own profile.');
        }

        $existingUser = $this->repository->getById($dto->id);

        if ($dto->email !== $existingUser->user_email && $this->repository->emailExists($dto->email)) {
            throw new Exception('Email is already in use by another account.');
        }

        $this->repository->update($dto);
    }
}