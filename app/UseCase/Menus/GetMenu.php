<?php
namespace UseCase\Menus;

use Domain\Menu;

class GetMenu
{
    public function execute() {
        $json = file_get_contents('http://localhost:3003/menus');
        $menusData = json_decode($json, true);

        $menus = [];
        if ($menusData) {
            foreach($menusData as $data) {
                $menu = new Menu();
                $menu->id = $data['id'];
                $menu->name = $data['nom'];
                $menu->createdBy = $data['createurNom'];
                $menu->totalPrice = $data['prixTotal'];
                $menus[] = $menu;
            }
        }
        return $menus;
    }
}