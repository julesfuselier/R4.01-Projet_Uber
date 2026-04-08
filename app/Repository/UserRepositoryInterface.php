<?php
namespace Repository;

interface UserRepositoryInterface
{
    /** @return \Domain\User[] */
    public function findAll(): array;
}