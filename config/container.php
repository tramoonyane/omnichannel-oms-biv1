<?php

use DI\Container;

use Src\Core\Database;


/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/

use Src\Models\User;
use Src\Models\Product;
use Src\Models\Order;


/*
|--------------------------------------------------------------------------
| CORE SERVICES
|--------------------------------------------------------------------------
*/

use Src\Services\InventoryService;
use Src\Services\OrderService;


/*
|--------------------------------------------------------------------------
| ANALYTICS SERVICES
|--------------------------------------------------------------------------
*/

use Src\Services\Analytics\InventoryAnalyticsService;
use Src\Services\Analytics\SalesAnalyticsService;
use Src\Services\Analytics\AnalyticsService;


/*
|--------------------------------------------------------------------------
| PRESENTATION SERVICES
|--------------------------------------------------------------------------
*/

use Src\Services\Presentation\ChartService;
use Src\Services\Presentation\DashboardService;


/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use Src\Controllers\AuthController;
use Src\Controllers\OrderController;
use Src\Controllers\InventoryController;
use Src\Controllers\AnalyticsController;
use Src\Controllers\DashboardController;



$container = new Container();



/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/

$container->set(PDO::class, function () {

    return (new Database())
        ->getConnection();

});





/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/


$container->set(User::class, function ($container) {

    return new User(
        $container->get(PDO::class)
    );

});



$container->set(Product::class, function ($container) {

    return new Product(
        $container->get(PDO::class)
    );

});



$container->set(Order::class, function ($container) {

    return new Order(
        $container->get(PDO::class)
    );

});







/*
|--------------------------------------------------------------------------
| CORE SERVICES
|--------------------------------------------------------------------------
*/


$container->set(InventoryService::class, function ($container) {

    return new InventoryService(

        $container->get(Product::class)

    );

});




$container->set(OrderService::class, function ($container) {

    return new OrderService(

        $container->get(PDO::class),

        $container->get(Order::class),

        $container->get(InventoryService::class)

    );

});








/*
|--------------------------------------------------------------------------
| ANALYTICS SERVICES
|--------------------------------------------------------------------------
*/


$container->set(
    InventoryAnalyticsService::class,
    function ($container) {

        return new InventoryAnalyticsService(

            $container->get(Product::class)

        );

    }
);



$container->set(
    SalesAnalyticsService::class,
    function ($container) {

        return new SalesAnalyticsService(

            $container->get(PDO::class)

        );

    }
);





$container->set(
    AnalyticsService::class,
    function ($container) {

        return new AnalyticsService(

            $container->get(
                InventoryAnalyticsService::class
            ),

            $container->get(
                SalesAnalyticsService::class
            )

        );

    }
);







/*
|--------------------------------------------------------------------------
| PRESENTATION SERVICES
|--------------------------------------------------------------------------
*/


$container->set(
    DashboardService::class,
    function ($container) {

        return new DashboardService(

            $container->get(
                AnalyticsService::class
            )

        );

    }
);




$container->set(
    ChartService::class,
    function ($container) {

        return new ChartService(

            $container->get(
                AnalyticsService::class
            )

        );

    }
);







/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/


$container->set(
    AuthController::class,
    function ($container) {

        return new AuthController(

            $container->get(
                User::class
            )

        );

    }
);





$container->set(
    OrderController::class,
    function ($container) {

        return new OrderController(

            $container->get(
                OrderService::class
            ),

            $container->get(
                Order::class
            )

        );

    }
);





$container->set(
    InventoryController::class,
    function ($container) {

        return new InventoryController(

            $container->get(
                Product::class
            )

        );

    }
);





$container->set(
    AnalyticsController::class,
    function ($container) {

        return new AnalyticsController(

            $container->get(
                AnalyticsService::class
            )

        );

    }
);






$container->set(
    DashboardController::class,
    function ($container) {

        return new DashboardController(

            $container->get(
                DashboardService::class
            )

        );

    }
);






return $container;