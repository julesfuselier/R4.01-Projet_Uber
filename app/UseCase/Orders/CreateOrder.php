<?php
namespace UseCase\Orders;

class CreateOrder
{
    public function execute($shippingAddress, $deliveryDate, $quantity)
    {
        $jsonMenus = file_get_contents(__DIR__ . '/../../../public/menus.json');
        $menusData = json_decode($jsonMenus, true);
        $menusAPI = $menusData['menus'] ?? $menusData ?? [];

        $orderLines = [];
        $orderTotalPrice = 0;

        if ($menusAPI && is_array($quantity)) {
            foreach ($menusAPI as $menu) {
                $idMenu = $menu['id'];

                if (isset($quantity[$idMenu]) && $quantity[$idMenu] > 0) {
                    $qte = (int) $quantity[$idMenu];
                    $unitPrice = (float) $menu['prixTotal'];
                    $linePrice = $unitPrice * $qte;

                    $orderLines[] = [
                        "menuId" => $idMenu,
                        "menuNom" => $menu['nom'],
                        "quantite" => $qte,
                        "prixUnitaire" => $unitPrice,
                        "prixLigne" => $linePrice
                    ];
                    $orderTotalPrice += $linePrice;
                }
            }
        }

        if (empty($orderLines))
            return false;

        $ordersFile = __DIR__ . '/../../../public/commandes.json';
        $ordersDataFile = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
        if (!is_array($ordersDataFile))
            $ordersDataFile = [];

        $ordersList = isset($ordersDataFile['commandes']) ? $ordersDataFile['commandes'] : $ordersDataFile;

        $newId = count($ordersList) > 0 ? max(array_column($ordersList, 'id')) + 1 : 1;

        $data = [
            "id" => $newId,
            "abonneId" => 1,
            "dateCommande" => date("Y-m-d\TH:i:s"),
            "adresseLivraison" => $shippingAddress,
            "dateLivraison" => $deliveryDate,
            "lignes" => $orderLines,
            "prixTotal" => $orderTotalPrice
        ];

        $ordersList[] = $data;

        if (isset($ordersDataFile['commandes'])) {
            $ordersDataFile['commandes'] = $ordersList;
        } else {
            $ordersDataFile = $ordersList;
        }

        file_put_contents($ordersFile, json_encode($ordersDataFile, JSON_PRETTY_PRINT));

        return true;
    }
}