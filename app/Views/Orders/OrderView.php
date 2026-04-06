<?php

namespace Views\Orders;

class OrderView
{
    public static function renderList($orders) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');
        $cardTemplate = file_get_contents(__DIR__ . '/order-card.html');

        echo $header;
        echo "<h1>Historique des Commandes</h1>";
        echo "<a href='/commandes/create'>Passer une nouvelle commande</a>";
        echo "<div style='display: flex; flex-wrap: wrap;'>";

        foreach($orders as $order) {
            $html = str_replace('{ID}', htmlspecialchars($order->id), $cardTemplate);
            $html = str_replace('{TOTAL}', htmlspecialchars($order->totalPrice), $html);
            $html = str_replace('{DATE_LIVRAISON}', htmlspecialchars($order->deliveryDate), $html);
            $html = str_replace('{ADRESSE}', htmlspecialchars($order->shippingAddress), $html);
            echo $html;
        }

        echo "</div></body></html>";
    }

    public static function renderCreateForm($menusDispos) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');
        $formTemplate = file_get_contents(__DIR__ . '/create-order.html');

        $menusHtml = "";
        foreach($menusDispos as $menu) {
            $menusHtml .= "
                <div style='margin-bottom: 10px; padding: 10px; background: #f9f9f9;'>
                    <strong>" . htmlspecialchars($menu->name) . "</strong> (" . htmlspecialchars($menu->totalPrice) . " €)
                    <br>
                    <label>Quantité : <input type='number' name='quantites[" . $menu->id . "]' value='0' min='0'></label>
                </div>
            ";
        }

        $finalHtml = str_replace('{LISTE_MENUS}', $menusHtml, $formTemplate);

        echo $header;
        echo $finalHtml;
        echo "</body></html>";
    }
}