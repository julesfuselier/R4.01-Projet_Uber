<?php
namespace Controllers;

use Presenters\OrderPresenter;
use UseCase\Menus\GetMenu;
use UseCase\Orders\CreateOrder;
use UseCase\Orders\CreateOrderRequest;
use UseCase\Orders\GetOrder;
use UseCase\Orders\OrderLineData;

class OrdersController
{
    public function __construct(
        private GetOrder       $getOrder,
        private CreateOrder    $createOrder,
        private GetMenu        $getMenu,
        private OrderPresenter $presenter
    ) {}

    public function showOrders(): void
    {
        $orders = $this->getOrder->execute();
        $this->presenter->showList($orders);
    }

    public function showCreateForm(): void
    {
        $menus = $this->getMenu->execute();
        $this->presenter->showCreateForm($menus);
    }

    public function create(): void
    {
        if (!isset($_POST['adresseLivraison'], $_POST['dateLivraison'], $_POST['quantites'])) {
            return;
        }

        $menus     = $this->getMenu->execute();
        $quantities = $_POST['quantites'];

        $lines = [];
        foreach ($menus as $menu) {
            $qty = (int) ($quantities[$menu->id] ?? 0);
            if ($qty <= 0) {
                continue;
            }
            $lines[] = new OrderLineData($menu->id, $menu->name, (float) $menu->totalPrice, $qty);
        }

        $request = new CreateOrderRequest($_POST['adresseLivraison'], $_POST['dateLivraison'], $lines);
        $this->createOrder->execute($request);

        header('Location: /commandes');
        exit();
    }
}