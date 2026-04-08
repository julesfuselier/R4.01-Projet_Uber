package fr.univamu.fr.commande.repository;

import fr.univamu.fr.commande.model.Commande;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.persistence.EntityManager;
import jakarta.persistence.EntityManagerFactory;
import jakarta.persistence.Persistence;
import java.util.List;

@ApplicationScoped
public class CommandeRepository {
    static {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            System.out.println("Driver MySQL chargé avec succès !");
        } catch (ClassNotFoundException e) {
            System.err.println("ERREUR : Impossible de trouver le driver MySQL.");
            e.printStackTrace();
        }
    }
    // On crée l'usine de connexion liée au persistence.xml
    private EntityManagerFactory emf = Persistence.createEntityManagerFactory("commande-pu");

    public List<Commande> getAllCommandes() {
        EntityManager em = emf.createEntityManager();
        List<Commande> list = em.createQuery("SELECT c FROM Commande c", Commande.class).getResultList();
        em.close();
        return list;
    }

    public Commande getCommandeById(int id) {
        EntityManager em = emf.createEntityManager();
        Commande c = em.find(Commande.class, id);
        em.close();
        return c;
    }

    public Commande addCommande(Commande commande) {
        EntityManager em = emf.createEntityManager();
        em.getTransaction().begin(); // Début de la transaction
        em.persist(commande);        // Sauvegarde
        em.getTransaction().commit(); // Validation
        em.close();
        return commande;
    }

    public boolean updateCommande(int id, Commande updatedCommande) {
        EntityManager em = emf.createEntityManager();
        em.getTransaction().begin();
        Commande existing = em.find(Commande.class, id);
        if (existing != null) {
            existing.setAdresseLivraison(updatedCommande.getAdresseLivraison());
            existing.setDateLivraison(updatedCommande.getDateLivraison());
            em.merge(existing);
            em.getTransaction().commit();
            em.close();
            return true;
        }
        em.getTransaction().rollback();
        em.close();
        return false;
    }

    public boolean deleteCommande(int id) {
        EntityManager em = emf.createEntityManager();
        em.getTransaction().begin();
        Commande commande = em.find(Commande.class, id);
        if (commande != null) {
            em.remove(commande);
            em.getTransaction().commit();
            em.close();
            return true;
        }
        em.getTransaction().rollback();
        em.close();
        return false;
    }
}