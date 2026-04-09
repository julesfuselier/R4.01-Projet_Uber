<?php
namespace UseCase\Orders;

class CreateOrderRequest
{
    /**
     * @param OrderLineData[] $lines
     */
    public function __construct(
        public readonly string $shippingAddress,
        public readonly string $deliveryDate,
        public readonly array  $lines
    ) {}
}