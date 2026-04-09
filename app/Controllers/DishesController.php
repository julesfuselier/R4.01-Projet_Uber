<?php
namespace Controllers;

use Presenters\DishPresenter;
use UseCase\Dishes\ListDishes;

class DishesController
{
    public function __construct(
        private ListDishes     $listDishes,
        private DishPresenter  $presenter
    ) {}

    public function showDishes(): void
    {
        $dishes = $this->listDishes->execute();
        $this->presenter->showList($dishes);
    }
}