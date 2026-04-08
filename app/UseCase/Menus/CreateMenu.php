<?php
namespace UseCase\Menus;

class CreateMenu
{
    public function execute($nomMenu, $createurNom, $platsIds)
    {
        $jsonPlats = file_get_contents(__DIR__ . '/../../../public/plats-utilisateurs.json');
        $dataPlats = json_decode($jsonPlats, true);
        $tousLesPlats = $dataPlats['plats'] ?? [];

        $platsPourLeMenu = [];
        $prixTotal = 0;

        if ($tousLesPlats && is_array($platsIds)) {
            foreach ($tousLesPlats as $plat) {
                if (in_array($plat['id'], $platsIds)) {
                    $platsPourLeMenu[] = [
                        "id" => (int) $plat['id'],
                        "nom" => $plat['nom'],
                        "prix" => (float) $plat['prix']
                    ];
                    $prixTotal += (float) $plat['prix'];
                }
            }
        }

        $menusFile = __DIR__ . '/../../../public/menus.json';
        $menusData = file_exists($menusFile) ? json_decode(file_get_contents($menusFile), true) : [];
        if (!is_array($menusData))
            $menusData = [];
        // Support structure with or without root key "menus"
        $menusList = isset($menusData['menus']) ? $menusData['menus'] : $menusData;

        $newId = count($menusList) > 0 ? max(array_column($menusList, 'id')) + 1 : 1;

        $nouveauMenu = [
            "id" => $newId,
            "nom" => $nomMenu,
            "createurNom" => $createurNom,
            "dateCreation" => date("Y-m-d"),
            "dateMiseAJour" => date("Y-m-d"),
            "plats" => $platsPourLeMenu,
            "prixTotal" => $prixTotal
        ];

        $menusList[] = $nouveauMenu;

        if (isset($menusData['menus'])) {
            $menusData['menus'] = $menusList;
        } else {
            $menusData = $menusList;
        }

        file_put_contents($menusFile, json_encode($menusData, JSON_PRETTY_PRINT));

        return true;
    }
}