<?php
namespace UseCase\Orders;

class CreateOrder
{
    public function execute($shippingAddress, $deliveryDate, $quantity) {
        $jsonMenus = file_get_contents('http://localhost:3004/menus');
        $menusAPI = json_decode($jsonMenus, true);

        $orderLines = [];
        $orderTotalPrice = 0;

        if ($menusAPI && is_array($quantity)) {
            foreach($menusAPI as $menu) {
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

        if (empty($orderLines)) return false;

        $data = [
            "abonneId" => 1,
            "dateCommande" => date("Y-m-d\TH:i:s"),
            "adresseLivraison" => $shippingAddress,
            "dateLivraison" => $deliveryDate,
            "lignes" => $orderLines,
            "prixTotal" => $orderTotalPrice
        ];
        $payload = json_encode($data);

        // 4. Envoi cURL
        $ch = curl_init('http://localhost:3005/commandes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}