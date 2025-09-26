
-----

# README\_deploy.md

# Cahier Technique de Déploiement Manuel Laravel (o2switch)

Ce document est un guide  pour le déploiement et la mise à jour du projet Laravel sur l'hébergeur o2switch via SSH. Il intègre les solutions aux erreurs courantes rencontrées.

## 1\. Prérequis et Initialisation

Cette phase est nécessaire pour préparer l'environnement ou lors du tout premier déploiement.

### 1.1. Autorisation de Connexion SSH (Spécificité o2switch)

Le pare-feu d'o2switch bloque l'accès SSH aux IP inconnues.

  * **Action** : Autoriser l'adresse IP de votre machine locale.
  * **Procédure** : Accédez à votre **cPanel** \> Section **Sécurité** \> **Autorisation SSH** et ajoutez votre IP actuelle.

### 1.2. Nettoyage initial du serveur

  * **Objectif** : Assurer un environnement de déploiement vierge sur le serveur.
  * **Commandes** :

<!-- end list -->

```bash
ssh elha2196@ecran.o2switch.net
cd /home/elha2196/nataswim.fr
# Suppression des dossiers temporaires et des anciennes versions
rm -rf backup_* temp_deploy
```

-----

## 2\. Procédure de Déploiement et Mise à Jour Complète

Cette procédure doit être exécutée chaque fois que vous souhaitez déployer une nouvelle version du code, des migrations ou des seeders.

### 2.1. Mise à jour du Code et des Dépendances

| Étape | Action | Commande | Rôle |
| :--- | :--- | :--- | :--- |
| **0. Préparation locale** | Commiter et Pousser le code. | `git push origin main` | Assurer que la dernière version est sur GitHub. |
| **1. Connexion et Préparation** | Accéder au répertoire du projet. | `cd /home/elha2196/nataswim.fr/current` | Naviguer vers la version en production. |
| **2. Mise à jour du Code** | Télécharger les derniers fichiers. | `git pull origin main` | Récupère la dernière version du dépôt. |
| **3. Mise à jour de Composer** | Installer ou mettre à jour les dépendances PHP. | `composer install --no-dev --optimize-autoloader` | Installe les dépendances si `composer.lock` a été modifié. |
| **4. Mise à jour des Assets** | Compiler les fichiers CSS/JS (si applicables). | `npm run prod` ou `npm run build` | Regénérer les assets frontend. |

### 2.2. Gestion de la Base de Données et Cache

| Étape | Action | Commande | Rôle |
| :--- | :--- | :--- | :--- |
| **5. Exécution des Migrations** | Appliquer les changements de schéma à la base de données. | `php artisan migrate --force` | Crée ou modifie les tables. |
| **6. Application des Seeders** | Insérer les données initiales (Admin, rôles, permissions, etc.). | `php artisan db:seed --force` | Peupler la base de données. |
| **7. Gestion du Stockage** | Créer le lien symbolique vers le dossier de stockage public. | `php artisan storage:link` | Rendre les fichiers téléchargés publics. |
| **8. Nettoyage du Cache** | Vider tous les caches de configuration, route et vue. | `php artisan cache:clear`<br>`php artisan config:cache` | Force Laravel à charger la nouvelle configuration et le nouveau code. |

-----

## 3\. Gestion et Résolution des Erreurs Courantes

Cette section documente les solutions aux erreurs rencontrées.

### 3.1. Erreur : HTTP 500 (Internal Server Error)

| Cause probable | Commande de Diagnostic | Commande de Correction |
| :--- | :--- | :--- |
| **A. Clé d'application manquante** | `cat .env` (Vérifier `APP_KEY`) | `php artisan key:generate` |
| **B. Permissions incorrectes** | `ls -ld storage bootstrap/cache` | `chmod -R 775 storage bootstrap/cache` |
| **C. Logs ou Cache non accessibles** | `ls -la storage/logs` | `chown -R elha2196:elha2196 storage bootstrap/cache` (Change le propriétaire) |

### 3.2. Erreur : `Failed to clear cache`

| Cause | Commande de Diagnostic | Commande de Correction |
| :--- | :--- | :--- |
| **A. Fichiers créés par un autre utilisateur** | `ls -la bootstrap/cache` (Vérifier le propriétaire) | `rm -rf bootstrap/cache/*` puis `php artisan cache:clear` (Suppression manuelle des fichiers verrouillés) |

### 3.3. Erreur de Base de Données : Doublons (`Duplicate entry`)

| Cause | Commande de Diagnostic | Procédure de Correction |
| :--- | :--- | :--- |
| **A. Seeder lancé sur une BDD non vide** | `php artisan db:seed --force` (Échec) | **Réinitialisation Complète :** Supprimer et recréer la base de données *via* **cPanel**, puis relancer `php artisan migrate --force` et `php artisan db:seed --force`. |

-----

## 4\. Application de Nouvelles Fonctionnalités

Pour ajouter de nouvelles données ou un administrateur sans relancer tous les seeders :

### 4.1. Ajout de Données via un Seeder Cible

Utilisez cette commande pour lancer un seeder spécifique :

```bash
php artisan db:seed --class=NomDeVotreSeeder --force
```

### 4.2. Ajout d'un Administrateur

Si votre application a une commande dédiée :

```bash
# Exemple : Si vous avez une commande personnalisée dans Laravel
php artisan make:admin --name="Nouveau Admin" --email="admin@domaine.com"
```


git add .
git commit -m "déploiement"
git push origin main