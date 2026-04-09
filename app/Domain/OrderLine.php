<?php
namespace Domain;

class OrderLine
{
    public function __construct(
        public readonly int    $menuId,
        public readonly string $menuName,
        public readonly float  $unitPrice,
        public readonly int    $quantity
    ) {}

    public function lineTotal(): float
    {
        return $this->unitPrice * $this->quantity;
    }
}