<?php
namespace Domain;

class Menu
{
    public $id;
    public $name;
    public $createdBy;
    public $totalPrice;
    public $dishes = [];

    public function computeTotalPrice(): float
    {
        return (float) array_sum(array_map(fn($d) => $d->price, $this->dishes));
    }
}