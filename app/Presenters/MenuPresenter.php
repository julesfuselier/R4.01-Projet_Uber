<?php

namespace Presenters;

use Views\Menus\MenuView;

/**
 * Délègue l'affichage des menus à MenuView.
 */
class MenuPresenter
{
    /**
     * @param \Domain\Menu[] $menus
     */
    public function showList(array $menus): void
    {
        MenuView::renderList($menus);
    }

    /**
     * @param \Domain\User[] $users
     * @param \Domain\Dish[] $dishes
     */
    public function showCreateForm(array $users, array $dishes): void
    {
        MenuView::renderCreateForm($users, $dishes);
    }

    /**
     * @param \Domain\Dish[] $dishes
     */
    public function showEditForm(\Domain\Menu $menu, array $dishes): void
    {
        MenuView::renderEditForm($menu, $dishes);
    }
}