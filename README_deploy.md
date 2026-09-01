# 1. Compiler les assets de PRODUCTION en local
npm run prod

# 2. Vérifier ce qui a changé
git status

# 3. Committer une seule fois, avec un message clair
git add .
git commit -m "chore: mise à jour des dépendances Composer/npm et build de production"

# 4. Pousser
git push origin main


compilation style 
npm run dev

puis 

ssh elha2196@ecran.o2switch.net
cd /home/elha2196/nataswim.fr/current
git pull origin main


Nouvelle migration 
exemple 
php artisan make:migration create_exercises_table


Application des Migrations
php artisan migrate --force



Diagnostic  

cd /chemin/,,,,,,

# 1. Vider 
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan route:clear
php artisan route:cache

# 5. EXTREMEMENT IMPORTANT : Vider l'autoload de Composer
composer dump-autoload



exemple 
php artisan make:model Exercise -mcr
-m = migration
-c = contrôleur
-r = resource controller (CRUD)




pour annuler le dernier lot de migration 
php artisan migrate:rollback --force









 procédure de déploiement manuel en un document de type **cahier technique** pour assurer la cohérence et la fiabilité de vos mises à jour.

-----

# README\_deploy.md

# Cahier Technique de Déploiement Manuel Laravel (o2switch)

Ce document est un guide de référence pour le déploiement initial et les mises à jour du projet Laravel sur l'hébergeur o2switch via SSH. Il intègre les solutions aux erreurs courantes rencontrées durant la procédure.

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
# Suppression des dossiers temporaires et des anciennes versions pour éviter les conflits
rm -rf backup_* temp_deploy
```

-----

## 2\. Procédure de Déploiement et Mise à Jour Complète

Cette section est divisée en deux parties : la configuration initiale (une seule fois) et la procédure de mise à jour courante.

### 2.1. Déploiement Initial (Première fois uniquement) 🚀

Ces étapes configurent l'application de A à Z.

| Étape | Action | Commandes | Rôle |
| :--- | :--- | :--- | :--- |
| **1. Connexion** | Se connecter au serveur. | `ssh elha2196@ecran.o2switch.net` | Accès au terminal distant. |
| **2. Clonage** | Cloner le projet dans un dossier temporaire. | `git clone https://github.com/nataswim/bidaya2025.git temp_deploy` | Télécharger le code source. |
| **3. Configuration** | Accéder au dossier et copier l'environnement. | `cd temp_deploy`<br>`cp .env.example .env` | Déplacer le `.env.example` en `.env`. |
| **4. Dépendances** | Installer les dépendances PHP et compiler les assets (si besoin). | `composer install --no-dev --optimize-autoloader --no-interaction`<br>`npm install && npm run prod` | Installer les librairies et compiler le frontend. |
| **5. Clé App** | **Générer la clé d'application.** | `php artisan key:generate` | Essentiel pour le chiffrement. |
| **6. Finalisation** | Lier le stockage, initialiser le cache et mettre en production. | `php artisan storage:link`<br>`php artisan config:cache`<br>`cd ..`<br>`mv temp_deploy current` | Crée les liens symboliques et renomme le dossier. |

### 2.2. Mises à Jour Régulières (Nouvelles Fonctionnalités / Correctifs) 🔄

Ces étapes doivent être exécutées après chaque `git push` pour mettre à jour la version **`current`**.

| Étape | Action | Commandes | Rôle |
| :--- | :--- | :--- | :--- |
| **1. Connexion et Pull** | Se connecter et récupérer les derniers changements. | `ssh elha2196@ecran.o2switch.net`<br>`cd /home/elha2196/nataswim.fr/current`<br>`git pull origin main` | Mettre à jour les fichiers du répertoire de production. |
| **2. Mise à Jour PHP/Assets** | Mettre à jour si `composer.lock` ou les assets ont changé. | `composer install --no-dev --optimize-autoloader`<br>`npm run prod` (si le frontend est modifié) | Assure la compatibilité des dépendances. |
| **3. Base de Données** | Appliquer les migrations **et** les seeders nécessaires. | `php artisan migrate --force`<br>`php artisan db:seed --force` (Optionnel : seulement pour les données initiales) | Met à jour le schéma et les données de la BDD. |
| **4. Nettoyage du Cache** | Forcer l'application à utiliser le nouveau code. | `php artisan cache:clear`<br>`php artisan config:cache`<br>`php artisan route:cache` | Évite les erreurs 500 dues à l'ancien cache. |

-----

## 3\. Gestion et Résolution des Erreurs Courantes

Cette section est indispensable lors d'un déploiement manuel.

### 3.1. Erreur : HTTP 500 (Internal Server Error)

