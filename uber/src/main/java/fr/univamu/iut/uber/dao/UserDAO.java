package fr.univamu.iut.uber.dao;

import fr.univamu.iut.uber.model.User;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import jakarta.persistence.TypedQuery;
import java.util.List;

@Stateless
public class UserDAO {

    @PersistenceContext(unitName = "UberPU")
    private EntityManager em;

    public void create(User user) {
        em.persist(user);
    }

    public User findById(Long id) {
        return em.find(User.class, id);
    }

    public User findByEmail(String email) {
        TypedQuery<User> query = em.createQuery(
                "SELECT u FROM User u WHERE u.email = :email", User.class);
        query.setParameter("email", email);
        return query.getResultStream().findFirst().orElse(null);
    }

    public List<User> findAll() {
        return em.createQuery("SELECT u FROM User u", User.class).getResultList();
    }

    public User update(User user) {
        return em.merge(user);
    }

    public void delete(Long id) {
        User user = findById(id);
        if (user != null) {
            em.remove(user);
        }
    }
}
