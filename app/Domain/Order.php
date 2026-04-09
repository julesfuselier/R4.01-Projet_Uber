<?php
namespace Domain;

class Order
{
    public $id;
    public $subscriberId;
    public $orderDate;
    public $shippingAddress;
    public $deliveryDate;
    /** @var OrderLine[] */
    public array $lines = [];
    public $totalPrice;

    public function addLine(OrderLine $line): void
    {
        $this->lines[] = $line;
    }

    public function computeTotal(): float
    {
        return (float) array_sum(array_map(fn($l) => $l->lineTotal(), $this->lines));
    }
}