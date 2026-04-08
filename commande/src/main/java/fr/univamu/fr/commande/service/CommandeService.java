package fr.univamu.fr.commande.service;

import fr.univamu.fr.commande.model.Commande;
import fr.univamu.fr.commande.model.LigneCommande;
import fr.univamu.fr.commande.model.MenuDTO;
import fr.univamu.fr.commande.repository.CommandeRepository;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import java.time.LocalDateTime;
import java.util.List;

@ApplicationScoped
public class CommandeService {

    // On injecte l'accès à la base de données
    @Inject
    private CommandeRepository commandeRepository;

    // On injecte le client pour interroger l'API Menus
    @Inject
    private MenuClient menuClient;


    public Commande validerNouvelleCommande(Commande commande) {
        double prixTotal = 0.0;

        // 1. La date de commande est enregistrée automatiquement côté serveur
        commande.setDateCommande(LocalDateTime.now());

        // Vérification de sécurité
        if (commande.getLignes() == null || commande.getLignes().isEmpty()) {
            throw new IllegalArgumentException("La commande doit contenir au moins un menu.");
        }

        // 2. Parcourir chaque ligne pour vérifier le menu et calculer le prix
        for (LigneCommande ligne : commande.getLignes()) {

            // On interroge l'API Menus distante
            MenuDTO menu = menuClient.getMenuById(ligne.getMenuId());

            if (menu == null) {
                // Si le menu n'existe pas, on lève une erreur
                throw new IllegalArgumentException("Le menu avec l'ID " + ligne.getMenuId() + " est introuvable.");
            }

            // On fait une "photographie" du nom et du prix du menu au moment de la commande
            ligne.setMenuNom(menu.getNom());
            ligne.setPrixUnitaire(menu.getPrix());

            // Calcul du prix de cette ligne (prix unitaire x quantité)
            double prixLigne = menu.getPrix() * ligne.getQuantite();
            ligne.setPrixLigne(prixLigne);

            // On ajoute ce montant au total global de la commande
            prixTotal += prixLigne;
        }

        // 3. Assigner le prix total calculé à la commande
        commande.setPrixTotal(prixTotal);

        // 4. Sauvegarder la commande validée en base de données
        return commandeRepository.addCommande(commande);
    }


    public List<Commande> getAllCommandes() {
        return commandeRepository.getAllCommandes();
    }

    public Commande getCommandeById(int id) {
        return commandeRepository.getCommandeById(id);
    }

    public boolean updateCommande(int id, Commande commande) {
        return commandeRepository.updateCommande(id, commande);
    }

    public boolean deleteCommande(int id) {
        return commandeRepository.deleteCommande(id);
    }
}