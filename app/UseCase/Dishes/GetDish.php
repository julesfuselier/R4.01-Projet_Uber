<?php
namespace UseCase\Dishes;

use Domain\Dish;

class GetDish
{
    public function execute($id)
    {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $plats = $data['plats'] ?? [];
        foreach ($plats as $plat) {
            if ($plat['id'] == $id) {
                $dish = new Dish();
                $dish->id = $plat['id'];
                $dish->name = $plat['nom'];
                $dish->description = $plat['description'] ?? '';
                $dish->price = $plat['prix'];
                $dish->isAvailable = $plat['isAvailable'] ?? true;
                $dish->ownerId = $plat['ownerId'] ?? null;
                return $dish;
            }
        }
        return null;
    }
}
