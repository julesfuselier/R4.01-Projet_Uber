<?php
namespace Infrastructure;

use Config\ApiConfig;
use Domain\Dish;
use Repository\DishRepositoryInterface;

class HttpDishRepository implements DishRepositoryInterface
{
    public function findAll(): array
    {
        $json = file_get_contents(ApiConfig::DISHES_API_BASE);
        $data = json_decode($json, true);

        $dishes = [];
        if ($data) {
            foreach ($data as $item) {
                $dish = new Dish();
                $dish->id          = $item['id'];
                $dish->name        = $item['name'];
                $dish->description = $item['description'] ?? '';
                $dish->price       = $item['price'];
                $dishes[] = $dish;
            }
        }
        return $dishes;
    }
}