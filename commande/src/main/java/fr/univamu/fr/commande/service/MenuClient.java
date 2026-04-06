package fr.univamu.fr.commande.service;

import fr.univamu.fr.commande.model.MenuDTO;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;

@ApplicationScoped
public class MenuClient {

    // L'url de l'api menu
    private static final String MENU_API_URL = "http://localhost:3004/menus";

    public MenuDTO getMenuById(int id) {
        try (Client client = ClientBuilder.newClient()) {
            Response response = client.target(MENU_API_URL)
                    .path(String.valueOf(id))
                    .request(MediaType.APPLICATION_JSON)
                    .get();

            if (response.getStatus() == 200) {
                // Si le menu existe, on le convertit en objet MenuDTO
                return response.readEntity(MenuDTO.class);
            } else {
                // Si le menu n'est pas trouvé (ex: erreur 404)
                return null;
            }
        } catch (Exception e) {
            System.err.println("Erreur de connexion à l'API Menus : " + e.getMessage());
            return null;
        }
    }
}