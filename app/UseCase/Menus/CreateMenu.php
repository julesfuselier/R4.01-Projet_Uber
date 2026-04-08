<?php
namespace UseCase\Menus;

use Repository\DishRepositoryInterface;
use Repository\MenuRepositoryInterface;

class CreateMenu
{
    public function __construct(
        private DishRepositoryInterface $dishRepo,
        private MenuRepositoryInterface $menuRepo
    ) {}

    public function execute(string $name, string $createdBy, array $selectedDishIds): bool
    {
        $allDishes = $this->dishRepo->findAll();

        $selectedDishes = array_values(array_filter(
            $allDishes,
            fn($d) => in_array((string) $d->id, array_map('strval', $selectedDishIds))
        ));

        $totalPrice = (float) array_sum(array_map(fn($d) => $d->price, $selectedDishes));

        return $this->menuRepo->create($name, $createdBy, $selectedDishes, $totalPrice);
    }
}