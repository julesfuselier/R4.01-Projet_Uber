<?php
require __DIR__ . '/vendor/autoload.php';

use Controllers\DishesController;
use Controllers\MenusController;
use Controllers\OrdersController;
use Infrastructure\HttpDishRepository;
use Infrastructure\HttpMenuRepository;
use Infrastructure\HttpOrderRepository;
use UseCase\Dishes\ListDishes;
use UseCase\Menus\CreateMenu;
use UseCase\Menus\GetMenu;
use UseCase\Orders\CreateOrder;
use UseCase\Orders\GetOrder;

$dishRepo  = new HttpDishRepository();
$menuRepo  = new HttpMenuRepository();
$orderRepo = new HttpOrderRepository();

$listDishes  = new ListDishes($dishRepo);
$getMenu     = new GetMenu($menuRepo);
$createMenu  = new CreateMenu($dishRepo, $menuRepo);
$getOrder    = new GetOrder($orderRepo);
$createOrder = new CreateOrder($menuRepo, $orderRepo);

$dishesController  = new DishesController($listDishes);
$menusController   = new MenusController($getMenu, $createMenu, $listDishes);
$ordersController  = new OrdersController($getOrder, $createOrder, $getMenu);



$router = new \Bramus\Router\Router();

$router->get('/', function () {
    header('Location: /plats');
    exit();
});

$router->get('/plats',             fn() => $dishesController->showDishes());
$router->get('/menus',             fn() => $menusController->showMenus());
$router->get('/menus/create',      fn() => $menusController->showCreateForm());
$router->post('/menus/create',     fn() => $menusController->create());
$router->get('/commandes',         fn() => $ordersController->showOrders());
$router->get('/commandes/create',  fn() => $ordersController->showCreateForm());
$router->post('/commandes/create', fn() => $ordersController->create());

$router->run();