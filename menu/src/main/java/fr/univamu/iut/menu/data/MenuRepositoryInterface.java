package fr.univamu.iut.menu.data;

import fr.univamu.iut.menu.metier.Menu;

import java.util.ArrayList;

/** Menu Data Access Interface **/
public interface MenuRepositoryInterface {

    /** A method for closing the repository where menu information is stored **/
    public void close();

    /**
     * Method that returns the menu whose ID is passed as a parameter
     * @param id
     * @return a Menu object representing the desired menu
     */
    public Menu getMenu(int id);

    /**
     * Method that returns a list of all menus
     * @return list of Menu
     */
    public ArrayList<Menu> getAllMenu();
}
