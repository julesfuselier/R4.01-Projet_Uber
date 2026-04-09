<?php
namespace Controllers;

use Presenters\MenuPresenter;
use UseCase\Dishes\ListDishes;
use UseCase\Menus\CreateMenu;
use UseCase\Menus\CreateMenuRequest;
use UseCase\Menus\DeleteMenu;
use UseCase\Menus\GetMenu;
use UseCase\Menus\UpdateMenu;
use UseCase\Menus\UpdateMenuRequest;

class MenusController
{
    public function __construct(
        private GetMenu       $getMenu,
        private CreateMenu    $createMenu,
        private UpdateMenu    $updateMenu,
        private DeleteMenu    $deleteMenu,
        private ListDishes    $listDishes,
        private MenuPresenter $presenter
    ) {}

    public function showMenus(): void
    {
        $menus = $this->getMenu->execute();
        $this->presenter->showList($menus);
    }

    public function showCreateForm(): void
    {
        $dishes = $this->listDishes->execute();
        $this->presenter->showCreateForm($dishes);
    }

    public function create(): void
    {
        if (isset($_POST['nom'], $_POST['createurNom'], $_POST['plats'])) {
            $request = new CreateMenuRequest($_POST['nom'], $_POST['createurNom'], $_POST['plats']);
            $this->createMenu->execute($request);
            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez remplir tous les champs et sélectionner au moins un plat !";
            echo "<br><a href='/menus/create'>Retour</a>";
        }
    }

    public function showEditForm(int $id): void
    {
        $menus = $this->getMenu->execute();
        $menu  = current(array_filter($menus, fn($m) => $m->id == $id));
        if (!$menu) {
            echo "Menu introuvable.";
            return;
        }
        $dishes = $this->listDishes->execute();
        $this->presenter->showEditForm($menu, $dishes);
    }

    public function update(int $id): void
    {
        if (isset($_POST['nom'], $_POST['createurNom'], $_POST['plats'])) {
            $request = new UpdateMenuRequest($id, $_POST['nom'], $_POST['createurNom'], $_POST['plats']);
            $this->updateMenu->execute($request);
            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez remplir tous les champs et sélectionner au moins un plat !";
            echo "<br><a href='/menus/{$id}/edit'>Retour</a>";
        }
    }

    public function delete(int $id): void
    {
        $this->deleteMenu->execute($id);
        header('Location: /menus');
        exit();
    }
}