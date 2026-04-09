<?php

namespace UseCase\User;

/**
 * Contrat d'accès aux données des utilisateurs.
 */
interface UserRepositoryInterface
{
    /**
     * Retourne tous les utilisateurs.
     *
     * @return \Domain\User[]
     */
    public function findAll(): array;
}