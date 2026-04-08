<?php
namespace UseCase\Dishes;

use Domain\Dish;

class GetOwnerDishes
{
    public function execute($ownerId)
    {
        $file = __DIR__ . '/../../../public/plats-utilisateurs.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);

        $plats = $data['plats'] ?? [];
        $ownerDishes = [];

        foreach ($plats as $plat) {
            if (isset($plat['ownerId']) && $plat['ownerId'] == $ownerId) {
                $dish = new Dish();
                $dish->id = $plat['id'];
                $dish->name = $plat['nom'];
                $dish->description = $plat['description'] ?? '';
                $dish->price = $plat['prix'];
                $dish->isAvailable = $plat['isAvailable'] ?? true;
                $dish->ownerId = $plat['ownerId'];
                $ownerDishes[] = $dish;
            }
        }
        return $ownerDishes;
    }
}
