<?php

namespace UseCase\Orders;

/**
 * Cas d'usage : récupère toutes les commandes.
 */
class GetOrder
{
    public function __construct(private OrderRepositoryInterface $repo) {}

    /**
     * @return \Domain\Order[]
     */
    public function execute(): array
    {
        return $this->repo->findAll();
    }
}