classDiagram
direction TB

    %% Définition des packages / responsabilités
    namespace API_Commandes {
        class CommandeResource {
            +creerCommande(Commande commande) Response
            +getCommande(int id) Response
            +getAllCommandes() Response
        }

        class CommandeService {
            +validerNouvelleCommande(Commande commande) Commande
            +getCommandeById(int id) Commande
        }

        class CommandeRepository {
            +addCommande(Commande commande) Commande
            +getCommandeById(int id) Commande
        }

        class Commande {
            -int id
            -int abonneId
            -String adresseLivraison
            -LocalDateTime dateCommande
            -LocalDate dateLivraison
            -double prixTotal
        }

        class LigneCommande {
            -int id
            -int menuId
            -int quantite
            -String menuNom
            -double prixUnitaire
            -double prixLigne
        }
    }

    namespace Clients_Externes {
        class MenuClient {
            <<interface>>
            +getMenuById(int id) MenuDTO
        }

        class UtilisateurClient {
            <<interface>>
            +getUtilisateurById(int id) UtilisateurDTO
        }

        class MenuDTO {
            <<DTO>>
            -int id
            -String nom
            -double prixTotal
        }

        class UtilisateurDTO {
            <<DTO>>
            -int id
            -String adresse
        }
    }

    %% Relations d'Architecture REST
    CommandeResource ..> CommandeService : utilise
    CommandeService ..> CommandeRepository : sauvegarde via
    
    %% Relations vers les API externes
    CommandeService ..> MenuClient : consomme (HTTP)
    CommandeService ..> UtilisateurClient : consomme (HTTP)
    MenuClient ..> MenuDTO : retourne
    UtilisateurClient ..> UtilisateurDTO : retourne

    %% Relations Modèle de Données (Composition)
    Commande "1" *-- "1..*" LigneCommande : contient