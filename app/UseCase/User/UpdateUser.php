<?php
namespace UseCase\User;

class UpdateUser
{
    public function execute($id, $firstName, $lastName, $email, $password, $address, $role) {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $utilisateurs = $data['utilisateurs'] ?? [];
        $updated = false;

        foreach($utilisateurs as $key => $u) {
            if ($u['id'] == $id) {
                $utilisateurs[$key]['prenom'] = $firstName;
                $utilisateurs[$key]['nom'] = $lastName;
                $utilisateurs[$key]['email'] = $email;
                $utilisateurs[$key]['password'] = $password;
                $utilisateurs[$key]['adresse'] = $address;
                $utilisateurs[$key]['role'] = $role;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $data['utilisateurs'] = $utilisateurs;
            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }
}
