<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Src\Controllers\AuthController;
use Src\Controllers\DashboardController;
use Src\Controllers\AnalyticsController;
use Src\Controllers\OrderController;
use Src\Controllers\InventoryController;

use Src\Services\Presentation\ChartService;

use Src\Middleware\AuthMiddleware;
use Src\Middleware\RoleMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| LOAD ENVIRONMENT VARIABLES
|--------------------------------------------------------------------------
*/

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/*
|--------------------------------------------------------------------------
| SLIM APPLICATION
|--------------------------------------------------------------------------
*/

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

/*
|--------------------------------------------------------------------------
| DEFAULT JSON HEADER
|--------------------------------------------------------------------------
*/

$app->add(function (Request $request, $handler) {

    $response = $handler->handle($request);

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

$app->group('/api/v1', function ($group) {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTES
    |--------------------------------------------------------------------------
    */

    $group->post('/auth/login', function (
        Request $request,
        Response $response
    ) {

        return (new AuthController())
            ->login($request, $response);

    });

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES
    |--------------------------------------------------------------------------
    */

    $group->group('', function ($group) {

        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        $group->post('/auth/logout', function (
            Request $request,
            Response $response
        ) {

            return (new AuthController())
                ->logout($request, $response);

        });

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        $group->get('/analytics/dashboard/summary', function (
            Request $request,
            Response $response
        ) {

            $controller = new DashboardController();

            $response->getBody()->write(
                json_encode($controller->summary())
            );

            return $response;

        })->add(new RoleMiddleware(['admin', 'manager']));

        /*
        |--------------------------------------------------------------------------
        | CHARTS
        |--------------------------------------------------------------------------
        */

        $group->get('/analytics/charts/sales-trend', function (
            Request $request,
            Response $response
        ) {

            $charts = new ChartService();

            $response->getBody()->write(
                json_encode($charts->salesTrend())
            );

            return $response;

        });

        $group->get('/analytics/charts/top-products', function (
            Request $request,
            Response $response
        ) {

            $charts = new ChartService();

            $response->getBody()->write(
                json_encode($charts->topProducts())
            );

            return $response;

        });

        $group->get('/analytics/charts/inventory', function (
            Request $request,
            Response $response
        ) {

            $charts = new ChartService();

            $response->getBody()->write(
                json_encode($charts->inventoryDistribution())
            );

            return $response;

        });

        /*
        |--------------------------------------------------------------------------
        | SALES ANALYTICS
        |--------------------------------------------------------------------------
        */

        $group->get('/analytics/sales/overview', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->getSalesOverview())
            );

            return $response;

        });

        $group->get('/analytics/sales/daily', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->getDailySales())
            );

            return $response;

        });

        $group->get('/analytics/sales/top-products', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->getTopProducts())
            );

            return $response;

        });

        /*
        |--------------------------------------------------------------------------
        | INVENTORY ANALYTICS
        |--------------------------------------------------------------------------
        */

        $group->get('/analytics/inventory', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->inventoryOverview())
            );

            return $response;

        });

        $group->get('/analytics/inventory/low-stock', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->lowStock())
            );

            return $response;

        });

        $group->get('/analytics/inventory/high-stock', function (
            Request $request,
            Response $response
        ) {

            $controller = new AnalyticsController();

            $response->getBody()->write(
                json_encode($controller->highStock())
            );

            return $response;

        });

        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

        $group->post('/orders', function (
            Request $request,
            Response $response
        ) {

            $controller = new OrderController();

            $response->getBody()->write(
                json_encode($controller->createOrder())
            );

            return $response;

        });

        $group->get('/orders', function (
            Request $request,
            Response $response
        ) {

            $controller = new OrderController();

            $response->getBody()->write(
                json_encode($controller->getOrders())
            );

            return $response;

        });

        /*
        |--------------------------------------------------------------------------
        | INVENTORY
        |--------------------------------------------------------------------------
        */

        $group->get('/inventory', function (
            Request $request,
            Response $response
        ) {

            $controller = new InventoryController();

            $response->getBody()->write(
                json_encode($controller->getInventory())
            );

            return $response;

        });

    })->add(new AuthMiddleware());

});

/*
|--------------------------------------------------------------------------
| RUN APPLICATION
|--------------------------------------------------------------------------
*/

$app->run();