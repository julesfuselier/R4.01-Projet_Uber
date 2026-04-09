<?php
namespace UseCase\Menus;

class UpdateMenuRequest
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $createdBy,
        public readonly array  $dishIds
    ) {}
}