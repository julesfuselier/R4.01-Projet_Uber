<?php

namespace UseCase\Dishes;

/**
 * Cas d'usage : récupère tous les plats du catalogue.
 */
class ListDishes
{
    public function __construct(private DishRepositoryInterface $repo) {}

    /**
     * @return \Domain\Dish[]
     */
    public function execute(): array
    {
        return $this->repo->findAll();
    }
}