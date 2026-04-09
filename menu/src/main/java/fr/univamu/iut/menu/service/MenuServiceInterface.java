package fr.univamu.iut.menu.service;

import fr.univamu.iut.menu.metier.Menu;

public interface MenuServiceInterface {

    public String getMenuJSON(int menuId);

    public String getAllMenuJSON();

    public Menu createMenu(String name, int idCreator);

    public Menu updateMenu(int menuId, String newName);

    public boolean deleteMenu(int menuId);

    public Menu addPlatToMenu(int menuId, int platId);

    public Menu removePlatFromMenu(int menuId, int platId);
}
