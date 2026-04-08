package fr.univamu.iut.menu.data;

import fr.univamu.iut.menu.metier.PlatResume;
import fr.univamu.iut.menu.PlatsUtilisateursClient;
import fr.univamu.iut.menu.metier.Menu;

import java.sql.*;
import java.time.LocalDate;
import java.util.ArrayList;

public class MenuRepositoryMariadb implements MenuRepositoryInterface {

    protected Connection dbConnection;
    private PlatsUtilisateursClient client;

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
