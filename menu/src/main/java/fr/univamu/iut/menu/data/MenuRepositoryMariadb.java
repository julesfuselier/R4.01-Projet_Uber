package fr.univamu.iut.menu.data;

import fr.univamu.iut.menu.api_externe.PlatsUtilisateursClientInterface;
import fr.univamu.iut.menu.metier.PlatResume;
import fr.univamu.iut.menu.api_externe.PlatsUtilisateursClient;
import fr.univamu.iut.menu.metier.Menu;

import java.sql.*;
import java.time.LocalDate;
import java.util.ArrayList;

public class MenuRepositoryMariadb implements MenuRepositoryInterface {

    protected Connection dbConnection;
    private PlatsUtilisateursClientInterface client;

    public MenuRepositoryMariadb(String infoConnection, String user, String pwd) throws java.sql.SQLException, java.lang.ClassNotFoundException {
        Class.forName("org.mariadb.jdbc.Driver");
        dbConnection = DriverManager.getConnection(infoConnection, user, pwd);
        this.client = new PlatsUtilisateursClient();
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
                int id = result.getInt("id");
                String nom = result.getString("nom");
                int createurId = result.getInt("createur_id");
                LocalDate dateCreation = result.getDate("date_creation").toLocalDate();
                LocalDate dateMiseAJour = result.getDate("date_mise_a_jour").toLocalDate();

                selectedMenu = new Menu(nom, createurId);
                selectedMenu.setId(id);
                selectedMenu.setCreationDate(dateCreation);
                selectedMenu.setUpdateDate(dateMiseAJour);

                // Get menu creator from JSON file
                String creatorName = this.client.getUserNameById(createurId);
                selectedMenu.setNameCreator(creatorName);

                // Get all dish from JSON file
                ArrayList<PlatResume> plats = getPlatsForMenu(id);
                for (PlatResume plat : plats) {
                    selectedMenu.addPlat(plat);
                }
            }
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }

        return selectedMenu;
    }

    @Override
    public ArrayList<Menu> getAllMenu() {
        ArrayList<Menu> menuList = null ;

        String query = "SELECT * FROM menu";

        try (PreparedStatement ps = dbConnection.prepareStatement(query)) {
            ResultSet result = ps.executeQuery();

            menuList = new ArrayList<>();

            while (result.next()) {
                int id = result.getInt("id");
                String nom = result.getString("nom");
                int createurId = result.getInt("createur_id");
                LocalDate dateCreation = result.getDate("date_creation").toLocalDate();
                LocalDate dateMiseAJour = result.getDate("date_mise_a_jour").toLocalDate();

                Menu currentMenu = new Menu(nom, createurId);
                currentMenu.setId(id);
                currentMenu.setCreationDate(dateCreation);
                currentMenu.setUpdateDate(dateMiseAJour);

                // Get menu creator from JSON file
                String creatorName = this.client.getUserNameById(createurId);
                currentMenu.setNameCreator(creatorName);

                // Get all dish from JSON file
                ArrayList<PlatResume> plats = getPlatsForMenu(id);
                for (PlatResume plat : plats) {
                    currentMenu.addPlat(plat);
                }

                menuList.add(currentMenu);
            }
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }

        return menuList;
    }

    @Override
    public Menu createMenu(Menu menu) {
        String query = "INSERT INTO menu (nom, createur_id, date_creation, date_mise_a_jour) VALUES (?, ?, ?, ?)";

        try (PreparedStatement ps = dbConnection.prepareStatement(query, Statement.RETURN_GENERATED_KEYS)) {
            ps.setString(1, menu.getName());
            ps.setInt(2, menu.getIdCreator());
            ps.setDate(3, Date.valueOf(menu.getCreationDate()));
            ps.setDate(4, Date.valueOf(menu.getUpdateDate()));

            int rowsAffected = ps.executeUpdate();

            if (rowsAffected == 1) {
                try (ResultSet generatedKeys = ps.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        menu.setId(generatedKeys.getInt(1));
                        return menu;
                    }
                }
            }
        } catch (SQLException e) {
            System.err.print(e.getMessage());
        }

        return null;
    }

    @Override
    public boolean updateMenuName(int id, String newName) {
        String query = "UPDATE menu SET nom=?, date_mise_a_jour=? WHERE id=?";

        try (PreparedStatement ps = dbConnection.prepareStatement(query)) {
            ps.setString(1, newName);
            ps.setDate(2, Date.valueOf(LocalDate.now()));
            ps.setInt(3, id);

            int rowsAffected = ps.executeUpdate();
            return rowsAffected == 1;
        } catch (SQLException e) {
            System.err.println(e.getMessage());
            return false;
        }
    }

    @Override
    public boolean deleteMenu(int id) {
        String queryDeletePlats = "DELETE FROM menu_plat WHERE menu_id=?";
        String queryDeleteMenu = "DELETE FROM menu WHERE id=?";

        try {
            try (PreparedStatement psPlats = dbConnection.prepareStatement(queryDeletePlats)) {
                psPlats.setInt(1, id);
                psPlats.executeUpdate();
            }

            try (PreparedStatement psMenu = dbConnection.prepareStatement(queryDeleteMenu)) {
                psMenu.setInt(1, id);
                int rowsAffected = psMenu.executeUpdate();

                return rowsAffected == 1;
            }
        } catch (SQLException e) {
            System.err.println("Erreur lors de la suppression du menu " + id + " : " + e.getMessage());
            return false;
        }
    }

    @Override
    public boolean isPlatInMenu(int menuId, int platId) {
        String query = "SELECT 1 FROM menu_plat WHERE menu_id=? AND plat_id=?";
        try (PreparedStatement ps = dbConnection.prepareStatement(query)) {
            ps.setInt(1, menuId);
            ps.setInt(2, platId);
            try (ResultSet result = ps.executeQuery()) {
                return result.next();
            }
        }catch (SQLException e) {
            System.err.println(e.getMessage());
            return false;
        }
    }

    @Override
    public boolean addPlatToMenu(int menuId, int platId) {
        String insertLiaison = "INSERT INTO menu_plat (menu_id, plat_id) VALUES (?, ?)";
        String updateDateMenu = "UPDATE menu SET date_mise_a_jou=? WHERE id=?";

        try {
            try (PreparedStatement psInsert = dbConnection.prepareStatement(insertLiaison)) {
                psInsert.setInt(1, menuId);
                psInsert.setInt(2, platId);
                psInsert.executeUpdate();
            }

            try (PreparedStatement psUpdate = dbConnection.prepareStatement(updateDateMenu)) {
                psUpdate.setDate(1, Date.valueOf(LocalDate.now()));
                psUpdate.setInt(2, menuId);
                psUpdate.executeUpdate();
            }

            return true;
        } catch (SQLException e) {
            System.err.println(e.getMessage());
            return false;
        }
    }

    @Override
    public boolean removePlatFromMenu(int menuId, int platId) {
        String deleteLiaision = "DELETE FROM menu_plat WHERE menu_id=? AND plat_id=?";
        String updateDateMenu = "UPDATE menu SET date_mise_a_jour=? WHERE id=?";

        try {
            try (PreparedStatement psDelete = dbConnection.prepareStatement(deleteLiaision)) {
                psDelete.setInt(1, menuId);
                psDelete.setInt(2, platId);

                int rowsAffected = psDelete.executeUpdate();
                if (rowsAffected == 0)
                    return false;
            }

            try (PreparedStatement psUpdate = dbConnection.prepareStatement(updateDateMenu)) {
                psUpdate.setDate(1, Date.valueOf(LocalDate.now()));
                psUpdate.setInt(2, menuId);
                psUpdate.executeUpdate();
            }

            return true;
        } catch (SQLException e) {
            System.err.println(e.getMessage());
            return false;
        }
    }

    private ArrayList<PlatResume> getPlatsForMenu(int menuId) {
        ArrayList<PlatResume> plats = new ArrayList<>();

        String query = "SELECT plat_id FROM menu_plat WHERE menu_id=?";

        try (PreparedStatement ps = dbConnection.prepareStatement(query)) {
            ps.setInt(1, menuId);
            ResultSet result = ps.executeQuery();

            while (result.next()) {
                int platId = result.getInt("plat_id");
                PlatResume plat = this.client.getPlatById(platId);
                if (plat != null) {
                    plats.add(plat);
                }
            }
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }

        return plats;
    }
}
