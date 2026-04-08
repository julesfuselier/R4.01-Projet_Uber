<?php
require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->get('/', function () {
    header('Location: /plats');
    exit();
});

$router->get('/plats', 'Controllers\DishesController@showDishes');
$router->get('/dishes/owner/(\d+)', 'Controllers\DishesController@showOwnerDishes');
$router->get('/dishes/(\d+)', 'Controllers\DishesController@showDish');
$router->post('/dishes/owner/(\d+)', 'Controllers\DishesController@createDish');
$router->put('/dishes/(\d+)', 'Controllers\DishesController@updateDish');
$router->delete('/dishes/(\d+)', 'Controllers\DishesController@deleteDish');

$router->get('/users', 'Controllers\ProfileController@showUsers');
$router->get('/users/(\d+)', 'Controllers\ProfileController@showUser');
$router->post('/users', 'Controllers\ProfileController@createUser');
$router->put('/users/(\d+)', 'Controllers\ProfileController@updateUser');
$router->delete('/users/(\d+)', 'Controllers\ProfileController@deleteUser');

$router->get('/menus', 'Controllers\MenusController@showMenus');
$router->get('/menus/create', 'Controllers\MenusController@showCreateForm'); // <-- La nouvelle route !
$router->post('/menus/create', 'Controllers\MenusController@create');
$router->get('/commandes', 'Controllers\OrdersController@showOrders');
$router->get('/commandes/create', 'Controllers\OrdersController@showCreateForm');
$router->post('/commandes/create', 'Controllers\OrdersController@create');

$router->run();