<?php
namespace UseCase\Dishes;

interface DishRepositoryInterface
{
    /** @return \Domain\Dish[] */
    public function findAll(): array;
}