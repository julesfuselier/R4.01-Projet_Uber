package fr.univamu.iut.menu.service;

import fr.univamu.iut.menu.PlatsUtilisateursClient;
import fr.univamu.iut.menu.data.MenuRepositoryInterface;
import fr.univamu.iut.menu.metier.Menu;
import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;

import java.util.ArrayList;

public class MenuService {

    protected MenuRepositoryInterface menuRepo;

    private PlatsUtilisateursClient client;

    public MenuService(MenuRepositoryInterface menuRepo) {
        this.menuRepo = menuRepo;
        this.client = new PlatsUtilisateursClient();
    }

    /**
     * Method returning the selected menu on JSON format
     * @param menuId
     * @return a string on JSON format
     */
    public String getMenuJSON(int menuId) {
        String result = null;
        Menu myMenu = menuRepo.getMenu(menuId);

        if (myMenu != null) {
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(myMenu);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }
        }

        return result;
    }

    /**
     * Method returning all menus
     * @return a string on JSON format
     */
    public String getAllMenuJSON() {
        ArrayList<Menu> allMenu = menuRepo.getAllMenu();

        String result = null;

        try (Jsonb jsonb = JsonbBuilder.create()) {
            result = jsonb.toJson(allMenu);
        } catch (Exception e) {
            System.err.println(e.getMessage());
        }

        return result;
    }

    public Menu createMenu(String name, int idCreator) {

        if (name == null || name.trim().isEmpty() || idCreator <= 0) {
            throw new IllegalArgumentException("Données d'entrée invalides");
        }

        String creatorName = this.client.getUserNameById(idCreator);
        if (creatorName == null)
            return null;

        Menu newMenu = new Menu(name, idCreator);
        newMenu.setNameCreator(creatorName);

        return this.menuRepo.createMenu(newMenu);
    }

    public Menu updateMenu(int menuId, String newName) {
        if (newName == null || newName.trim().isEmpty())
            throw new IllegalArgumentException("Le nouveau nom est requis");

        boolean isUpdated = this.menuRepo.updateMenuName(menuId, newName);

        if (!isUpdated)
            return null;

        return this.menuRepo.getMenu(menuId);
    }

    public boolean deleteMenu(int menuId) {
        return this.menuRepo.deleteMenu(menuId);
    }

    public Menu addPlatToMenu(int menuId, int platId) {
        Menu menu = this.menuRepo.getMenu(menuId);
        if (menu == null)
            throw new IllegalArgumentException("Menu introuvable");

        if (!this.client.platExistsById(platId))
            throw new IllegalArgumentException("Plat introuvable dans l'API");

        if (this.menuRepo.isPlatInMenu(menuId, platId))
            throw new IllegalStateException("Le plat est déjà présent dans ce menu");

        boolean success = this.menuRepo.addPlatToMenu(menuId, platId);

        if (success)
            return this.menuRepo.getMenu(menuId);

        return null;
    }

}
