<?php
namespace UseCase\Dishes;

class ListDishes
{
    public function execute()
    {
        $json = file_get_contents(__DIR__ . '/../../../public/plats-utilisateurs.json');
        $data = json_decode($json, true);
        $platsData = $data['plats'] ?? [];

        $dishes = [];
        if ($platsData) {
            foreach ($platsData as $data) {
                $dish = new \Domain\Dish();
                $dish->id = $data['id'];
                $dish->name = $data['nom'];
                $dish->price = $data['prix'];
                $dish->description = $data['description'] ?? '';
                $dishes[] = $dish;
            }
        }
        return $dishes;
    }
}