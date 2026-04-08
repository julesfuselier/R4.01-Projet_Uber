<?php
namespace UseCase\Menus;

use Repository\MenuRepositoryInterface;

class GetMenu
{
    public function __construct(private MenuRepositoryInterface $repo) {}

    public function execute(): array
    {
        return $this->repo->findAll();
    }
}