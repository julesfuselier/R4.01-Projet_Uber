<?php
namespace UseCase\Orders;

use Domain\Order;

class GetOrder
{
    public function execute()
    {
        $json = file_get_contents(__DIR__ . '/../../../public/commandes.json');
        $data = json_decode($json, true);
        $ordersData = $data['commandes'] ?? $data ?? [];

        $orders = [];
        if ($ordersData) {
            foreach ($ordersData as $item) {
                $order = new Order();
                $order->id = $item['id'] ?? uniqid();
                $order->subscriberId = $item['abonneId'] ?? null;
                $order->orderDate = $item['dateCommande'] ?? '';
                $order->shippingAddress = $item['adresseLivraison'] ?? '';
                $order->deliveryDate = $item['dateLivraison'] ?? '';
                $order->lines = $item['lignes'] ?? [];
                $order->totalPrice = $item['prixTotal'] ?? 0;
                $orders[] = $order;
            }
        }
        return $orders;
    }
}