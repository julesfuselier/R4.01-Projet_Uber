<?php

namespace Domain;

/**
 * Entité représentant une commande passée par un abonné.
 */
class Order
{
    /** @var int */
    public $id;

    /** @var int */
    public $subscriberId;

    /** @var string */
    public $orderDate;

    /** @var string */
    public $shippingAddress;

    /** @var string */
    public $deliveryDate;

    /** @var OrderLine[] */
    public array $lines = [];

    /** @var float */
    public $totalPrice;

    /**
     * Ajoute une ligne à la commande.
     */
    public function addLine(OrderLine $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Calcule le montant total de la commande à partir des lignes.
     */
    public function computeTotal(): float
    {
        return (float) array_sum(array_map(fn($l) => $l->lineTotal(), $this->lines));
    }
}