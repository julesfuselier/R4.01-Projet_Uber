<?php
namespace UseCase\Dishes;

use Config\Config;
use Shared\ApiClient;

class ListDishes
{
    public function execute() {
        $platsData = ApiClient::get(Config::API_PLATS_URL . '/dishes');

        $dishes = [];
        if ($platsData) {
            foreach($platsData as $data) {
                $dish = new \Domain\Dish();
                $dish->id = $data['id'];
                $dish->name = $data['name'];
                $dish->price = $data['price'];
                $dish->description = $data['description'] ?? '';
                $dishes[] = $dish;
            }
        }
        return $dishes;
    }
}