<?php
namespace UseCase\User;

use Domain\User;

class GetUser
{
    public function execute($id) {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $utilisateurs = $data['utilisateurs'] ?? [];
        foreach($utilisateurs as $u) {
            if ($u['id'] == $id) {
                $user = new User();
                $user->id = $u['id'];
                $user->firstName = $u['prenom'];
                $user->lastName = $u['nom'];
                $user->email = $u['email'];
                $user->password = $u['password'];
                $user->address = $u['adresse'];
                $user->role = $u['role'] ?? 'user';
                return $user;
            }
        }
        return null;
    }
}
