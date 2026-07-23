<?php

namespace Src\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Src\Models\User;
use Src\Core\Jwt;

class AuthController
{
    private User $userModel;


    /**
     * Dependency Injection
     *
     * User model is injected.
     * Controller does not create database dependencies.
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }



    /**
     * Handle user login authentication (JWT VERSION)
     */
    public function login(
        Request $request,
        Response $response
    ): Response {


        /*
        |--------------------------------------------------------------------------
        | READ REQUEST BODY
        |--------------------------------------------------------------------------
        */

        $body = $request->getParsedBody();


        if (empty($body)) {

            $body = json_decode(
                (string) $request->getBody(),
                true
            );

        }



        $email = trim(
            $body['email'] ?? ''
        );


        $password =
            $body['password'] ?? '';




        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $email === '' ||
            $password === ''
        ) {


            $response->getBody()->write(
                json_encode([
                    "status" => "error",
                    "message" =>
                    "Email and password are required."
                ])
            );


            return $response->withStatus(400);

        }




        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        $user =
            $this->userModel
                 ->findByEmail($email);





        /*
        |--------------------------------------------------------------------------
        | VERIFY PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !password_verify(
                $password,
                $user['password_hash']
            )
        ) {


            $response->getBody()->write(
                json_encode([
                    "status" => "error",
                    "message" =>
                    "Invalid email or password."
                ])
            );


            return $response->withStatus(401);

        }





        /*
        |--------------------------------------------------------------------------
        | GENERATE JWT TOKEN
        |--------------------------------------------------------------------------
        */

        $token =
            Jwt::generate([

                "id" =>
                $user['id'],

                "email" =>
                $user['email'],

                "role" =>
                $user['role']

            ]);





        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        $response->getBody()->write(
            json_encode([

                "status" =>
                "success",

                "message" =>
                "Authentication successful.",

                "token" =>
                $token,


                "user" => [

                    "id" =>
                    $user['id'],

                    "email" =>
                    $user['email'],

                    "role" =>
                    $user['role']

                ]

            ])
        );



        return $response;

    }





    /**
     * JWT logout
     *
     * Server does nothing.
     * Client deletes token.
     */
    public function logout(
        Request $request,
        Response $response
    ): Response {


        $response->getBody()->write(
            json_encode([

                "status" =>
                "success",

                "message" =>
                "Logged out successfully. Remove token from client storage."

            ])
        );


        return $response;

    }

}