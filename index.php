<?php
require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->get('/', function() {
    header('Location: /plats');
    exit();
});

$router->get('/plats', 'Controllers\DishesController@showDishes');
$router->get('/menus', 'Controllers\MenusController@showMenus');
$router->get('/menus/create', 'Controllers\MenusController@showCreateForm'); // <-- La nouvelle route !
$router->post('/menus/create', 'Controllers\MenusController@create');
$router->get('/commandes', 'Controllers\OrdersController@showOrders');
$router->get('/commandes/create', 'Controllers\OrdersController@showCreateForm');
$router->post('/commandes/create', 'Controllers\OrdersController@create');

$router->run();