package fr.univamu.iut.menu.api_externe;

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

public class PlatsUtilisateursClient implements PlatsUtilisateursClientInterface {

    private final HttpClient httpClient;

    private final String baseUrl = "http://localhost:8080/uber/api/";

    public PlatsUtilisateursClient() {
        this.httpClient = HttpClient.newBuilder()
                .connectTimeout(Duration.ofSeconds(5))
                .build();
    }

    public String getUserNameById(int id) {
        try {
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(baseUrl + "users/" + id))
                    .GET()
                    .build();

            HttpResponse<String> response = httpClient.send(request, HttpResponse.BodyHandlers.ofString());

            if (response.statusCode() == 200) {
                try (JsonReader jsonReader = Json.createReader(new StringReader(response.body()))) {
                    JsonObject userObject = jsonReader.readObject();
                    String firstName = userObject.getString("firstName", "");
                    String lastName = userObject.getString("lastName", "");
                    return (firstName + " " + lastName).trim();
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
                    .uri(URI.create(baseUrl + "dishes/" + id))
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
                    if (platObject.get("price").getValueType() == jakarta.json.JsonValue.ValueType.NUMBER) {
                        platPrice = platObject.getJsonNumber("price").doubleValue();
                    } else {
                        platPrice = Double.parseDouble(platObject.getString("price"));
                    }

                    return new PlatResume(
                            platID,
                            platObject.getString("name"),
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
        return (this.getUserNameById(id) != null);
    }

    public boolean platExistsById(int id) {
        return (this.getPlatById(id) != null);
    }
}
