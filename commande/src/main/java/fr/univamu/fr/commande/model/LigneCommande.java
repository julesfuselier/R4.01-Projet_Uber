package fr.univamu.fr.commande.model;

public class LigneCommande {
    private int menuId;
    private String menuNom;
    private int quantite;
    private double prixUnitaire;
    private double prixLigne;

    // regroupe toutes les informations de la livraison
    public LigneCommande() {}

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