<?php
namespace UseCase\Menus;

use Domain\Menu;

class GetMenu
{
    public function execute()
    {
        $json = file_get_contents(__DIR__ . '/../../../public/menus.json');
        $data = json_decode($json, true);
        $menusData = $data['menus'] ?? $data ?? [];

        $menus = [];
        if ($menusData) {
            foreach ($menusData as $item) {
                $menu = new Menu();
                $menu->id = $item['id'] ?? uniqid();
                $menu->name = $item['nom'] ?? 'Menu';
                $menu->createdBy = $item['createurNom'] ?? 'Inconnu';
                $menu->totalPrice = $item['prixTotal'] ?? 0;
                $menus[] = $menu;
            }
        }
        return $menus;
    }
}