package fr.univamu.iut.uber.resource;

import fr.univamu.iut.uber.dao.DishDAO;
import fr.univamu.iut.uber.dao.UserDAO;
import fr.univamu.iut.uber.model.Dish;
import fr.univamu.iut.uber.model.User;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;

import java.util.List;

@Path("/dishes")
@Produces(MediaType.APPLICATION_JSON)
@Consumes(MediaType.APPLICATION_JSON)
public class DishResource {

    @Inject
    private DishDAO dishDAO;

    @Inject
    private UserDAO userDAO;

    @GET
    public List<Dish> getAllDishes() {
        return dishDAO.findAll();
    }

    @GET
    @Path("/{id}")
    public Response getDish(@PathParam("id") Long id) {
        Dish d = dishDAO.findById(id);
        if (d != null) {
            return Response.ok(d).build();
        }
        return Response.status(Response.Status.NOT_FOUND).build();
    }

    @GET
    @Path("/owner/{id}")
    public List<Dish> getDishesByOwner(@PathParam("id") Long ownerId) {
        return dishDAO.findByOwner(ownerId);
    }

    /**
     * Pour créer un plat, l'ID de l'utilisateur (owner) est passé en paramètre.
     * JSON attendu : { "name": "Pizza", "description": "...", "price": 12.5,
     * "isAvailable": true }
     */
    @POST
    @Path("/owner/{ownerId}")
    public Response createDish(@PathParam("ownerId") Long ownerId, Dish dish) {
        User owner = userDAO.findById(ownerId);

        if (owner == null) {
            return Response.status(Response.Status.BAD_REQUEST).entity("User not found.").build();
        }

        dish.setOwner(owner);
        dishDAO.create(dish);

        return Response.status(Response.Status.CREATED).entity(dish).build();
    }

    @PUT
    @Path("/{id}")
    public Response updateDish(@PathParam("id") Long id, Dish updatedDish) {
        Dish existing = dishDAO.findById(id);
        if (existing != null) {
            existing.setName(updatedDish.getName());
            existing.setDescription(updatedDish.getDescription());
            existing.setPrice(updatedDish.getPrice());
            existing.setIsAvailable(updatedDish.getIsAvailable());

            Dish result = dishDAO.update(existing);
            return Response.ok(result).build();
        }
        return Response.status(Response.Status.NOT_FOUND).build();
    }

    @DELETE
    @Path("/{id}")
    public Response deleteDish(@PathParam("id") Long id) {
        Dish existing = dishDAO.findById(id);
        if (existing != null) {
            dishDAO.delete(id);
            return Response.noContent().build();
        }
        return Response.status(Response.Status.NOT_FOUND).build();
    }
}
