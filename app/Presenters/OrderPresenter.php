<?php
namespace Presenters;

use Views\Orders\OrderView;

class OrderPresenter
{
    public function showList(array $orders): void
    {
        OrderView::renderList($orders);
    }

    public function showCreateForm(array $menus): void
    {
        OrderView::renderCreateForm($menus);
    }
}