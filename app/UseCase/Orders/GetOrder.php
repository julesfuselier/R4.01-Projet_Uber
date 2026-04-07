<?php
namespace UseCase\Orders;

use Domain\Order;

class GetOrder
{
    public function execute() {
        $json = file_get_contents('http://localhost:3005/commandes');
        $ordersData = json_decode($json, true);

        $orders = [];
        if ($ordersData) {
            foreach($ordersData as $data) {
                $order = new Order();
                $order->id = $data['id'];
                $order->subscriberId = $data['abonneId'];
                $order->orderDate = $data['dateCommande'];
                $order->shippingAddress = $data['adresseLivraison'];
                $order->deliveryDate = $data['dateLivraison'];
                $order->lines = $data['lignes'];
                $order->totalPrice = $data['prixTotal'];
                $orders[] = $order;
            }
        }
        return $orders;
    }
}