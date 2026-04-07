<?php
namespace Controllers;

use UseCase\Dishes\ListDishes;
use Views\Dish\DishView;

require_once __DIR__ . '/../Views/Dish/DishView.php';

class DishesController
{
    public function showDishes() {
        $useCase = new ListDishes();
        $plats = $useCase->execute();

        DishView::render($plats);
    }
}