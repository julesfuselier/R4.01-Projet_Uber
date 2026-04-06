package fr.univamu.fr.commande.model;

import java.time.LocalDateTime;
import java.time.LocalDate;
import java.util.List;

// Detail d'un menu commandé
public class Commande {
    private int id;
    private int abonneId;
    private LocalDateTime dateCommande; // L'horodatage généré par le serveur
    private String adresseLivraison;
    private LocalDate dateLivraison;
    private List<LigneCommande> lignes;
    private double prixTotal;

    public Commande() {}

    // Getters et Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getAbonneId() { return abonneId; }
    public void setAbonneId(int abonneId) { this.abonneId = abonneId; }

    public LocalDateTime getDateCommande() { return dateCommande; }
    public void setDateCommande(LocalDateTime dateCommande) { this.dateCommande = dateCommande; }

    public String getAdresseLivraison() { return adresseLivraison; }
    public void setAdresseLivraison(String adresseLivraison) { this.adresseLivraison = adresseLivraison; }

    public LocalDate getDategiLivraison() { return dateLivraison; }
    public void setDateLivraison(LocalDate dateLivraison) { this.dateLivraison = dateLivraison; }

    public List<LigneCommande> getLignes() { return lignes; }
    public void setLignes(List<LigneCommande> lignes) { this.lignes = lignes; }

    public double getPrixTotal() { return prixTotal; }
    public void setPrixTotal(double prixTotal) { this.prixTotal = prixTotal; }
}