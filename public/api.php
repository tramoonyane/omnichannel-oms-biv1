<?php

/*
|--------------------------------------------------------------------------
| CORE BOOTSTRAP
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Core/Auth.php';

/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../src/Models/Product.php';
require_once __DIR__ . '/../src/Models/Order.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Models/OrderItem.php';

/*
|--------------------------------------------------------------------------
| MIDDLEWARE
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../src/Middleware/AuthMiddleware.php';

/*
|--------------------------------------------------------------------------
| SERVICES (NEW STRUCTURE)
|--------------------------------------------------------------------------
*/

// Inventory & Sales Analytics (NEW ARCHITECTURE)
require_once __DIR__ . '/../src/Services/Analytics/InventoryAnalyticsService.php';
require_once __DIR__ . '/../src/Services/Analytics/SalesAnalyticsService.php';
require_once __DIR__ . '/../src/Services/Analytics/AnalyticsService.php';

// Presentation Layer
require_once __DIR__ . '/../src/Services/Presentation/ChartService.php';
require_once __DIR__ . '/../src/Services/Presentation/DashboardService.php';

// Core Services
require_once __DIR__ . '/../src/Services/OrderService.php';
require_once __DIR__ . '/../src/Services/InventoryService.php';
require_once __DIR__ . '/../src/Services/AuthService.php';

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../src/Controllers/InventoryController.php';
require_once __DIR__ . '/../src/Controllers/OrderController.php';
require_once __DIR__ . '/../src/Controllers/AnalyticsController.php';
require_once __DIR__ . '/../src/Controllers/DashboardController.php';

/*
|--------------------------------------------------------------------------
| USE STATEMENTS
|--------------------------------------------------------------------------
*/
use Src\Core\Router;
use Src\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| INIT
|--------------------------------------------------------------------------
*/
header('Content-Type: application/json');

$router = new Router();

/*
|--------------------------------------------------------------------------
| INIT SHARED OBJECTS
|--------------------------------------------------------------------------
*/
$middleware = new \Src\Middleware\AuthMiddleware();
$dashboard = new \Src\Controllers\DashboardController();
$analytics = new \Src\Controllers\AnalyticsController();
$charts = new \Src\Services\Presentation\ChartService();

/*
|--------------------------------------------------------------------------
| ROUTES
|--------------------------------------------------------------------------
*/

/*
| DASHBOARD (ROLE PROTECTED)
*/
$router->get('/api/v1/analytics/dashboard/summary', function () use ($middleware, $dashboard) {

    $auth = $middleware->handle(['admin', 'manager']);

    if (isset($auth['error'])) {
        return $auth;
    }

    return $dashboard->summary();
});

/*
| CHARTS
*/
$router->get('/api/v1/analytics/charts/sales-trend', function () use ($charts) {
    return $charts->salesTrend();
});

$router->get('/api/v1/analytics/charts/top-products', function () use ($charts) {
    return $charts->topProducts();
});

$router->get('/api/v1/analytics/charts/inventory', function () use ($charts) {
    return $charts->inventoryDistribution();
});

/*
| SALES ANALYTICS
*/
$router->get('/api/v1/analytics/sales/overview', function () use ($analytics) {
    return $analytics->getSalesOverview();
});

$router->get('/api/v1/analytics/sales/daily', function () use ($analytics) {
    return $analytics->getDailySales();
});

$router->get('/api/v1/analytics/sales/top-products', function () use ($analytics) {
    return $analytics->getTopProducts();
});

/*
| INVENTORY ANALYTICS
*/
$router->get('/api/v1/analytics/inventory', function () use ($analytics) {
    return $analytics->inventoryOverview();
});

$router->get('/api/v1/analytics/inventory/low-stock', function () use ($analytics) {
    return $analytics->lowStock();
});

$router->get('/api/v1/analytics/inventory/high-stock', function () use ($analytics) {
    return $analytics->highStock();
});

/*
| ORDERS
*/
$router->post('/api/v1/orders', function () {
    $controller = new \Src\Controllers\OrderController();
    return $controller->createOrder();
});

$router->get('/api/v1/orders', function () {
    $controller = new \Src\Controllers\OrderController();
    return $controller->getOrders();
});

/*
| INVENTORY
*/
$router->get('/api/v1/inventory', function () {
    $controller = new InventoryController();
    return $controller->getInventory();
});

/*
|--------------------------------------------------------------------------
| DISPATCH
|--------------------------------------------------------------------------
*/
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$response = $router->dispatch($uri, $_SERVER['REQUEST_METHOD']);

echo json_encode($response, JSON_UNESCAPED_UNICODE);