| Cause probable | Commande de Correction |
| :--- | :--- |
| **A. Permissions incorrectes** | `chmod -R 775 storage bootstrap/cache` |
| **B. Logs ou Cache non accessibles** | `chown -R elha2196:elha2196 storage bootstrap/cache` |
| **C. Clé d'application manquante** | `php artisan key:generate` |
| **D. Cache corrompu** | `rm -rf bootstrap/cache/*` puis `php artisan cache:clear` |

### 3.2. Erreur de Base de Données : `Table '...' already exists` ou `Duplicate entry`

| Cause | Procédure de Correction |
| :--- | :--- |
| **A. Migration/Seeder lancé partiellement** | **Réinitialisation Complète :** 1. Supprimer et recréer la base de données *via* **cPanel**.<br>2. Relancer `php artisan migrate --force` et `php artisan db:seed --force`. |
| **B. Erreur de clé étrangère (Missing Foreign Key)** | S'assurer que le seeder des rôles (`RolesTableSeeder`) est appelé **avant** le seeder des utilisateurs (`UsersTableSeeder`) dans `DatabaseSeeder.php`. |

### 3.3. Erreur de Dépendance : `Class 'Spatie\...' not found`

| Cause | Procédure de Correction |
| :--- | :--- |
| **A. Dépendance manquante sur le serveur** | 1. **Localement :** Assurer que `composer.lock` est à jour (`composer update`).<br>2. **Sur le serveur :** `git pull origin main` puis `composer install --no-dev --optimize-autoloader`. |

-----

## 4\. Application de Nouvelles Fonctionnalités

Pour ajouter de nouvelles données sans relancer tous les seeders (qui pourraient écraser des données existantes).

### 4.1. Application d'un Seeder Spécifique

Utilisez cette commande pour lancer un seul seeder, par exemple pour ajouter de nouveaux rôles ou un utilisateur admin :

```bash
php artisan db:seed --class=NomDeVotreSeeder --force
```

### 4.2. Création d'un Administrateur

Si votre application a une commande dédiée pour la création d'un utilisateur admin :

```bash
# Exemple :
php artisan make:admin --name="Nouveau Admin" --email="admin@domaine.com"
```






Voici une version réorganisée et cohérente de votre documentation de déploiement manuel :

```markdown
# Cahier Technique - Déploiement Manuel Laravel sur O2Switch
**Projet : Bidaya2025 | Domaine : nataswim.fr**

## 1. Configuration Serveur et Prérequis

### 1.1. Informations Serveur
- **Hébergeur** : O2Switch
- **Serveur** : ecran.o2switch.net  
- **Utilisateur** : elha2196
- **Domaine** : nataswim.fr
- **Repository** : https://github.com/nataswim/bidaya2025.git
- **Base de données** : elha2196_bidaya2025

### 1.2. Autorisation SSH (Obligatoire)
**Problème** : Le pare-feu O2Switch bloque les IP inconnues.
**Solution** : 
1. cPanel → Sécurité → Autorisation SSH
2. Ajouter votre IP actuelle
3. Configurer les clés SSH

### 1.3. Structure des Répertoires
```
/home/elha2196/nataswim.fr/
└── current/          # Version active du site Laravel
```

## 2. Déploiement Initial (Première Installation)

### 2.1. Préparation Locale
```bash
# Vérifier que le code est à jour
git status
git add .
git commit -m "Préparation déploiement initial"
git push origin main
```

### 2.2. Installation Serveur
```bash
# 1. Connexion SSH
ssh -i ~/.ssh/your_key elha2196@ecran.o2switch.net

# 2. Naviguer vers le répertoire du domaine
cd /home/elha2196/nataswim.fr

# 3. Nettoyer l'environnement
rm -rf current temp_deploy backup_*

# 4. Cloner le repository
git clone https://github.com/nataswim/bidaya2025.git temp_deploy
cd temp_deploy

# 5. Installer les dépendances
composer install --no-dev --optimize-autoloader --no-interaction

# 6. Configuration Laravel
cp .env.example .env
nano .env  # Configurer les variables de production

# 7. Générer la clé d'application
php artisan key:generate

# 8. Permissions Laravel
chmod -R 775 storage bootstrap/cache

# 9. Base de données
php artisan migrate --force
php artisan db:seed --force  # Si nécessaire

# 10. Liens symboliques
php artisan storage:link

# 11. Cache Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 12. Finaliser l'installation
cd ..
mv temp_deploy current
```

## 3. Mises à Jour Régulières

### 3.1. Procédure Standard
```bash
# 1. Connexion et navigation
ssh -i ~/.ssh/your_key elha2196@ecran.o2switch.net
cd /home/elha2196/nataswim.fr/current

# 2. Sauvegarde préventive
cd ..
cp -r current backup_$(date +%Y%m%d_%H%M%S)

# 3. Mise à jour du code
cd current
git pull origin main

# 4. Vérification des dépendances
composer install --no-dev --optimize-autoloader --no-interaction

# 5. Migrations (si nécessaire)
php artisan migrate --force

