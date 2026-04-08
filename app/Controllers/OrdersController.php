<?php
namespace Controllers;

use UseCase\Menus\GetMenu;
use UseCase\Orders\CreateOrder;
use UseCase\Orders\GetOrder;
use Views\Orders\OrderView;

class OrdersController
{
    public function __construct(
        private GetOrder    $getOrder,
        private CreateOrder $createOrder,
        private GetMenu     $getMenu
    ) {}

    public function showOrders(): void
    {
        $orders = $this->getOrder->execute();
        OrderView::renderList($orders);
    }

    public function showCreateForm(): void
    {
        $menus = $this->getMenu->execute();
        OrderView::renderCreateForm($menus);
    }

    public function create(): void
    {
        if (isset($_POST['adresseLivraison'], $_POST['dateLivraison'], $_POST['quantites'])) {
            $this->createOrder->execute(
                $_POST['adresseLivraison'],
                $_POST['dateLivraison'],
                $_POST['quantites']
            );
            header('Location: /commandes');
            exit();
        }
    }
}