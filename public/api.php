<?php

require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/Product.php';
require_once __DIR__ . '/../src/Controllers/InventoryController.php';

use Src\Core\Router;
use Src\Controllers\InventoryController;

header('Content-Type: application/json');

$router = new Router();

/*
|--------------------------------------------------------------------------
| ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/api/v1/inventory', function () {
    $controller = new InventoryController();
    return $controller->getInventory();
});

/*
|--------------------------------------------------------------------------
| REQUEST URI (CLEAN)
|--------------------------------------------------------------------------
*/
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/*
|--------------------------------------------------------------------------
| DISPATCH REQUEST
|--------------------------------------------------------------------------
*/
$response = $router->dispatch($uri, $_SERVER['REQUEST_METHOD']);

/*
|--------------------------------------------------------------------------
| OUTPUT JSON
|--------------------------------------------------------------------------
*/
echo json_encode($response, JSON_UNESCAPED_UNICODE);