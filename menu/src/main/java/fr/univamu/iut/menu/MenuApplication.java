package fr.univamu.iut.menu;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Disposes;
import jakarta.ws.rs.ApplicationPath;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.core.Application;

@ApplicationPath("/api")
@ApplicationScoped
public class MenuApplication extends Application {

    @Produces
    private MenuRepositoryInterface openDbConnection() {
        try {
            return new MenuRepositoryMariadb("jdbc:mariadb://mysql-blog-td.alwaysdata.net/blog-td_menu-api", "blog-td", "Rb.velocity+6");
        } catch (Exception e) {
            throw new RuntimeException("Impossible de se connecter à la base de données", e);
        }
    }

    private void closeDbConnection(@Disposes MenuRepositoryInterface menuRepo) {
        menuRepo.close();
    }
}