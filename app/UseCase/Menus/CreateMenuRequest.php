<?php
namespace UseCase\Menus;

class CreateMenuRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $createdBy,
        public readonly array  $dishIds
    ) {}
}