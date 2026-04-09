<?php

namespace UseCase\Orders;

/**
 * Contrat d'accès aux données des commandes.
 */
interface OrderRepositoryInterface
{
    /**
     * Retourne toutes les commandes.
     *
     * @return \Domain\Order[]
     */
    public function findAll(): array;

    /**
     * Persiste une commande et retourne true en cas de succès.
     */
    public function save(\Domain\Order $order): bool;
}