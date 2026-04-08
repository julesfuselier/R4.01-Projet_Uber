package fr.univamu.iut.menu.metier;

import jakarta.json.bind.annotation.JsonbProperty;
import jakarta.json.bind.annotation.JsonbPropertyOrder;

import java.time.LocalDate;
import java.util.ArrayList;

@JsonbPropertyOrder({ "id", "nom", "createurId", "createurNom", "dateCreation", "dateMiseAJour", "plats", "prixTotal" })
public class Menu {

    /** Menu's id **/
    @JsonbProperty("id")
    private int id;

    /** Menu's name **/
    @JsonbProperty("nom")
    private String name;

    /** Id of the menu's creator **/
    @JsonbProperty("createurId")
    private int idCreator;

    /** Name of the menu's creator **/
    @JsonbProperty("createurNom")
    private String nameCreator;

    /** Menu's date creation **/
    @JsonbProperty("dateCreation")
    private LocalDate creationDate;

    /** Menu's update date **/
    @JsonbProperty("dateMiseAJour")
    private LocalDate updateDate;

    /** Dish's list **/
    @JsonbProperty("plats")
    private ArrayList<PlatResume> plats;

    /** Menu's total price **/
    @JsonbProperty("prixTotal")
    private double totalPrice;

    public Menu(){}

    /** Menu's constructor **/
    public Menu(String name, int idCreator) {
        this.name = name;
        this.idCreator = idCreator;
        this.creationDate = LocalDate.now();
        this.updateDate = LocalDate.now();
        this.plats = new ArrayList<>();
    }

    /** All menu's getters **/
    public int getId() { return this.id; }
    public String getName() { return this.name; }
    public int getIdCreator() { return this.idCreator; }
    public String getNameCreator() {return this.nameCreator; }
    public LocalDate getCreationDate() { return this.creationDate; }
    public LocalDate getUpdateDate() { return this.updateDate; }
    public ArrayList<PlatResume> getPlats() { return this.plats; }

    public double getTotalPrice() {
        this.totalPrice = plats.stream()
                .mapToDouble(PlatResume::getPrice)
                .sum();
        return totalPrice;
    }

    /** All menu's setters **/
    public void setId(int newId) { this.id = newId; }
    public void setName(String newName) { this.name = newName; }
    public void setIdCreator(int newIdCreator) { this.idCreator = newIdCreator; }
    public void setNameCreator(String newNameCreator) { this.nameCreator = newNameCreator; }
    public void setCreationDate(LocalDate newCreationDate) { this.creationDate = newCreationDate; }
    public void setUpdateDate(LocalDate newUpdateDate) { this.updateDate = newUpdateDate; }
    public void setPlats(ArrayList<PlatResume> newPlats) { this.plats = newPlats; }
    public void setTotalPrice(double newTotalPrice) { this.totalPrice = newTotalPrice; }

    public String allDishesToString() {
        StringBuilder sb = new StringBuilder("Plats{");

        for (int i = 0; i < this.plats.size(); ++i) {
            if (i < this.plats.size()-1) {
                sb.append(this.plats.get(i).toString()).append(",");
            } else {
                sb.append(this.plats.get(i).toString());
            }
        }

        return sb.append("}").toString();
    }

    public void addPlat (PlatResume plat) {
        this.plats.add(plat);
        this.updateDate = LocalDate.now();
    }

    public void removePlat(int platId) {
        this.plats.removeIf(plat -> plat.getId() == platId);
        this.updateDate = LocalDate.now();
    }

    public String toString() {
        return "Menu{" +
                "id='" + this.id + '\'' +
                ", name='" + this.name + '\'' +
                ", createurId='" + this.idCreator + '\'' +
                ", createurNom='" + this.nameCreator + '\'' +
                ", dateCreation='" + this.creationDate + '\'' +
                ", dateMiseAJour='" + this.updateDate + '\'' +
                ", " + this.allDishesToString() +
                ", prixTotal='" + this.getTotalPrice() + '\'' +
                '}';
    }
}
