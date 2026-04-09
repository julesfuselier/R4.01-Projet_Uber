<?php
namespace UseCase\Orders;

interface OrderRepositoryInterface
{
    /** @return \Domain\Order[] */
    public function findAll(): array;

    public function save(\Domain\Order $order): bool;
}