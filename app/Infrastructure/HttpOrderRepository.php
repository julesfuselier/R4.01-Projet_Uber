<?php
namespace Infrastructure;

use Config\ApiConfig;
use Domain\Order;
use Repository\OrderRepositoryInterface;

class HttpOrderRepository implements OrderRepositoryInterface
{
    public function findAll(): array
    {
        $json = file_get_contents(ApiConfig::ORDERS_API_BASE . '/commandes');
        $data = json_decode($json, true);

        $orders = [];
        if ($data) {
            foreach ($data as $item) {
                $order = new Order();
                $order->id              = $item['id'];
                $order->subscriberId    = $item['abonneId'];
                $order->orderDate       = $item['dateCommande'];
                $order->shippingAddress = $item['adresseLivraison'];
                $order->deliveryDate    = $item['dateLivraison'];
                $order->lines           = $item['lignes'];
                $order->totalPrice      = $item['prixTotal'];
                $orders[] = $order;
            }
        }
        return $orders;
    }

    public function create(
        int    $subscriberId,
        string $orderDate,
        string $shippingAddress,
        string $deliveryDate,
        array  $lines,
        float  $totalPrice
    ): bool {
        $payload = json_encode([
            'abonneId'         => $subscriberId,
            'dateCommande'     => $orderDate,
            'adresseLivraison' => $shippingAddress,
            'dateLivraison'    => $deliveryDate,
            'lignes'           => $lines,
            'prixTotal'        => $totalPrice,
        ]);

        $ch = curl_init(ApiConfig::ORDERS_API_BASE . '/commandes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }
}