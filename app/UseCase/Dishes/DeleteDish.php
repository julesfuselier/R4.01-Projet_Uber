<?php
namespace UseCase\Dishes;

class DeleteDish
{
    public function execute($id)
    {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $plats = $data['plats'] ?? [];
        $deleted = false;

        foreach ($plats as $key => $plat) {
            if ($plat['id'] == $id) {
                unset($plats[$key]);
                $deleted = true;
                break;
            }
        }

        if ($deleted) {
            // Re-index array so JSON doesn't become an object
            $data['plats'] = array_values($plats);
            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }

        return false;
    }
}
