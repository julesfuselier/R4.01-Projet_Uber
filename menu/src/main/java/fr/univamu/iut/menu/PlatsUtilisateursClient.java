package fr.univamu.iut.menu;

import fr.univamu.iut.menu.metier.PlatResume;
import jakarta.json.Json;
import jakarta.json.JsonArray;
import jakarta.json.JsonObject;

import java.io.InputStream;

public class PlatsUtilisateursClient {

    private JsonArray plats;
    private JsonArray utilisateurs;

    public PlatsUtilisateursClient() {
        InputStream inputStream = getClass()
                .getClassLoader()
                .getResourceAsStream("plats-utilisateurs.json");

        if (inputStream == null) {
            throw new RuntimeException(
                    "Fichier plats-utilisateurs.json introuvable dans le classpath !"
            );
        }

        JsonObject data = Json.createReader(inputStream).readObject();
        this.plats = data.getJsonArray("plats");
        this.utilisateurs = data.getJsonArray("utilisateurs");
    }

    /** return user by id **/
    public String getUserNameById(int id) {
        for (JsonObject user : utilisateurs.getValuesAs(JsonObject.class)) {
            if (user.getInt("id") == id) {
                return user.getString("nom");
            }
        }
        return null;
    }

    /** return resum plat by id **/
    public PlatResume getPlatById(int id) {
        for (JsonObject plat : plats.getValuesAs(JsonObject.class)) {
            if (plat.getInt("id") == id) {
                return new PlatResume(plat.getInt("id"), plat.getString("nom"), plat.getJsonNumber("prix").doubleValue());
            }
        }
        return null;
    }

    /** verify if user exists **/
    public boolean userExistsById(int id) {
        for (JsonObject user : utilisateurs.getValuesAs(JsonObject.class)) {
            if (user.getInt("id") == id) {
                return true;
            }
        }
        return false;
    }

    /** verify if dish exists **/
    public boolean platExistsById(int id) {
        for (JsonObject plat : plats.getValuesAs(JsonObject.class)) {
            if (plat.getInt("id") == id) {
                return true;
            }
        }
        return false;
    }
}
