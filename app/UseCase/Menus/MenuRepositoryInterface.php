<?php

namespace UseCase\Menus;

/**
 * Contrat d'accès aux données des menus.
 */
interface MenuRepositoryInterface
{
    /**
     * Retourne tous les menus.
     *
     * @return \Domain\Menu[]
     */
    public function findAll(): array;

    /**
     * Persiste un nouveau menu et retourne son identifiant généré.
     */
    public function create(\Domain\Menu $menu): int;

    /**
     * Associe un plat à un menu existant.
     */
    public function addDish(int $menuId, int $dishId): bool;

    /**
     * Met à jour les informations d'un menu.
     */
    public function update(\Domain\Menu $menu): bool;

    /**
     * Supprime un menu par son identifiant.
     */
    public function delete(int $id): bool;
}