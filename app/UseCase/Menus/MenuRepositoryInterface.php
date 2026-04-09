<?php
namespace UseCase\Menus;

interface MenuRepositoryInterface
{
    /** @return \Domain\Menu[] */
    public function findAll(): array;

    public function create(\Domain\Menu $menu): bool;

    public function update(\Domain\Menu $menu): bool;

    public function delete(int $id): bool;
}