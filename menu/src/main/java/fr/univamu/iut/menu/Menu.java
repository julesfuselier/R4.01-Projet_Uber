package fr.univamu.iut.menu;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

public class Menu {

    /** Menu's id **/
    private int id;

    /** Menu's name **/
    private String name;

    /** Id of the menu's creator **/
    private int idCreator;

    /** Name of the menu's creator **/
    private String nameCreator;

    /** Menu's date creation **/
    private LocalDate creationDate;

    /** Menu's update date **/
    private LocalDate updateDate;

    /** Dish's list **/
    private ArrayList<PlatResume> plats;

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
        return plats.stream()
                .mapToDouble(PlatResume::getPrice)
                .sum();
    }

    /** All menu's setters **/
    public void setName(String newName) { this.name = newName; }
    public void setIdCreator(int newIdCreator) { this.idCreator = newIdCreator; }
    public void setNameCreator(String newNameCreator) { this.nameCreator = newNameCreator; }
    public void setCreationDate(LocalDate newCreationDate) { this.creationDate = newCreationDate; }
    public void setUpdateDate(LocalDate newUpdateDate) { this.updateDate = newUpdateDate; }
    public void setPlats(ArrayList<PlatResume> newPlats) { this.plats = newPlats; }

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
