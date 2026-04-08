<?php
namespace Infrastructure;

use Config\ApiConfig;
use Domain\User;
use Repository\UserRepositoryInterface;

class HttpUserRepository implements UserRepositoryInterface
{
    public function findAll(): array
    {
        $json = file_get_contents(ApiConfig::JAVA_API_BASE . '/users');
        $data = json_decode($json, true);

        $users = [];
        if ($data) {
            foreach ($data as $item) {
                $user = new User();
                $user->id        = $item['id'];
                $user->firstName = $item['firstName'];
                $user->lastName  = $item['lastName'];
                $user->email     = $item['email'];
                $user->role      = $item['role'];
                $users[] = $user;
            }
        }
        return $users;
    }
}