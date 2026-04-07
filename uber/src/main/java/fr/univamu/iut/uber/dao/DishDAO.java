package fr.univamu.iut.uber.dao;

import fr.univamu.iut.uber.model.Dish;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import jakarta.persistence.TypedQuery;
import java.util.List;

@Stateless
public class DishDAO {

    @PersistenceContext(unitName = "UberPU")
    private EntityManager em;

    public void create(Dish dish) {
        em.persist(dish);
    }

    public Dish findById(Long id) {
        return em.find(Dish.class, id);
    }

    public List<Dish> findAll() {
        return em.createQuery("SELECT d FROM Dish d", Dish.class).getResultList();
    }

    public List<Dish> findByOwner(Long ownerId) {
        TypedQuery<Dish> query = em.createQuery(
                "SELECT d FROM Dish d WHERE d.owner.id = :ownerId", Dish.class);
        query.setParameter("ownerId", ownerId);
        return query.getResultList();
    }

    public Dish update(Dish dish) {
        return em.merge(dish);
    }

    public void delete(Long id) {
        Dish dish = findById(id);
        if (dish != null) {
            em.remove(dish);
        }
    }
}
