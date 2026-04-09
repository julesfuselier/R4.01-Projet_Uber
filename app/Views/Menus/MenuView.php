<?php

namespace Views\Menus;

/**
 * Vue HTML pour l'affichage et la gestion des menus.
 */
class MenuView
{
    /**
     * Affiche la liste des menus sous forme de cartes.
     *
     * @param \Domain\Menu[] $menus
     */
    public static function renderList($menus): void
    {
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

    /**
     * Affiche le formulaire d'édition d'un menu existant.
     *
     * @param \Domain\Menu   $menu
     * @param \Domain\Dish[] $platsDisponibles
     */
    public static function renderEditForm($menu, $platsDisponibles): void
    {
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

        $finalHtml = str_replace('{ID}',          htmlspecialchars($menu->id),   $formTemplate);
        $finalHtml = str_replace('{NOM}',         htmlspecialchars($menu->name), $finalHtml);
        $finalHtml = str_replace('{LISTE_PLATS}', $checkboxesHtml,               $finalHtml);

        echo $header;
        echo $finalHtml;
        echo "</body></html>";
    }

    /**
     * Affiche le formulaire de création d'un nouveau menu.
     *
     * @param \Domain\User[] $users
     * @param \Domain\Dish[] $platsDisponibles
     */
    public static function renderCreateForm($users, $platsDisponibles): void
    {
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

        $createurSelect = "<select id='creatorId' name='creatorId' required style='width: 100%; padding: 8px;'>";
        $createurSelect .= "<option value=''>-- Choisissez un créateur --</option>";
        foreach ($users as $user) {
            $createurSelect .= "<option value='" . htmlspecialchars($user->id) . "'>"
                . htmlspecialchars($user->firstName . ' ' . $user->lastName)
                . "</option>";
        }
        $createurSelect .= "</select>";

        $finalHtml = str_replace('{LISTE_PLATS}',     $checkboxesHtml,  $formTemplate);
        $finalHtml = str_replace('{LISTE_CREATEURS}', $createurSelect,  $finalHtml);

        echo $header;
        echo $finalHtml;
        echo "</body></html>";
    }
}