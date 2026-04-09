<?php

namespace UseCase\Menus;

/**
 * Cas d'usage : supprime un menu par son identifiant.
 */
class DeleteMenu
{
    public function __construct(
        private MenuRepositoryInterface $menuRepo
    ) {}

    /**
     * @param int $id Identifiant du menu à supprimer.
     * @return bool   True si la suppression a réussi.
     */
    public function execute(int $id): bool
    {
        return $this->menuRepo->delete($id);
    }
}