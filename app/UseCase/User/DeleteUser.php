<?php
namespace UseCase\User;

class DeleteUser
{
    public function execute($id) {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $utilisateurs = $data['utilisateurs'] ?? [];
        $deleted = false;

        foreach($utilisateurs as $key => $u) {
            if ($u['id'] == $id) {
                unset($utilisateurs[$key]);
                $deleted = true;
                break;
            }
        }

        if ($deleted) {
            $data['utilisateurs'] = array_values($utilisateurs);
            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }
}
