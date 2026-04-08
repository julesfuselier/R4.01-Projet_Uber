<?php
namespace UseCase\Dishes;

use Domain\Dish;

class CreateDish
{
    public function execute($name, $description, $price, $isAvailable = true, $ownerId = null)
    {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $plats = $data['plats'] ?? [];
        $newId = count($plats) > 0 ? max(array_column($plats, 'id')) + 1 : 1;

        $newPlat = [
            "id" => $newId,
            "nom" => $name,
            "description" => $description,
            "prix" => (float) $price,
            "isAvailable" => (bool) $isAvailable,
            "ownerId" => $ownerId
        ];
        $plats[] = $newPlat;
        $data['plats'] = $plats;

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        return $newPlat;
    }
}
