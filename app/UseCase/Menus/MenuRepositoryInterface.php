<?php
namespace UseCase\Menus;

interface MenuRepositoryInterface
{
    /** @return \Domain\Menu[] */
    public function findAll(): array;

    public function create(string $name, string $createdBy, array $dishes, float $totalPrice): bool;
}