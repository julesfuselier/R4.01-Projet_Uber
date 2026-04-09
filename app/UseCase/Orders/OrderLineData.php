<?php

namespace UseCase\Orders;

/**
 * DTO représentant une ligne de commande dans la requête de création.
 */
readonly class OrderLineData
{
    /**
     * @param int    $menuId    Identifiant du menu.
     * @param string $menuName  Nom du menu.
     * @param float  $unitPrice Prix unitaire.
     * @param int    $quantity  Quantité commandée.
     */
    public function __construct(
        public int    $menuId,
        public string $menuName,
        public float  $unitPrice,
        public int    $quantity
    ) {}
}