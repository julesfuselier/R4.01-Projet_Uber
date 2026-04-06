package fr.univamu.iut.menu;

import java.sql.*;
import java.time.LocalDate;
import java.util.ArrayList;

public class MenuRepositoryMariadb implements MenuRepositoryInterface {

    protected Connection dbConnection;

    public MenuRepositoryMariadb(String infoConnection, String user, String pwd) throws java.sql.SQLException, java.lang.ClassNotFoundException {
        Class.forName("org.mariadb.jdbc.Driver");
        dbConnection = DriverManager.getConnection(infoConnection, user, pwd);
    }

    @Override
    public void close() {
        try {
            dbConnection.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
    }

    @Override
    public Menu getMenu(int menuId) {
        Menu selectedMenu = null;

        String query = "SELECT * FROM menu WHERE id=?";

        try (PreparedStatement ps = dbConnection.prepareStatement(query)) {
            ps.setInt(1, menuId);

            ResultSet result = ps.executeQuery();

            if (result.next()) {
                int id = Integer.parseInt(result.getString("id"));
                String nom = result.getString("nom");
                int createur_id = Integer.parseInt(result.getString("createur_id"));
                LocalDate date_creation = LocalDate.parse(result.getString("date_creation"));
                LocalDate date_mise_a_jour = LocalDate.parse(result.getString("date_mise_a_jour"));

                selectedMenu = new Menu(nom, createur_id);
                selectedMenu.setId(id);
                selectedMenu.setCreationDate(date_creation);
                selectedMenu.setUpdateDate(date_mise_a_jour);
            }
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }

        return selectedMenu;
    }

    @Override
    public ArrayList<Menu> getAllMenu() {
        return null;
    }
}
