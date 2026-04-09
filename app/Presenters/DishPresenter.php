<?php

namespace Presenters;

use Views\Dish\DishView;

/**
 * Délègue l'affichage des plats à DishView.
 */
class DishPresenter
{
    /**
     * @param \Domain\Dish[] $dishes
     */
    public function showList(array $dishes): void
    {
        DishView::render($dishes);
    }
}