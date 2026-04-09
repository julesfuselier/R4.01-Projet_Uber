<?php

namespace Domain;

/**
 * Ligne d'une commande associant un menu à une quantité.
 */
class OrderLine
{
    /**
     * @param int    $menuId    Identifiant du menu commandé.
     * @param string $menuName  Nom du menu au moment de la commande.
     * @param float  $unitPrice Prix unitaire du menu.
     * @param int    $quantity  Quantité commandée.
     */
    public function __construct(
        public readonly int    $menuId,
        public readonly string $menuName,
        public readonly float  $unitPrice,
        public readonly int    $quantity
    ) {}

    /**
     * Retourne le montant total de la ligne (unitPrice × quantity).
     */
    public function lineTotal(): float
    {
        return $this->unitPrice * $this->quantity;
    }
}