<?php
namespace UseCase\Menus;

class DeleteMenu
{
    public function __construct(
        private MenuRepositoryInterface $menuRepo
    ) {}

    public function execute(int $id): bool
    {
        return $this->menuRepo->delete($id);
    }
}