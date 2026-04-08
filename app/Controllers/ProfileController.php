<?php

namespace Controllers;

use UseCase\User\ListUsers;
use UseCase\User\GetUser;
use UseCase\User\CreateUser;
use UseCase\User\UpdateUser;
use UseCase\User\DeleteUser;

class ProfileController
{
    public function showUsers() {
        $useCase = new ListUsers();
        $users = $useCase->execute();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function showUser($id) {
        $useCase = new GetUser();
        $user = $useCase->execute($id);
        header('Content-Type: application/json');
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "User not found"]);
        }
    }

    public function createUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $useCase = new CreateUser();
            $useCase->execute(
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['address'] ?? '',
                $data['role'] ?? 'user'
            );
            http_response_code(201);
            echo json_encode(["message" => "User created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Bad request"]);
        }
    }

    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $useCase = new UpdateUser();
            $success = $useCase->execute(
                $id,
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['address'] ?? '',
                $data['role'] ?? 'user'
            );
            if ($success) {
                echo json_encode(["message" => "User updated"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "User not found"]);
            }
        }
    }

    public function deleteUser($id) {
        $useCase = new DeleteUser();
        $success = $useCase->execute($id);
        if ($success) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "User not found"]);
        }
    }
}
