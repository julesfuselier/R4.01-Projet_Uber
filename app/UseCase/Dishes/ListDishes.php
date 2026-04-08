<?php
namespace UseCase\Dishes;

use Repository\DishRepositoryInterface;

class ListDishes
{
    public function __construct(private DishRepositoryInterface $repo) {}

    public function execute(): array
    {
        return $this->repo->findAll();
    }
}