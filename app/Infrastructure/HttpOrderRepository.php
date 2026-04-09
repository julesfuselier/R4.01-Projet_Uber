<?php

namespace Infrastructure;

use Config\ApiConfig;
use Domain\Order;
use UseCase\Orders\OrderRepositoryInterface;

/**
 * Implémentation HTTP du repository des commandes (JSON server :3005).
 */
class HttpOrderRepository implements OrderRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
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

    /** {@inheritDoc} */
    public function save(\Domain\Order $order): bool
    {
        $lignes = array_map(fn($l) => [
            'menuId'       => $l->menuId,
            'menuNom'      => $l->menuName,
            'quantite'     => $l->quantity,
            'prixUnitaire' => $l->unitPrice,
            'prixLigne'    => $l->lineTotal(),
        ], $order->lines);

        $payload = json_encode([
            'abonneId'         => $order->subscriberId,
            'dateCommande'     => $order->orderDate,
            'adresseLivraison' => $order->shippingAddress,
            'dateLivraison'    => $order->deliveryDate,
            'lignes'           => $lignes,
            'prixTotal'        => $order->totalPrice,
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