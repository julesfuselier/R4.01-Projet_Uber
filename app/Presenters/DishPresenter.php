<?php
namespace Presenters;

use Views\Dish\DishView;

class DishPresenter
{
    public function showList(array $dishes): void
    {
        DishView::render($dishes);
    }
}