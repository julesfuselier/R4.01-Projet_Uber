<?php
require __DIR__ . '/vendor/autoload.php';

use Controllers\DishesController;
use Controllers\MenusController;
use Controllers\OrdersController;
use Infrastructure\HttpDishRepository;
use Infrastructure\HttpMenuRepository;
use Infrastructure\HttpOrderRepository;
use Presenters\DishPresenter;
use Presenters\MenuPresenter;
use Presenters\OrderPresenter;
use UseCase\Dishes\ListDishes;
use UseCase\Menus\CreateMenu;
use UseCase\Menus\DeleteMenu;
use UseCase\Menus\GetMenu;
use UseCase\Menus\UpdateMenu;
use UseCase\Orders\CreateOrder;
use UseCase\Orders\GetOrder;

$dishRepo  = new HttpDishRepository();
$menuRepo  = new HttpMenuRepository();
$orderRepo = new HttpOrderRepository();

$listDishes  = new ListDishes($dishRepo);
$getMenu     = new GetMenu($menuRepo);
$createMenu  = new CreateMenu($dishRepo, $menuRepo);
$updateMenu  = new UpdateMenu($dishRepo, $menuRepo);
$deleteMenu  = new DeleteMenu($menuRepo);
$getOrder    = new GetOrder($orderRepo);
$createOrder = new CreateOrder($orderRepo);

$dishesController  = new DishesController($listDishes, new DishPresenter());
$menusController   = new MenusController($getMenu, $createMenu, $updateMenu, $deleteMenu, $listDishes, new MenuPresenter());
$ordersController  = new OrdersController($getOrder, $createOrder, $getMenu, new OrderPresenter());

$router = new \Bramus\Router\Router();

$router->get('/', function () {
    header('Location: /plats');
    exit();
});

$router->get('/plats',             fn() => $dishesController->showDishes());
$router->get('/menus',             fn() => $menusController->showMenus());
$router->get('/menus/create',        fn() => $menusController->showCreateForm());
$router->post('/menus/create',       fn() => $menusController->create());
$router->get('/menus/(\d+)/edit',    fn($id) => $menusController->showEditForm((int)$id));
$router->post('/menus/(\d+)/edit',   fn($id) => $menusController->update((int)$id));
$router->post('/menus/(\d+)/delete', fn($id) => $menusController->delete((int)$id));
$router->get('/commandes',         fn() => $ordersController->showOrders());
$router->get('/commandes/create',  fn() => $ordersController->showCreateForm());
$router->post('/commandes/create', fn() => $ordersController->create());

$router->run();