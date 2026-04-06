<?php
namespace Controllers;

use UseCase\Dishes\ListDishes;
use UseCase\Menus\GetMenu;
use UseCase\Menus\CreateMenu;
use Views\Menus\MenuView;

require_once __DIR__ . '/../Views/Menus/MenuView.php';

class MenusController
{
    public function showMenus() {
        $useCase = new GetMenu();
        $menus = $useCase->execute();
        MenuView::renderList($menus);
    }

    public function create() {
        if (isset($_POST['nom']) && isset($_POST['createurNom']) && isset($_POST['plats'])) {

            $useCase = new CreateMenu();

            $useCase->execute($_POST['nom'], $_POST['createurNom'], $_POST['plats']);

            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez remplir tous les champs et sélectionner au moins un plat !";
            echo "<br><a href='/menus/create'>Retour</a>";
        }
    }

    public function showCreateForm() {
        $dishUseCase = new ListDishes();
        $plats = $dishUseCase->execute();

        MenuView::renderCreateForm($plats);
    }
}