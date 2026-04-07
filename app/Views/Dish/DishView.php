<?php

namespace Views\Dish;
class DishView
{
    public static function render($plats) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');

        $cardTemplate = file_get_contents(__DIR__ . '/dish-card.html');

        echo $header;
        echo "<h1>Menu de notre restaurant Uber</h1>";
        echo "<div class='plats-container' style='display: flex; flex-wrap: wrap;'>";

        foreach($plats as $plat) {
            $html = str_replace('{NOM}', htmlspecialchars($plat->name), $cardTemplate);
            $html = str_replace('{DESCRIPTION}', htmlspecialchars($plat->description), $html);
            $html = str_replace('{PRIX}', htmlspecialchars($plat->price), $html);
            echo $html;
        }

        echo "</div></body></html>";
    }
}