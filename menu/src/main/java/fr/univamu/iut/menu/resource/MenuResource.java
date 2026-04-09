package fr.univamu.iut.menu.resource;

import fr.univamu.iut.menu.MenuInput;
import fr.univamu.iut.menu.data.MenuRepositoryInterface;
import fr.univamu.iut.menu.metier.Menu;
import fr.univamu.iut.menu.service.MenuService;
import jakarta.annotation.PostConstruct;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.Response;

import java.net.ResponseCache;
import java.net.URI;

@Path("/menus")
@ApplicationScoped
public class MenuResource {

    @Inject
    private MenuRepositoryInterface menuRepo;

    private MenuService menuService;

    public MenuResource() {}

    @PostConstruct
    public void init() {
        this.menuService = new MenuService(menuRepo);
    }

    /**
     * Constructeur permettant d'initialiser le service avec une interface d'accès aux données
     * @param menuRepo objet implémentant l'interface d'accès aux données
     */
    public MenuResource ( MenuRepositoryInterface menuRepo ){
        this.menuService = new MenuService(menuRepo) ;
    }

    /**
     * Constructeur permettant d'initialiser le service d'accès aux livres
     */
    public MenuResource( MenuService menuService ){
        this.menuService = menuService;
    }

    @GET
    @Produces("application/json")
    public String getAllMenuJSON() {
        return this.menuService.getAllMenuJSON();
    }

    @GET
    @Path("{id}")
    @Produces("application/json")
    public String getMenu(@PathParam("id") int menuId) {
        String result = this.menuService.getMenuJSON(menuId);

        if (result == null)
            throw new NotFoundException();

        return result;
    }

    @POST
    @Consumes("application/json")
    @Produces("application/json")
    public Response createMenu(MenuInput input) throws Exception {
        try {
            if (input == null || input.name == null)
                return Response.status(Response.Status.BAD_REQUEST).entity("Le nom du menu est requis").build();

            Menu createdMenu = this.menuService.createMenu(input.name, input.creatorId);

            if (createdMenu == null)
                return Response.status(Response.Status.NOT_FOUND).entity("Créateur introuvable dans l'API Plats et Utilisateurs").build();

            String result = null;
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(createdMenu);
            }

            URI location = URI.create("menus/" + createdMenu.getId());
            return Response.status(Response.Status.CREATED)
                    .location(location)
                    .entity(result)
                    .build();
        } catch (IllegalArgumentException e) {
            return Response.status(Response.Status.BAD_REQUEST).entity(e.getMessage()).build();
        }
    }

    @PUT
    @Path("{id}")
    @Consumes("application/json")
    @Produces("application/json")
    public Response updateMenu(@PathParam("id") int id, MenuInput input) {
        try {
            if (input == null || input.name == null)
                return Response.status(Response.Status.BAD_REQUEST)
                        .entity("Les données envoyées sont invalides (nom manquant)")
                        .build();

            Menu updatedMenu = this.menuService.updateMenu(id, input.name);

            if (updatedMenu == null)
                return Response.status(Response.Status.NOT_FOUND)
                        .entity("Menu introuvable")
                        .build();

            String result = null;
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(updatedMenu);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }

            return Response.ok(result).build();
        } catch (IllegalArgumentException e) {
            return Response.status(Response.Status.BAD_REQUEST).entity(e.getMessage()).build();
        }
    }

    @DELETE
    @Path("{id}")
    public Response deleteMenu(@PathParam("id") int id) {
        boolean isDeleted = this.menuService.deleteMenu(id);

        if (!isDeleted)
            return Response.status(Response.Status.NOT_FOUND)
                    .entity("Menu introuvable")
                    .build();

        return Response.noContent().build();
    }

    @PUT
    @Path("{id}/plats/{platId}")
    @Produces("application/json")
    public Response addPlatToMenu(@PathParam("id") int menuId, @PathParam("platId") int platId) {
        try {
            Menu updatedMenu = this.menuService.addPlatToMenu(menuId, platId);

            String result = null;
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(updatedMenu);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }

            return Response.ok(result).build();
        } catch (IllegalArgumentException e) {
            return Response.status(Response.Status.NOT_FOUND).entity(e.getMessage()).build();
        } catch (IllegalStateException e) {
            return Response.status(Response.Status.CONFLICT).entity(e.getMessage()).build();
        }
    }

    @DELETE
    @Path("{id}/plats/{platId}")
    @Produces("application/json")
    public Response removePlatFromMenu(@PathParam("id") int menuId, @PathParam("platId") int platId) {
        try {
            Menu updateMenu = this.menuService.removePlatFromMenu(menuId, platId);

            if (updateMenu == null)
                return Response.status(Response.Status.INTERNAL_SERVER_ERROR)
                        .entity("Erreur lors de la suppression du plat")
                        .build();

            String result = null;
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(updateMenu);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }

            return Response.ok(result).build();
        } catch (IllegalArgumentException e) {
            return Response.status(Response.Status.NOT_FOUND).entity(e.getMessage()).build();
        }
    }

}