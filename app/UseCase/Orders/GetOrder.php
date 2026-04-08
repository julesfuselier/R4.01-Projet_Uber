<?php
namespace UseCase\Orders;

class GetOrder
{
    public function __construct(private OrderRepositoryInterface $repo) {}

    public function execute(): array
    {
        return $this->repo->findAll();
    }
}