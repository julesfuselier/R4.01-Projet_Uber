<?php
namespace Controllers;

use UseCase\Dishes\ListDishes;
use UseCase\Menus\CreateMenu;
use UseCase\Menus\GetMenu;
use Views\Menus\MenuView;

class MenusController
{
    public function __construct(
        private GetMenu    $getMenu,
        private CreateMenu $createMenu,
        private ListDishes $listDishes
    ) {}

    public function showMenus(): void
    {
        $menus = $this->getMenu->execute();
        MenuView::renderList($menus);
    }

    public function showCreateForm(): void
    {
        $dishes = $this->listDishes->execute();
        MenuView::renderCreateForm($dishes);
    }

    public function create(): void
    {
        if (isset($_POST['nom'], $_POST['createurNom'], $_POST['plats'])) {
            $this->createMenu->execute($_POST['nom'], $_POST['createurNom'], $_POST['plats']);
            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez remplir tous les champs et sélectionner au moins un plat !";
            echo "<br><a href='/menus/create'>Retour</a>";
        }
    }
}