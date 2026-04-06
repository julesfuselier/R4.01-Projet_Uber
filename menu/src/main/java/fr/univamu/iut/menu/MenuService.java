package fr.univamu.iut.menu;

import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;

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
    public String getBookJSON(int menuId) {
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
}
