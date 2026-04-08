package fr.univamu.fr.commande;

import fr.univamu.fr.commande.model.Commande;
import fr.univamu.fr.commande.service.CommandeService;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import java.net.URI;
import java.util.List;

@Path("/commandes")
@Produces(MediaType.APPLICATION_JSON)
@Consumes(MediaType.APPLICATION_JSON)
public class CommandeResource {

    @Inject
    private CommandeService commandeService;


    @GET
    public Response listerCommandes(@QueryParam("abonneId") Integer abonneId) {
        List<Commande> commandes = commandeService.getAllCommandes();

        // Si un abonneId est fourni dans l'URL, on filtre la liste
        if (abonneId != null) {
            commandes = commandes.stream()
                    .filter(c -> c.getAbonneId() == abonneId)
                    .toList();
        }
        return Response.ok(commandes).build();
    }

    @GET
    @Path("/{id}")
    public Response obtenirCommande(@PathParam("id") int id) {
        Commande commande = commandeService.getCommandeById(id);
        if (commande != null) {
            return Response.ok(commande).build();
        }
        return Response.status(Response.Status.NOT_FOUND)
                .entity("{\"erreur\": \"Commande introuvable\"}").build();
    }

    @POST
    public Response creerCommande(Commande nouvelleCommande) {
        try {
            Commande commandeCree = commandeService.validerNouvelleCommande(nouvelleCommande);

            return Response.created(URI.create("/commandes/" + commandeCree.getId()))
                    .entity(commandeCree).build();
        } catch (IllegalArgumentException e) {
            // Si le menu n'existe pas ou s'il y a une erreur de validation
            return Response.status(Response.Status.BAD_REQUEST)
                    .entity("{\"erreur\": \"" + e.getMessage() + "\"}").build();
        }
    }

    @PUT
    @Path("/{id}")
    public Response modifierCommande(@PathParam("id") int id, Commande commandeMAJ) {
        boolean succes = commandeService.updateCommande(id, commandeMAJ);
        if (succes) {
            return Response.ok(commandeService.getCommandeById(id)).build();
        }
        return Response.status(Response.Status.NOT_FOUND)
                .entity("{\"erreur\": \"Commande introuvable\"}").build();
    }

    @DELETE
    @Path("/{id}")
    public Response annulerCommande(@PathParam("id") int id) {
        boolean succes = commandeService.deleteCommande(id);
        if (succes) {
            return Response.noContent().build();
        }
        return Response.status(Response.Status.NOT_FOUND)
                .entity("{\"erreur\": \"Commande introuvable\"}").build();
    }
}