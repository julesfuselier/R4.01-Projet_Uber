<?php
namespace UseCase\Menus;

use Domain\Menu;
use UseCase\Dishes\DishRepositoryInterface;

class UpdateMenu
{
    public function __construct(
        private DishRepositoryInterface $dishRepo,
        private MenuRepositoryInterface $menuRepo
    ) {}

    public function execute(UpdateMenuRequest $request): bool
    {
        $allDishes = $this->dishRepo->findAll();

        $menu           = new Menu();
        $menu->id       = $request->id;
        $menu->name     = $request->name;
        $menu->createdBy = $request->createdBy;
        $menu->dishes   = array_values(array_filter(
            $allDishes,
            fn($d) => in_array((string) $d->id, array_map('strval', $request->dishIds))
        ));
        $menu->totalPrice = $menu->computeTotalPrice();

        return $this->menuRepo->update($menu);
    }
}