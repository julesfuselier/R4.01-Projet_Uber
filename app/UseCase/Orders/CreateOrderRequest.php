<?php

namespace UseCase\Orders;

/**
 * DTO portant les données nécessaires à la création d'une commande.
 */
readonly class CreateOrderRequest
{
    /**
     * @param string          $shippingAddress Adresse de livraison.
     * @param string          $deliveryDate    Date de livraison souhaitée.
     * @param OrderLineData[] $lines           Lignes de la commande.
     */
    public function __construct(
        public string $shippingAddress,
        public string $deliveryDate,
        public array  $lines
    ) {}
}