package fr.univamu.fr.commande.model;

import jakarta.persistence.*;

@Entity
@Table(name = "ligne_commande")
public class LigneCommande {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    @Column(name = "menu_id")
    private int menuId;

    @Column(name = "menu_nom")
    private String menuNom;

    private int quantite;

    @Column(name = "prix_unitaire")
    private double prixUnitaire;

    @Column(name = "prix_ligne")
    private double prixLigne;

    public LigneCommande() {}

    // Ajoute le Getter et Setter pour 'id'
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    // ... Conserve tous les autres Getters et Setters que tu avais déjà mis (menuId, menuNom, etc.)
    public int getMenuId() { return menuId; }
    public void setMenuId(int menuId) { this.menuId = menuId; }
    public String getMenuNom() { return menuNom; }
    public void setMenuNom(String menuNom) { this.menuNom = menuNom; }
    public int getQuantite() { return quantite; }
    public void setQuantite(int quantite) { this.quantite = quantite; }
    public double getPrixUnitaire() { return prixUnitaire; }
    public void setPrixUnitaire(double prixUnitaire) { this.prixUnitaire = prixUnitaire; }
    public double getPrixLigne() { return prixLigne; }
    public void setPrixLigne(double prixLigne) { this.prixLigne = prixLigne; }
}