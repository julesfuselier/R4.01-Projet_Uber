<?php
namespace Controllers;

use UseCase\Orders\GetOrder;
use UseCase\Orders\CreateOrder;
use UseCase\Menus\GetMenu;
use Views\Orders\OrderView;

class OrdersController
{
    public function showOrders()
    {
        $useCase = new GetOrder();
        $orders = $useCase->execute();
        OrderView::renderList($orders);
    }

    public function showCreateForm()
    {
        $menuUseCase = new GetMenu();
        $menus = $menuUseCase->execute();
        OrderView::renderCreateForm($menus);
    }

    public function create()
    {
        if (isset($_POST['adresseLivraison']) && isset($_POST['dateLivraison']) && isset($_POST['quantites'])) {
            $useCase = new CreateOrder();
            $useCase->execute($_POST['adresseLivraison'], $_POST['dateLivraison'], $_POST['quantites']);

            header('Location: /commandes');
            exit();
        }
    }
}