package fr.univamu.iut.menu;

import jakarta.enterprise.inject.Produces;
import jakarta.json.bind.annotation.JsonbProperty;

public class PlatResume {

    /** Dish's id **/
    @JsonbProperty("id")
    private int id;

    /** Dish's name **/
    @JsonbProperty("nom")
    private String name;

    /** Dish's price **/
    @JsonbProperty("prix")
    private double price;

    /** Dish's constructor for Jakarta **/
    public PlatResume() {}

    /** Dish's constructor **/
    public PlatResume(int id, String name, double price) {
        this.id = id;
        this.name = name;
        this.price = price;
    }

    /** All dish's getters **/
    public int getId() { return this.id; }
    public String getName() { return this.name; }
    public double getPrice() { return this.price; }

    /** All dish's setters **/
    public void setId(int newId) { this.id = newId; }
    public void setName(String newName) { this.name = newName; }
    public void setPrice(double newPrice) {this.price = newPrice; }

    /** Dish's to string **/
    public String toString() {
        return "Plat{" +
                "id='" + this.id + '\'' +
                ", nom='" + this.name + '\'' +
                ", prix='" + this.price + '\'' +
                '}';
    }
}
