# Brief-3 — Application de gestion des utilisateurs (PHP MVC natif)

Application web de gestion des utilisateurs et des rôles (Admin / Client), développée en **PHP natif selon une architecture MVC maison** (sans framework), avec authentification, historique des connexions et tableau de bord statistique.

> ⚠️ Le code applicatif se trouve sur la branche `master` (la branche `main` ne contient qu'un README vide). Il est recommandé de fusionner `master` dans `main` ou de définir `master` comme branche par défaut sur GitHub pour éviter toute confusion.

---

## 1. Aperçu du projet

Le projet met en œuvre, sans framework, les briques qu'un framework comme Laravel ou Symfony fournirait habituellement :

- un **routeur** basé sur un paramètre `?action=` (`Router/Router.php`)
- une couche **Modèle** (accès aux données via PDO)
- une couche **Contrôleur** (logique métier)
- une couche **Vue** (fichiers PHP avec HTML/Tailwind)
- une gestion de **sessions PHP** pour l'authentification

C'est un excellent exercice pédagogique pour comprendre le fonctionnement interne d'un pattern MVC avant d'utiliser un framework.

## 2. Fonctionnalités

| Domaine | Fonctionnalités |
|---|---|
| **Authentification** | Connexion (`index.php` + `ControllerConnexion::login()`), déconnexion, page d'inscription |
| **Gestion des utilisateurs** | Liste des utilisateurs, édition, suppression (`ControllerInscription`, `ModelUsers`) |
| **Gestion des rôles** | Comptage et listing des rôles, distinction Admin / Client (`ControllerRole`, `ModelRole`) |
| **Tableau de bord Admin** | Nombre total d'utilisateurs, nombre d'admins, nombre de clients (`ControllerAdmin`, `ModelAmin`) |
| **Historique de connexion** | Enregistrement des connexions/déconnexions en base (table `sessions`), consultation de l'historique par utilisateur |
| **Statistiques** | Tendances de connexion, répartition horaire, navigateurs utilisés, statistiques de session par utilisateur (`showCharts()`) |

## 3. Architecture et structure du projet

```
Brief-3/
├── index.php                        # Page de connexion (point d'entrée principal)
├── Condig/database.php              # Connexion PDO (nom conservé tel quel, cf. section 6)
├── Router/Router.php                # Routeur maison (dispatch via $_GET['action'])
├── controller/
│   ├── ControllerConnexion.php      # Login / logout / historique / statistiques
│   ├── ControllerInscription.php    # Inscription, édition, suppression d'utilisateurs
│   ├── ControllerAdmin.php          # Comptages (utilisateurs, admins, clients)
│   ├── ControllerRole.php           # Gestion des rôles
│   └── ControllerUsers.php
├── model/
│   ├── ModelUsers.php                # Requêtes PDO sur la table users
│   ├── ModelConnexion.php            # Authentification + historique de sessions
│   ├── ModelInscription.php          # Création d'utilisateurs
│   ├── ModelAmin.php                 # Comptages admin/dashboard
│   └── ModelRole.php                 # Requêtes sur la table roles
└── views/
    ├── Home.php, dashboard.php
    ├── Views_connection.php, ViewsInscription.php
    ├── Views_dashboadAdmin.php, Views_dashboadClient.php
    ├── ViewsHistoriqueConnexion.php, ViewsHistoriqueUsers.php
    ├── ViewsRole.php, ViewsStatistique.php
    ├── ViewsEditUser.php, UsersEdit.php
    └── Script/script.js
```

### Modèle de données (inféré du code, aucun script SQL fourni dans le dépôt)

Le dépôt ne contient **aucun fichier `.sql`** de création de schéma. En analysant les requêtes PDO, la base `brief_3` doit a minima contenir :

```sql
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    is_connected TINYINT(1) DEFAULT 0,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    logout_time DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

**Recommandation** : livrer un fichier `database.sql` (export `mysqldump`) dans le dépôt afin que le projet soit installable sans reverse-engineering du schéma.

## 4. Prérequis

- PHP 8.x avec l'extension **PDO MySQL**
- Serveur MySQL / MariaDB
- Un serveur web (Apache/Nginx) ou le serveur intégré de PHP
- Environnement type **XAMPP / WAMP / MAMP** recommandé pour un démarrage rapide

## 5. Installation

```bash
git clone https://github.com/Tchokouaga25/Brief-3.git
cd Brief-3
git checkout master
```

1. Créer une base de données MySQL nommée `brief_3`.
2. Créer les tables `roles`, `users` et `sessions` (voir schéma proposé en section 3, à adapter/compléter selon les besoins réels de l'application).
3. Vérifier/adapter les identifiants de connexion dans `Condig/database.php` :
   ```php
   private static $HOST = 'localhost';
   private static $DbNAME = 'brief_3';
   private static $username = 'root';
   private static $password = '';
   ```
4. Lancer le serveur PHP intégré depuis la racine du projet :
   ```bash
   php -S localhost:8000
   ```
5. Accéder à `http://localhost:8000/index.php` pour la page de connexion, ou à `http://localhost:8000/Router/Router.php?action=home` pour le routeur applicatif.

## 6. Analyse technique — points d'attention (revue de code)

En tant que revue technique de ce projet, plusieurs points méritent une attention prioritaire avant tout usage au-delà d'un cadre pédagogique :

### 🟠 Sécurité — Injection SQL potentielle dans `ModelRole::getAllAdmin()`
Le paramètre `:name` est utilisé pour filtrer sur `role_id`, une colonne numérique, alors que la valeur transmise (`"Admin"`, `"client"`) est une chaîne — la requête ne retournera jamais de résultat cohérent. Plus largement, la cohérence entre les valeurs de rôle utilisées comme chaînes (`ControllerAdmin`) et l'ID numérique attendu en base (`role_id`) doit être clarifiée.

### 🟠 Bug fonctionnel — `ControllerAdmin::ListeUsers()`
```php
$modeladmin = new ModelInscription($list);
$users = $this->$modeladmin->getAllListUser();
```
`$this->$modeladmin` utilise une syntaxe de propriété dynamique invalide (accès à une propriété dont le nom serait la valeur de `$modeladmin`) au lieu de `$modeladmin->getAllListUser()`. Cette méthode provoquera une erreur PHP à l'exécution. `$list` (global) n'est par ailleurs jamais défini dans ce contexte.

### 🟠 Incohérence d'architecture — `ControllerRole`
Le constructeur reçoit `$database` en paramètre mais l'ignore et recrée une nouvelle instance de `database()` (sans connexion PDO explicite) :
```php
public function __construct($database) {
    $database = new database();
    $database = $database->getPDO();
    $this->modelRole = new ModelRole($database);
}
```
Cela casse l'injection de dépendance voulue par le design du routeur et duplique les connexions PDO inutilement.

### 🟡 Nommage et organisation
- Le dossier `Condig/` est une coquille pour `Config/` — à corriger pour la lisibilité et la cohérence du projet (impacte tous les `require_once`).
- Mélange de conventions : `ModelAmin.php` (pour "Admin"), `ModelUsers.php`, `ControllerConnexion.php` — une convention de nommage uniforme (ex. `PascalCase` pour les classes, cohérence FR/EN) faciliterait la maintenance.
- Fichiers de vues quasi dupliqués (`ViewsHistoriqueConnexion.php` et `ViewsHistoriqueConnexion_new.php`) : le second semble être une version de travail à nettoyer avant livraison.

### 🟡 Débogage résiduel
Plusieurs `var_dump()` (`ModelRole::getAllAdmin()`, `ModelAmin::getAllAdmin()`) et `error_log()` de debug sont encore présents dans le code et généreront des sorties indésirables en production.

### 🟡 Gestion des sessions
`session_start()` est appelé à de multiples endroits (`index.php`, `ControllerConnexion::login()`, `logout()`, etc.) sans vérification systématique de `session_status()`, ce qui peut déclencher des avertissements PHP (« session already started ») selon le flux d'exécution emprunté.

### Synthèse
Le projet démontre une bonne compréhension des concepts MVC et de PDO, mais nécessite une passe de sécurisation (authentification, hachage des mots de passe) avant toute mise en situation réelle, ainsi qu'un nettoyage du code de débogage et des incohérences relevées ci-dessus.


## 8. Auteur

Projet réalisé par **Tchokouaga25** dans le cadre de la formation développement web à Inch.Class.
