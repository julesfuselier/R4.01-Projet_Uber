package fr.univamu.iut.menu.api_externe;

import fr.univamu.iut.menu.metier.PlatResume;

public interface PlatsUtilisateursClientInterface {

    public String getUserNameById(int id);

    public PlatResume getPlatById(int id);

    public boolean userExistsById(int id);

    public boolean platExistsById(int id);
}
