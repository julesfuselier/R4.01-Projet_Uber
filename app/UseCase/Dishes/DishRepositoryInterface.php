<?php

namespace UseCase\Dishes;

/**
 * Contrat d'accès aux données des plats.
 */
interface DishRepositoryInterface
{
    /**
     * Retourne tous les plats disponibles.
     *
     * @return \Domain\Dish[]
     */
    public function findAll(): array;
}