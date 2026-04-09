<?php

namespace Domain;

/**
 * Entité représentant un menu composé de plats.
 */
class Menu
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $creatorId;

    /** @var string */
    public $createdBy;

    /** @var float */
    public $totalPrice;

    /** @var Dish[] */
    public $dishes = [];

    /**
     * Calcule le prix total en sommant les prix des plats associés.
     */
    public function computeTotalPrice(): float
    {
        return (float) array_sum(array_map(fn($d) => $d->price, $this->dishes));
    }
}