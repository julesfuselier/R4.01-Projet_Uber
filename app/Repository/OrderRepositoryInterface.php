<?php
namespace Repository;

interface OrderRepositoryInterface
{
    /** @return \Domain\Order[] */
    public function findAll(): array;

    public function create(
        int    $subscriberId,
        string $orderDate,
        string $shippingAddress,
        string $deliveryDate,
        array  $lines,
        float  $totalPrice
    ): bool;
}