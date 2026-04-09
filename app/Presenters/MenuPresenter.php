<?php
namespace Presenters;

use Views\Menus\MenuView;

class MenuPresenter
{
    public function showList(array $menus): void
    {
        MenuView::renderList($menus);
    }

    public function showCreateForm(array $dishes): void
    {
        MenuView::renderCreateForm($dishes);
    }

    public function showEditForm(\Domain\Menu $menu, array $dishes): void
    {
        MenuView::renderEditForm($menu, $dishes);
    }
}