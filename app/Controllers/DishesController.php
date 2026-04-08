<?php
namespace Controllers;

use UseCase\Dishes\ListDishes;
use Views\Dish\DishView;

class DishesController
{
    public function __construct(private ListDishes $listDishes) {}

    public function showDishes(): void
    {
        $dishes = $this->listDishes->execute();
        DishView::render($dishes);
    }
}