# 6. Nettoyage du cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 7. Reconstruction du cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Vérification permissions
chmod -R 775 storage bootstrap/cache
```

### 3.2. Vérifications Post-Déploiement
```bash
# Test de l'application
php artisan --version
php artisan about

# Test base de données
php artisan tinker
# Dans Tinker : DB::connection()->getPdo();
```

## 4. Configuration .env Production

### 4.1. Variables Critiques
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:aRQ4UFJ7b3o0ferZez7cqKx5RDTDe9JFQ8DeaJA7TGE=
APP_URL=https://nataswim.fr

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=elha2196_bidaya2025
DB_USERNAME=elha2196_bidaya
DB_PASSWORD=[votre_mot_de_passe]
```

## 5. Gestion des Erreurs et Solutions

### 5.1. Erreur HTTP 500
| Cause | Diagnostic | Solution |
|-------|------------|----------|
| Permissions incorrectes | `ls -la storage/ bootstrap/cache/` | `chmod -R 775 storage bootstrap/cache` |
| Cache corrompu | `ls -la bootstrap/cache/` | `rm -rf bootstrap/cache/*` puis `php artisan cache:clear` |
| APP_KEY manquante | `grep APP_KEY .env` | `php artisan key:generate` |
| Logs inaccessibles | `ls -la storage/logs/` | `chown -R elha2196:elha2196 storage/` |

### 5.2. Erreur "Vendor manquant"
```bash
# Problème fréquent sur O2Switch : limite mémoire Composer
php -d memory_limit=512M composer install --no-dev --optimize-autoloader --no-interaction

# Ou désactiver le timeout
composer config --global process-timeout 0
composer install --no-dev --optimize-autoloader --no-interaction
```

### 5.3. Erreurs Base de Données
| Erreur | Cause | Solution |
|--------|-------|----------|
| `Table already exists` | Migration partielle | Vider la BDD via cPanel, relancer `php artisan migrate --force` |
| `Duplicate entry` | Seeder relancé | Vider la BDD, relancer `php artisan migrate && php artisan db:seed` |
| `Foreign key constraint` | Ordre des migrations | Vérifier l'ordre dans `DatabaseSeeder.php` |

### 5.4. Restauration (Rollback)
```bash
cd /home/elha2196/nataswim.fr
ls -la | grep backup_

# Restaurer un backup
mv current current_broken_$(date +%Y%m%d_%H%M%S)
cp -r backup_YYYYMMDD_HHMMSS current
chmod -R 775 current/storage current/bootstrap/cache
```

## 6. Maintenance et Bonnes Pratiques

### 6.1. Checklist Pré-Déploiement
- [ ] Tests locaux passent
- [ ] Code committé et pushé sur `main`
- [ ] Migrations testées localement
- [ ] Sauvegarde manuelle si changements critiques

### 6.2. Checklist Post-Déploiement
- [ ] Site accessible : `https://nataswim.fr/`
- [ ] Pas d'erreur 500/404
- [ ] Logs sans erreurs : `tail -20 storage/logs/laravel.log`
- [ ] Base de données fonctionnelle
- [ ] Assets CSS/JS se chargent

### 6.3. Commandes Utiles de Maintenance
```bash
# Nettoyage périodique des backups (garder les 5 derniers)
cd /home/elha2196/nataswim.fr
ls -t | grep backup_ | tail -n +6 | xargs rm -rf

# Surveillance des logs
tail -f current/storage/logs/laravel.log

# Test de performance
php artisan route:list --compact
php artisan config:show database
```

## 7. Déploiements Spécialisés

### 7.1. Ajout de Données (Seeders Ciblés)
```bash
# Lancer un seeder spécifique
php artisan db:seed --class=NomDuSeeder --force

# Exemple : ajouter un admin
php artisan db:seed --class=AdminSeeder --force
```

### 7.2. Mise à Jour Assets (si applicable)
```bash
# Si vous avez des assets à compiler
npm install --production
npm run production
```

---

## Cohérences et Améliorations Apportées

### Points Forts du Document Original
- Structure claire entre déploiement initial et mises à jour
- Gestion des erreurs O2Switch spécifiques
- Procédures étape par étape

### Améliorations Apportées
1. **Cohérence des commandes** : Unification des options Composer et Artisan
2. **Sauvegardes systématiques** : Ajout de sauvegardes automatiques avant chaque mise à jour
3. **Vérifications post-déploiement** : Checklist complète pour valider le déploiement
4. **Gestion d'erreurs enrichie** : Solutions spécifiques aux problèmes O2Switch (mémoire Composer, permissions)
5. **Structure logique** : Séparation claire entre installation initiale et maintenance
6. **Commandes de diagnostic** : Ajout d'outils de vérification et surveillance

Cette version manual-only est cohérente avec votre choix d'éviter l'automatisation et se concentre sur la fiabilité et la reproductibilité des interventions manuelles.