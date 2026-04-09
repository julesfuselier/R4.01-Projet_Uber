<?php

namespace UseCase\Menus;

use Domain\Menu;

/**
 * Cas d'usage : met à jour le nom d'un menu et ses plats associés.
 */
class UpdateMenu
{
    public function __construct(private MenuRepositoryInterface $menuRepo) {}

    /**
     * @return bool True si la mise à jour a réussi.
     */
    public function execute(UpdateMenuRequest $request): bool
    {
        $menu       = new Menu();
        $menu->id   = $request->id;
        $menu->name = $request->name;

        $ok = $this->menuRepo->update($menu);

        foreach ($request->dishIds as $dishId) {
            $this->menuRepo->addDish($request->id, (int) $dishId);
        }

        return $ok;
    }
}