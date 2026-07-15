<?php

namespace Src\Core;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class Jwt
{
    /**
     * Generate JWT token
     */
    public static function generate(array $user): string
    {
        $secret = $_ENV['JWT_SECRET'];
        $expires = time() + (int) $_ENV['JWT_EXPIRES'];

        $payload = [
            'iss' => $_ENV['APP_NAME'],
            'iat' => time(),
            'exp' => $expires,

            'user' => [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role']
            ]
        ];

        return FirebaseJWT::encode($payload, $secret, 'HS256');
    }

    /**
     * Validate JWT token
     */
    public static function validate(string $token): object
    {
        $secret = $_ENV['JWT_SECRET'];

        return FirebaseJWT::decode(
            $token,
            new Key($secret, 'HS256')
        );
    }

    /**
     * Extract Bearer token
     */
    public static function extractToken(string $header): ?string
    {
        if (!preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return null;
        }

        return trim($matches[1]);
    }
}