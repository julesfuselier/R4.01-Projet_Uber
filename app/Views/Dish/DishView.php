<?php

namespace Views\Dish;

/**
 * Vue HTML pour l'affichage des plats.
 */
class DishView
{
    /**
     * Affiche la liste des plats sous forme de cartes.
     *
     * @param \Domain\Dish[] $plats
     */
    public static function render($plats): void
    {
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