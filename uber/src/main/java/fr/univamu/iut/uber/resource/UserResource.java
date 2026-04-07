package fr.univamu.iut.uber.resource;

import fr.univamu.iut.uber.dao.UserDAO;
import fr.univamu.iut.uber.model.User;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;

import java.util.List;

@Path("/users")
@Produces(MediaType.APPLICATION_JSON)
@Consumes(MediaType.APPLICATION_JSON)
public class UserResource {

    @Inject
    private UserDAO userDAO;

    @GET
    public List<User> getAllUsers() {
        return userDAO.findAll();
    }

    @GET
    @Path("/{id}")
    public Response getUser(@PathParam("id") Long id) {
        User u = userDAO.findById(id);
        if (u != null) {
            return Response.ok(u).build();
        } else {
            return Response.status(Response.Status.NOT_FOUND).build();
        }
    }

    @POST
    public Response createUser(User user) {
        // Optionnel : vérifier si l'email existe déjà via un service
        userDAO.create(user);
        return Response.status(Response.Status.CREATED).entity(user).build();
    }

    @PUT
    @Path("/{id}")
    public Response updateUser(@PathParam("id") Long id, User updatedUser) {
        User existing = userDAO.findById(id);
        if (existing != null) {
            existing.setFirstName(updatedUser.getFirstName());
            existing.setLastName(updatedUser.getLastName());
            existing.setEmail(updatedUser.getEmail());
            // Si on gère le mot de passe, il doit idéalement être re-haché
            existing.setPassword(updatedUser.getPassword());
            existing.setRole(updatedUser.getRole());

            User result = userDAO.update(existing);
            return Response.ok(result).build();
        }
        return Response.status(Response.Status.NOT_FOUND).build();
    }

    @DELETE
    @Path("/{id}")
    public Response deleteUser(@PathParam("id") Long id) {
        User existing = userDAO.findById(id);
        if (existing != null) {
            userDAO.delete(id);
            return Response.noContent().build();
        }
        return Response.status(Response.Status.NOT_FOUND).build();
    }
}
