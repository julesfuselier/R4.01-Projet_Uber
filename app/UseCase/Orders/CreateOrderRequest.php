<?php

namespace UseCase\Orders;

/**
 * DTO portant les données nécessaires à la création d'une commande.
 */
class CreateOrderRequest
{
    /**
     * @param string          $shippingAddress Adresse de livraison.
     * @param string          $deliveryDate    Date de livraison souhaitée.
     * @param OrderLineData[] $lines           Lignes de la commande.
     */
    public function __construct(
        public readonly string $shippingAddress,
        public readonly string $deliveryDate,
        public readonly array  $lines
    ) {}
}