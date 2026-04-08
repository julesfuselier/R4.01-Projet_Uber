<?php
namespace UseCase\User;

use Domain\User;

class CreateUser
{
    public function execute($firstName, $lastName, $email, $password, $address, $role = 'user') {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $utilisateurs = $data['utilisateurs'] ?? [];
        $newId = count($utilisateurs) > 0 ? max(array_column($utilisateurs, 'id')) + 1 : 1;

        $newUser = [
            "id" => $newId,
            "nom" => $lastName,
            "prenom" => $firstName,
            "email" => $email,
            "password" => $password,
            "adresse" => $address,
            "role" => $role
        ];
        
        $utilisateurs[] = $newUser;
        $data['utilisateurs'] = $utilisateurs;

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        return clone(new User()); // In a real scenario populate and return
    }
}
