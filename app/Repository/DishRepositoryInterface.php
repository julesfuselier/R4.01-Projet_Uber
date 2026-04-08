<?php
namespace Repository;

interface DishRepositoryInterface
{
    /** @return \Domain\Dish[] */
    public function findAll(): array;
}