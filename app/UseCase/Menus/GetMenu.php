<?php

namespace UseCase\Menus;

/**
 * Cas d'usage : récupère tous les menus.
 */
class GetMenu
{
    public function __construct(private MenuRepositoryInterface $repo) {}

    /**
     * @return \Domain\Menu[]
     */
    public function execute(): array
    {
        return $this->repo->findAll();
    }
}