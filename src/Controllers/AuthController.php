<?php

namespace Src\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\User;
use Src\Core\Jwt;

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Handle user login authentication (JWT VERSION)
     */
    public function login(Request $request, Response $response): Response
    {
        // Read JSON body
        $body = $request->getParsedBody();

        if (empty($body)) {
            $body = json_decode((string)$request->getBody(), true);
        }

        $email = trim($body['email'] ?? '');
        $password = $body['password'] ?? '';

        // Validate input
        if ($email === '' || $password === '') {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Email and password are required.'
            ]));

            return $response->withStatus(400);
        }

        // Find user
        $user = $this->userModel->findByEmail($email);

        // Verify credentials
        if (!$user || !password_verify($password, $user['password_hash'])) {

            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Invalid email or password.'
            ]));

            return $response->withStatus(401);
        }

        /*
        |--------------------------------------------------------------------------
        | JWT GENERATION (REPLACES SESSION)
        |--------------------------------------------------------------------------
        */

        $token = Jwt::generate([
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ]);

        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'Authentication successful.',
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ]));

        return $response;
    }

    /**
     * Logout (JWT version = client-side token discard)
     */
    public function logout(Request $request, Response $response): Response
    {
        /*
        |--------------------------------------------------------------------------
        | JWT NOTE
        |--------------------------------------------------------------------------
        | With JWT, logout is handled on the client side by deleting the token.
        | Server does not need session destruction anymore.
        */

        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'Logged out successfully. Please remove token from client storage.'
        ]));

        return $response;
    }
}