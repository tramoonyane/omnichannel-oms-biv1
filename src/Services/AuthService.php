<?php

namespace Src\Services;

use Src\Models\User;

class AuthService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Login user (basic version - no JWT yet)
     */
    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return ["error" => "User not found"];
        }

        // NOTE: plain password for now (we upgrade to hashing later)
        if ($user['password_hash'] !== $password) {
            return ["error" => "Invalid credentials"];
        }

        // simulate session token
        return [
            "message" => "Login successful",
            "user" => [
                "id" => $user['id'],
                "email" => $user['email'],
                "role" => $user['role']
            ],
            "token" => base64_encode($user['id'] . ":" . $user['role'])
        ];
    }

    /**
     * Decode token (very simple version)
     */
    public function parseToken(string $token): ?array
    {
        $decoded = base64_decode($token);

        if (!$decoded || !str_contains($decoded, ":")) {
            return null;
        }

        [$id, $role] = explode(":", $decoded);

        return [
            "id" => $id,
            "role" => $role
        ];
    }
}
