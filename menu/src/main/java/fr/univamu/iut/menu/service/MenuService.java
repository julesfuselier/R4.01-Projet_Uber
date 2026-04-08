package fr.univamu.iut.menu.service;

import fr.univamu.iut.menu.data.MenuRepositoryInterface;
import fr.univamu.iut.menu.metier.Menu;
import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;

import java.util.ArrayList;

public class MenuService {

    protected MenuRepositoryInterface menuRepo;

    public MenuService(MenuRepositoryInterface menuRepo) {
        this.menuRepo = menuRepo;
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
}
