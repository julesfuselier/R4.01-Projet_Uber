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

    /**
     * Method that return the created Menu
     * @return Menu
     */
    public Menu createMenu(Menu menu);

    /**
     * Method that update the current name and update the update date
     * @param id menu id
     * @param newName menu's new name
     * @return true if menu find, else false
     */
    public boolean updateMenuName(int id, String newName);

    /**
     * Delete menu associated with the id.
     * @param id menu's id deleted
     * @return true if delete success, false if the menu doesn't exist
     */
    public boolean deleteMenu(int id);
}
