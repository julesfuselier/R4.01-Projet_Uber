# R4.01 — Projet Uber Eats

Application de livraison de repas (type Uber Eats) développée dans le cadre du cours **R4.01 — Architecture Logicielle** à l'IUT d'Aix-Marseille Université.

**Équipe :** Jules Fuselier · Loan Allard · Romain Cantor · Nasser Ahamed

---

## Présentation

L'application permet à des utilisateurs de consulter des plats, composer des menus personnalisés, et passer des commandes de livraison. Elle s'appuie sur une architecture **Clean Architecture** côté frontend et une architecture **microservices** côté backend.

### Stack technique

| Couche | Technologie |
|--------|-------------|
| Frontend | PHP 8+, Bramus Router, Architecture MVC/Clean |
| Backend (plats & utilisateurs) | Jakarta EE 10, JAX-RS, JPA/Hibernate, GlassFish 7 |
| Backend (menus) | Jakarta EE 10, JAX-RS, MariaDB |
| Commandes | JSON Server |
| Build | Maven (Java), Composer (PHP) |

---

## Architecture

```
HTTP Request
     │
     ▼
index.php  (Bramus Router)
     │
     ▼
Controllers        ← gestion des requêtes HTTP
     │
     ▼
Use Cases          ← logique métier
     │
     ▼
Repositories       ← interfaces (ports)
     │
     ▼
Infrastructure     ← implémentations HTTP vers les APIs Java
```

Le frontend PHP suit les principes de la **Clean Architecture** :

- `app/Controllers/` — point d'entrée HTTP, délègue aux use cases
- `app/UseCase/` — logique métier, indépendante du framework
- `app/Domain/` — entités métier (`Dish`, `Menu`, `Order`, `OrderLine`, `User`)
- `app/Infrastructure/` — repositories HTTP vers les services Java
- `app/Presenters/` — formatage des données pour les vues
- `app/Views/` — rendu HTML

---

## Prérequis

- PHP 8+
- Composer
- JDK 21 (Temurin)
- GlassFish 7
- Node.js + npm (pour JSON Server)
- MariaDB

---

## Installation & Lancement

### 1. Backend Java — Service Uber (plats & utilisateurs)

```bash
# Démarrer GlassFish
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin start-domain

# Premier déploiement
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin deploy \
  --name uber --contextroot uber uber-1.0-SNAPSHOT.war

# Redéploiement (si déjà déployé)
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin deploy \
  --force=true --name uber --contextroot uber uber-1.0-SNAPSHOT.war
```

API disponible sur : `http://localhost:8080/uber/api`

### 2. Backend Java — Service Menu

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin deploy \
  --name menu --contextroot menu menu-1.0-SNAPSHOT.war
```

API disponible sur : `http://localhost:8080/menu/api`

### 3. JSON Server — Commandes

```bash
npx json-server --port 3005 public/commandes.json
```

### 4. Frontend PHP

```bash
composer install
php -S localhost:8000
```

Application disponible sur : `http://localhost:8000`

### Arrêter GlassFish

```bash
~/Documents/COURS/S4/Cours/Archi_Log/TD3/glassfish7/bin/asadmin stop-domain
```

---

## Build depuis les sources

```bash
# Compiler le service Uber
cd uber && ./mvnw clean package

# Compiler le service Menu
cd menu && ./mvnw clean package
```

---

## Routes frontend

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/plats` | Liste des plats disponibles |
| GET | `/menus` | Liste des menus |
| GET | `/menus/create` | Formulaire de création de menu |
| POST | `/menus/create` | Créer un menu |
| GET | `/menus/{id}/edit` | Formulaire de modification |
| POST | `/menus/{id}/edit` | Modifier un menu |
| POST | `/menus/{id}/delete` | Supprimer un menu |
| GET | `/commandes` | Historique des commandes |
| GET | `/commandes/create` | Formulaire de commande |
| POST | `/commandes/create` | Passer une commande |

---

## Endpoints API

### Service Uber (`http://localhost:8080/uber/api`)

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/dishes` | Liste des plats |
| GET | `/dishes/{id}` | Détail d'un plat |
| GET | `/users` | Liste des utilisateurs |
| GET | `/users/{id}` | Détail d'un utilisateur |

### Service Menu (`http://localhost:8080/menu/api`)

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/menus` | Liste des menus |
| POST | `/menus` | Créer un menu |
| PUT | `/menus/{id}` | Modifier un menu |
| DELETE | `/menus/{id}` | Supprimer un menu |
| PUT | `/menus/{id}/dishes/{dishId}` | Associer un plat à un menu |

---

## Modèle de données

```
User ──────────────────────────────────────────────
  id · firstName · lastName · email · role
  roles : ADMIN | RESTAURANT_OWNER | CUSTOMER

Dish ───────────────────────────────────────────────
  id · name · description · price · is_available
  owner_id → User

Menu ───────────────────────────────────────────────
  id · name · creatorId → User
  dishes[] → Dish[]
  totalPrice (calculé)

Order ──────────────────────────────────────────────
  id · subscriberId → User
  shippingAddress · orderDate · deliveryDate
  lines[] → OrderLine[]
  totalPrice (calculé)

OrderLine ──────────────────────────────────────────
  menuId → Menu · menuName · unitPrice · quantity
  lineTotal (calculé)
```

---

## Documentation

Le diagramme UML est disponible dans `docs/` :

- `IHM_DIAGRAMME_CLASSE.png` : diagramme de classes de l'IHM 