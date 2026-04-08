<?php
namespace UseCase\Dishes;

class UpdateDish
{
    public function execute($id, $name, $description, $price, $isAvailable)
    {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $plats = $data['plats'] ?? [];
        $updated = false;

        foreach ($plats as $key => $plat) {
            if ($plat['id'] == $id) {
                $plats[$key]['nom'] = $name;
                $plats[$key]['description'] = $description;
                $plats[$key]['prix'] = (float) $price;
                $plats[$key]['isAvailable'] = (bool) $isAvailable;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $data['plats'] = $plats;
            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }

        return false;
    }
}
