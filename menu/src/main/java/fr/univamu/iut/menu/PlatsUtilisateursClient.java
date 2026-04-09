package fr.univamu.iut.menu;

import fr.univamu.iut.menu.metier.PlatResume;
import jakarta.json.Json;
import jakarta.json.JsonObject;
import jakarta.json.JsonReader;
import jakarta.json.JsonValue;

import java.io.StringReader;
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.time.Duration;

public class PlatsUtilisateursClient {

    private final HttpClient httpClient;

    private final String baseUrl = "http://localhost:3000";

    public PlatsUtilisateursClient() {
        this.httpClient = HttpClient.newBuilder()
                .connectTimeout(Duration.ofSeconds(5))
                .build();
    }

    public String getUserNameById(int id) {
        try {
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(baseUrl + "/utilisateurs/" + id))
                    .GET()
                    .build();

            HttpResponse<String> response = httpClient.send(request, HttpResponse.BodyHandlers.ofString());

            if (response.statusCode() == 200) {
                try (JsonReader jsonReader = Json.createReader(new StringReader(response.body()))) {
                    JsonObject userObject = jsonReader.readObject();
                    return userObject.getString("nom");
                }
            }
        } catch (Exception e) {
            System.err.println("Erreur lors de la récupération de l'utilisateur " + id + " : " + e.getMessage());
        }

        return null;
    }

    public PlatResume getPlatById(int id) {
        try {
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(baseUrl + "/plats/" + id))
                    .GET()
                    .build();

            HttpResponse<String> response = httpClient.send(request, HttpResponse.BodyHandlers.ofString());

            if (response.statusCode() == 200) {
                try (JsonReader jsonReader = Json.createReader(new StringReader(response.body()))) {
                    JsonObject platObject = jsonReader.readObject();
                    int platID;
                    if (platObject.get("id").getValueType() == JsonValue.ValueType.NUMBER) {
                        platID = platObject.getInt("id");
                    } else {
                        platID = Integer.parseInt(platObject.getString("id"));
                    }

                    double platPrice;
                    if (platObject.get("prix").getValueType() == jakarta.json.JsonValue.ValueType.NUMBER) {
                        platPrice = platObject.getJsonNumber("prix").doubleValue();
                    } else {
                        platPrice = Double.parseDouble(platObject.getString("prix"));
                    }

                    return new PlatResume(
                            platID,
                            platObject.getString("nom"),
                            platPrice
                    );
                }
            }
        } catch (Exception e) {
            System.err.println("Erreur lors de la récupération du plat " + id + " : " + e.getMessage());
        }

        return null;
    }

    public boolean userExistsById(int id) {
//        try {
//            HttpRequest request = HttpRequest.newBuilder()
//                    .uri(URI.create(baseUrl + "/utilisateurs/" + id))
//                    .method("HEAD", HttpRequest.BodyPublishers.noBody())
//                    .build();
//
//            HttpResponse<Void> response = httpClient.send(request, HttpResponse.BodyHandlers.discarding());
//            return response.statusCode() == 200;
//        } catch (Exception e) {
//            return false;
//        }
        return (this.getUserNameById(id) != null);
    }

    public boolean platExistsById(int id) {
//        try {
//            HttpRequest request = HttpRequest.newBuilder()
//                    .uri(URI.create(baseUrl + "/plats/" + id))
//                    .method("HEAD", HttpRequest.BodyPublishers.noBody())
//                    .build();
//
//            HttpResponse<Void> response = httpClient.send(request, HttpResponse.BodyHandlers.discarding());
//            return response.statusCode() == 200;
//        } catch (Exception e) {
//            return false;
//        }

        return (this.getPlatById(id) != null);
    }
}
