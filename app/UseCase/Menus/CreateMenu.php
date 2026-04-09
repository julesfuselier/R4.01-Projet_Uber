<?php

namespace UseCase\Menus;

use Domain\Menu;

/**
 * Cas d'usage : crée un nouveau menu et lui associe des plats.
 */
class CreateMenu
{
    public function __construct(private MenuRepositoryInterface $menuRepo) {}

    /**
     * @return bool True si le menu a été créé avec succès.
     */
    public function execute(CreateMenuRequest $request): bool
    {
        $menu            = new Menu();
        $menu->name      = $request->name;
        $menu->creatorId = $request->creatorId;

        $menuId = $this->menuRepo->create($menu);
        if (!$menuId) return false;

        foreach ($request->dishIds as $dishId) {
            $this->menuRepo->addDish($menuId, (int) $dishId);
        }

        return true;
    }
}