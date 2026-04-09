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
use UseCase\User\GetUser;

/**
 * Gère les requêtes HTTP liées aux menus (CRUD).
 */
class MenusController
{
    public function __construct(
        private GetMenu       $getMenu,
        private CreateMenu    $createMenu,
        private UpdateMenu    $updateMenu,
        private DeleteMenu    $deleteMenu,
        private ListDishes    $listDishes,
        private GetUser       $getUser,
        private MenuPresenter $presenter
    ) {}

    /** Affiche la liste des menus. */
    public function showMenus(): void
    {
        $menus = $this->getMenu->execute();
        $this->presenter->showList($menus);
    }

    /** Affiche le formulaire de création d'un menu. */
    public function showCreateForm(): void
    {
        $users  = $this->getUser->execute();
        $dishes = $this->listDishes->execute();
        $this->presenter->showCreateForm($users, $dishes);
    }

    /** Traite la soumission du formulaire de création et redirige vers /menus. */
    public function create(): void
    {
        if (isset($_POST['nom'], $_POST['creatorId'])) {
            $dishIds = $_POST['plats'] ?? [];
            $request = new CreateMenuRequest($_POST['nom'], (int) $_POST['creatorId'], $dishIds);
            $this->createMenu->execute($request);
            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez remplir tous les champs !";
            echo "<br><a href='/menus/create'>Retour</a>";
        }
    }

    /** Affiche le formulaire d'édition pour le menu identifié par $id. */
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

    /** Traite la soumission du formulaire d'édition et redirige vers /menus. */
    public function update(int $id): void
    {
        if (isset($_POST['nom'])) {
            $dishIds = $_POST['plats'] ?? [];
            $request = new UpdateMenuRequest($id, $_POST['nom'], $dishIds);
            $this->updateMenu->execute($request);
            header('Location: /menus');
            exit();
        } else {
            echo "Erreur : Vous devez renseigner le nom du menu.";
            echo "<br><a href='/menus/{$id}/edit'>Retour</a>";
        }
    }

    /** Supprime le menu et redirige vers /menus. */
    public function delete(int $id): void
    {
        $this->deleteMenu->execute($id);
        header('Location: /menus');
        exit();
    }
}