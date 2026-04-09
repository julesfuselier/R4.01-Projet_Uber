package fr.univamu.fr.commande.service;

import fr.univamu.fr.commande.model.PlatDTO;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.core.MediaType;

@ApplicationScoped
public class PlatClient {

    private static final String BASE_URL = "http://localhost:3003/plats";

    public PlatDTO getPlatById(int id) {
        try (Client client = ClientBuilder.newClient()) {
            return client.target(BASE_URL)
                    .path(String.valueOf(id))
                    .request(MediaType.APPLICATION_JSON)
                    .get(PlatDTO.class);
        } catch (Exception e) {
            System.err.println("Erreur API Plat : " + e.getMessage());
            return null;
        }
    }
}