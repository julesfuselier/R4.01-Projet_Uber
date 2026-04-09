# R4.01-Projet_Uber

Application de livraison de repas (type Uber Eats) composée d'un frontend PHP et d'un backend Java déployé sur GlassFish.

## Prérequis

- PHP 8+
- Composer
- GlassFish 7 (installé dans `~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/`)
- JDK 21 (Temurin)

## Lancer le backend (GlassFish)

### 1. Démarrer GlassFish

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin start-domain
```

### 2. Déployer le WAR (premier déploiement)

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin deploy --name uber --contextroot uber uber-1.0-SNAPSHOT.war
```

### 2. Redéployer le WAR (si déjà déployé)

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin deploy --force=true --name uber --contextroot uber uber-1.0-SNAPSHOT.war
```

L'API est accessible sur : `http://localhost:8080/uber/api`

### Arrêter GlassFish

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin stop-domain
```

## Lancer le frontend (PHP)

```bash
composer install
php -S localhost:8000
```

Le frontend est accessible sur : `http://localhost:8000`

## Endpoints API

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/uber/api/dishes` | Liste des plats |
| GET | `/uber/api/dishes/{id}` | Détail d'un plat |
| GET | `/uber/api/users` | Liste des utilisateurs |
| GET | `/uber/api/users/{id}` | Détail d'un utilisateur |