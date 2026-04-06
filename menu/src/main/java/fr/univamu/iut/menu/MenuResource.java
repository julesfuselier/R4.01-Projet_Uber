package fr.univamu.iut.menu;

import jakarta.annotation.PostConstruct;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;

import java.util.ArrayList;

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

}