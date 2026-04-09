<?php
namespace UseCase\User;

interface UserRepositoryInterface
{
    /** @return \Domain\User[] */
    public function findAll(): array;
}