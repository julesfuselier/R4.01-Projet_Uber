<?php
namespace Controllers;

use UseCase\Dishes\ListDishes;
use Views\Dish\DishView;

class DishesController
{
    public function showDishes()
    {
        $useCase = new ListDishes();
        $plats = $useCase->execute();

        DishView::render($plats);
    }
    public function showDish($id)
    {
        $useCase = new \UseCase\Dishes\GetDish();
        $dish = $useCase->execute($id);
        header('Content-Type: application/json');
        if ($dish) {
            echo json_encode($dish);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Dish not found"]);
        }
    }

    public function showOwnerDishes($id)
    {
        $useCase = new \UseCase\Dishes\GetOwnerDishes();
        $dishes = $useCase->execute($id);
        header('Content-Type: application/json');
        echo json_encode($dishes);
    }

    public function createDish($ownerId)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $useCase = new \UseCase\Dishes\CreateDish();
            $dish = $useCase->execute(
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['price'] ?? 0,
                $data['isAvailable'] ?? true,
                $ownerId
            );
            http_response_code(201);
            echo json_encode($dish);
        }
    }

    public function updateDish($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $useCase = new \UseCase\Dishes\UpdateDish();
            $success = $useCase->execute(
                $id,
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['price'] ?? 0,
                $data['isAvailable'] ?? true
            );
            if ($success) {
                echo json_encode(["message" => "Dish updated"]);
            } else {
                http_response_code(404);
            }
        }
    }

    public function deleteDish($id)
    {
        $useCase = new \UseCase\Dishes\DeleteDish();
        $success = $useCase->execute($id);
        if ($success) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Dish not found"]);
        }
    }
}
