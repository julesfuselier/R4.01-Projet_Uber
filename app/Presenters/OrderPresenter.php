<?php

namespace Presenters;

use Views\Orders\OrderView;

/**
 * Délègue l'affichage des commandes à OrderView.
 */
class OrderPresenter
{
    /**
     * @param \Domain\Order[] $orders
     */
    public function showList(array $orders): void
    {
        OrderView::renderList($orders);
    }

    /**
     * @param \Domain\Menu[] $menus
     */
    public function showCreateForm(array $menus): void
    {
        OrderView::renderCreateForm($menus);
    }
}