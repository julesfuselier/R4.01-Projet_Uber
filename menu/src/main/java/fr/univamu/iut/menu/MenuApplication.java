package fr.univamu.iut.menu;

import io.github.cdimascio.dotenv.Dotenv;
import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Disposes;
import jakarta.ws.rs.ApplicationPath;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.core.Application;

@ApplicationPath("/api")
@ApplicationScoped
public class MenuApplication extends Application {

    Dotenv dotenv = Dotenv.load();

    @Produces
    private MenuRepositoryInterface openDbConnection() {
        String dbUrl = dotenv.get("DB_URL");
        String dbUser = dotenv.get("DB_USER");
        String dbPass = dotenv.get("DB_PASS");

        try {
            return new MenuRepositoryMariadb(dbUrl, dbUser, dbPass);
        } catch (Exception e) {
            throw new RuntimeException("Impossible de se connecter à la base de données", e);
        }
    }

    private void closeDbConnection(@Disposes MenuRepositoryInterface menuRepo) {
        menuRepo.close();
    }
}