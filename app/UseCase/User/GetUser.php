<?php
namespace UseCase\User;

class GetUser
{
    public function __construct(private UserRepositoryInterface $repo) {}

    public function execute(): array
    {
        return $this->repo->findAll();
    }
}