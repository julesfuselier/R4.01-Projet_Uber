package fr.univamu.fr.commande.repository;

import fr.univamu.fr.commande.model.Commande;
import jakarta.enterprise.context.ApplicationScoped;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.atomic.AtomicInteger;

@ApplicationScoped
public class CommandeRepository {

    // Notre fausse base de données en mémoire (Thread-safe)
    private Map<Integer, Commande> commandesDB = new ConcurrentHashMap<>();

    // Un compteur pour générer automatiquement les ID des commandes (1, 2, 3...)
    private AtomicInteger idCounter = new AtomicInteger(1);


     // Récupère toutes les commandes enregistrées

    public List<Commande> getAllCommandes() {
        return new ArrayList<>(commandesDB.values());
    }

    //Récupère une commande spécifique par son ID

    public Commande getCommandeById(int id) {
        return commandesDB.get(id);
    }

    /**
     * Sauvegarde une nouvelle commande et lui attribue un ID
     */
    public Commande addCommande(Commande commande) {
        int id = idCounter.getAndIncrement();
        commande.setId(id);
        commandesDB.put(id, commande);
        return commande;
    }

    // Met à jour une commande existante

    public boolean updateCommande(int id, Commande commande) {
        if (commandesDB.containsKey(id)) {
            // On s'assure que l'ID ne change pas
            commande.setId(id);
            commandesDB.put(id, commande);
            return true;
        }
        return false; // La commande n'existait pas
    }

    //Supprime une commande

    public boolean deleteCommande(int id) {
        return commandesDB.remove(id) != null;
    }
}