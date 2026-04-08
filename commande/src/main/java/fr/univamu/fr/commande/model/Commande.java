package fr.univamu.fr.commande.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;
import java.time.LocalDate;
import java.util.List;

@Entity
@Table(name = "commande")
public class Commande {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    @Column(name = "abonne_id")
    private int abonneId;

    @Column(name = "date_commande")
    private LocalDateTime dateCommande;

    @Column(name = "adresse_livraison")
    private String adresseLivraison;

    @Column(name = "date_livraison")
    private LocalDate dateLivraison;

    // La relation avec la table ligne_commande
    @OneToMany(cascade = CascadeType.ALL, orphanRemoval = true)
    @JoinColumn(name = "commande_id")
    private List<LigneCommande> lignes;

    @Column(name = "prix_total")
    private double prixTotal;

    public Commande() {}

    // ... Conserve tous tes Getters et Setters d'avant ...
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getAbonneId() { return abonneId; }
    public void setAbonneId(int abonneId) { this.abonneId = abonneId;
    }
    public LocalDateTime getDateCommande() { return dateCommande; }
    public void setDateCommande(LocalDateTime dateCommande) { this.dateCommande = dateCommande; }

    public String getAdresseLivraison() { return adresseLivraison; }
    public void setAdresseLivraison(String adresseLivraison) { this.adresseLivraison = adresseLivraison; }

    public LocalDate getDateLivraison() { return dateLivraison; }
    public void setDateLivraison(LocalDate dateLivraison) { this.dateLivraison = dateLivraison; }

    public List<LigneCommande> getLignes() { return lignes; }
    public void setLignes(List<LigneCommande> lignes) { this.lignes = lignes; }

    public double getPrixTotal() { return prixTotal; }
    public void setPrixTotal(double prixTotal) { this.prixTotal = prixTotal; }
}