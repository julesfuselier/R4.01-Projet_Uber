<?php
namespace UseCase\Orders;

class OrderLineData
{
    public function __construct(
        public readonly int    $menuId,
        public readonly string $menuName,
        public readonly float  $unitPrice,
        public readonly int    $quantity
    ) {}
}