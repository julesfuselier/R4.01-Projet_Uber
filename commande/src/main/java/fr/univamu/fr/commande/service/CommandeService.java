package fr.univamu.fr.commande.service;

import fr.univamu.fr.commande.model.Commande;
import fr.univamu.fr.commande.model.LigneCommande;
import fr.univamu.fr.commande.model.MenuDTO;
import fr.univamu.fr.commande.model.UtilisateurDTO;
import fr.univamu.fr.commande.repository.CommandeRepository;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import org.eclipse.microprofile.rest.client.inject.RestClient;

import java.time.LocalDateTime;
import java.util.List;

@ApplicationScoped
public class CommandeService {

    @Inject
    private CommandeRepository commandeRepository;

    @Inject
    private MenuClient menuClient;

    @Inject
    private UtilisateurClient utilisateurClient;

    public Commande validerNouvelleCommande(Commande commande) {
        double prixTotal = 0.0;


        commande.setDateCommande(LocalDateTime.now());


        UtilisateurDTO clientAbonne = utilisateurClient.getUtilisateurById(commande.getAbonneId());

        if (clientAbonne == null) {
            throw new IllegalArgumentException("L'utilisateur avec l'ID " + commande.getAbonneId() + " n'existe pas.");
        }

        commande.setAdresseLivraison(clientAbonne.getAdresse());


        if (commande.getLignes() == null || commande.getLignes().isEmpty()) {
            throw new IllegalArgumentException("La commande doit contenir au moins un menu.");
        }

        for (LigneCommande ligne : commande.getLignes()) {
            MenuDTO menu = menuClient.getMenuById(ligne.getMenuId());

            if (menu == null) {
                throw new IllegalArgumentException("Le menu avec l'ID " + ligne.getMenuId() + " est introuvable.");
            }

            ligne.setMenuNom(menu.getNom());
            ligne.setPrixUnitaire(menu.getPrixTotal());

            double prixLigne = menu.getPrixTotal() * ligne.getQuantite();
            ligne.setPrixLigne(prixLigne);

            prixTotal += prixLigne;
        }

        commande.setPrixTotal(prixTotal);

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