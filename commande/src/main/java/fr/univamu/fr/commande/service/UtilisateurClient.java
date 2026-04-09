package fr.univamu.fr.commande.service;

import fr.univamu.fr.commande.model.UtilisateurDTO;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.core.MediaType;

@ApplicationScoped
public class UtilisateurClient {

    private static final String BASE_URL = "http://localhost:3003/utilisateurs";

    public UtilisateurDTO getUtilisateurById(int id) {
        try (Client client = ClientBuilder.newClient()) {
            return client.target(BASE_URL)
                    .path(String.valueOf(id))
                    .request(MediaType.APPLICATION_JSON)
                    .get(UtilisateurDTO.class);
        } catch (Exception e) {
            System.err.println("Erreur API Utilisateur : " + e.getMessage());
            return null;
        }
    }
}