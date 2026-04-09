<?php

namespace Views\Menus;
class MenuView
{
    public static function renderList($menus) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');
        $cardTemplate = file_get_contents(__DIR__ . '/menu-card.html');

        echo $header;
        echo "<h1>Nos Menus Disponibles</h1>";
        echo "<a href='/menus/create'>Créer un nouveau menu</a>";
        echo "<div style='display: flex; flex-wrap: wrap;'>";

        foreach($menus as $menu) {
            $html = str_replace('{ID}',      htmlspecialchars($menu->id),        $cardTemplate);
            $html = str_replace('{NOM}',     htmlspecialchars($menu->name),      $html);
            $html = str_replace('{CREATEUR}',htmlspecialchars($menu->createdBy), $html);
            $html = str_replace('{PRIX}',    htmlspecialchars($menu->totalPrice),$html);
            echo $html;
        }

        echo "</div></body></html>";
    }

    public static function renderEditForm($menu, $platsDisponibles) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');
        $formTemplate = file_get_contents(__DIR__ . '/edit-menu.html');

        $checkboxesHtml = "";
        foreach($platsDisponibles as $plat) {
            $checked = in_array($plat->id, array_column($menu->dishes, 'id')) ? 'checked' : '';
            $checkboxesHtml .= "
                <div style='margin-bottom: 5px;'>
                    <label>
                        <input type='checkbox' name='plats[]' value='" . htmlspecialchars($plat->id) . "' $checked>
                        " . htmlspecialchars($plat->name) . " (" . htmlspecialchars($plat->price) . " €)
                    </label>
                </div>
            ";
        }

        $finalHtml = str_replace('{ID}',       htmlspecialchars($menu->id),        $formTemplate);
        $finalHtml = str_replace('{NOM}',      htmlspecialchars($menu->name),      $finalHtml);
        $finalHtml = str_replace('{CREATEUR}', htmlspecialchars($menu->createdBy), $finalHtml);
        $finalHtml = str_replace('{LISTE_PLATS}', $checkboxesHtml,                 $finalHtml);

        echo $header;
        echo $finalHtml;
        echo "</body></html>";
    }

    public static function renderCreateForm($platsDisponibles) {
        $header = file_get_contents(__DIR__ . '/../Shared/Header/header-template.html');
        $formTemplate = file_get_contents(__DIR__ . '/create-menu.html');

        $checkboxesHtml = "";
        foreach($platsDisponibles as $plat) {
            $checkboxesHtml .= "
                <div style='margin-bottom: 5px;'>
                    <label>
                        <input type='checkbox' name='plats[]' value='" . htmlspecialchars($plat->id) . "'> 
                        " . htmlspecialchars($plat->name) . " (" . htmlspecialchars($plat->price) . " €)
                    </label>
                </div>
            ";
        }

        $finalHtml = str_replace('{LISTE_PLATS}', $checkboxesHtml, $formTemplate);

        echo $header;
        echo $finalHtml;
        echo "</body></html>";
    }
}