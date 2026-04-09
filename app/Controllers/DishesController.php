<?php

namespace Controllers;

use Presenters\DishPresenter;
use UseCase\Dishes\ListDishes;

/**
 * Gère les requêtes HTTP liées aux plats.
 */
class DishesController
{
    public function __construct(
        private ListDishes     $listDishes,
        private DishPresenter  $presenter
    ) {}

    /**
     * Affiche la liste de tous les plats disponibles.
     */
    public function showDishes(): void
    {
        $dishes = $this->listDishes->execute();
        $this->presenter->showList($dishes);
    }
}