<?php
namespace UseCase\User;

use Domain\User;

class ListUsers
{
    public function execute() {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $utilisateurs = $data['utilisateurs'] ?? [];
        $users = [];
        foreach($utilisateurs as $u) {
            $user = new User();
            $user->id = $u['id'];
            $user->firstName = $u['prenom'];
            $user->lastName = $u['nom'];
            $user->email = $u['email'];
            $user->password = $u['password'];
            $user->address = $u['adresse'];
            $user->role = $u['role'] ?? 'user';
            $users[] = $user;
        }
        return $users;
    }
}
