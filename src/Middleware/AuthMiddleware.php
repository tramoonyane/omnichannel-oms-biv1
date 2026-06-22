<?php

namespace Src\Middleware;

use Src\Services\AuthService;

class AuthMiddleware
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    /**
     * Protect route and validate token + role
     */
    public function handle(array $allowedRoles = []): array
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            return ["error" => "Unauthorized - No token"];
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);

        $user = $this->auth->parseToken($token);

        if (!$user) {
            return ["error" => "Invalid token"];
        }

        // ROLE CHECK
        if (!empty($allowedRoles) && !in_array($user['role'], $allowedRoles)) {
            return ["error" => "Forbidden - insufficient permissions"];
        }

        return $user;
    }
}
