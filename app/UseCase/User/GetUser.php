<?php

namespace UseCase\User;

/**
 * Cas d'usage : récupère tous les utilisateurs.
 */
class GetUser
{
    public function __construct(private UserRepositoryInterface $repo) {}

    /**
     * @return \Domain\User[]
     */
    public function execute(): array
    {
        return $this->repo->findAll();
    }
}