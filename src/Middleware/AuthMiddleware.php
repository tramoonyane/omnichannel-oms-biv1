<?php

namespace Src\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response as SlimResponse;
use Src\Core\Jwt;

class AuthMiddleware
{
    public function __invoke(Request $request, Handler $handler): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (empty($authHeader)) {
            return $this->unauthorized('Missing Authorization header.');
        }

        // 💡 Utilizing your static helper method to cleanly extract the token
        $token = Jwt::extractToken($authHeader);

        if (!$token) {
            return $this->unauthorized('Invalid Authorization header format.');
        }

        try {
            $decoded = Jwt::validate($token);

            $request = $request->withAttribute('user', (array) $decoded->user);

            return $handler->handle($request);

        } catch (\Throwable $e) {
            return $this->unauthorized($e->getMessage());
        }
    }

    private function unauthorized(string $message): Response
    {
        $response = new SlimResponse();

        $response->getBody()->write(json_encode([
            'status'  => 'error',
            'message' => $message
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);
    }
}
