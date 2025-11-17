# HistoSport

Application Laravel pour la gestion de données historiques sportives.

## ⚠️ Avertissement de Sécurité / Security Warning

**IMPORTANT:** Ce dépôt est public. Assurez-vous de :

- **JAMAIS** commiter le fichier `.env` ou tout autre fichier contenant des secrets
- **TOUJOURS** utiliser des variables d'environnement pour les données sensibles
- **TOUJOURS** configurer `APP_DEBUG=false` en production
- Lire attentivement la [Politique de Sécurité](SECURITY.md) avant de déployer

## Prérequis

- PHP >= 8.2
- Composer
- Node.js >= 18
- npm
- Base de données (SQLite, MySQL, ou PostgreSQL)

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/djcraft/histosport.git
cd histosport
```

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Configuration de l'environnement

```bash
# Copier le fichier d'exemple
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de la base de données

Éditez le fichier `.env` et configurez vos paramètres de base de données :

```env
DB_CONNECTION=sqlite
# ou pour MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=histosport
# DB_USERNAME=votre_utilisateur
# DB_PASSWORD=votre_mot_de_passe
```

### 5. Migrations et compilation des assets

```bash
# Créer la base de données SQLite (si vous utilisez SQLite)
touch database/database.sqlite

# Exécuter les migrations
php artisan migrate

# Compiler les assets
npm run build
```

### 6. Démarrer le serveur de développement

```bash
# Option 1: Commande simple
php artisan serve

# Option 2: Avec tous les services (queue, logs, etc.)
composer dev
```

L'application sera accessible à l'adresse : `http://localhost:8000`

## Scripts disponibles

```bash
# Installation complète
composer setup

# Démarrage en mode développement avec tous les services
composer dev

# Tests
composer test
# ou
./vendor/bin/pest

# Linting du code PHP
./vendor/bin/pint

# Audit de sécurité
composer audit
npm audit
```

## Développement avec Docker

```bash
# Construire l'image
docker build -t laravel-app .

# Démarrer avec Docker Compose
docker-compose up -d
```

## Structure du projet

```
.
├── app/                # Code de l'application
│   ├── Actions/       # Actions métier
│   ├── Http/          # Controllers, Middleware, Requests
│   ├── Livewire/      # Composants Livewire
│   └── Models/        # Modèles Eloquent
├── config/            # Fichiers de configuration
├── database/          # Migrations et seeders
├── public/            # Point d'entrée public
├── resources/         # Vues, assets non compilés
├── routes/            # Définition des routes
├── storage/           # Fichiers générés (logs, cache)
└── tests/             # Tests automatisés
```

## Configuration de production

**Consultez le fichier [DEPLOYMENT.md](DEPLOYMENT.md) pour les instructions de déploiement en production.**

Points critiques :
- Configurez `APP_ENV=production`
- Désactivez le debug : `APP_DEBUG=false`
- Désactivez Telescope : `TELESCOPE_ENABLED=false`
- Utilisez HTTPS
- Configurez des mots de passe forts

## Sécurité

Si vous découvrez une vulnérabilité de sécurité, veuillez consulter notre [Politique de Sécurité](SECURITY.md).

## Technologies utilisées

- [Laravel 12](https://laravel.com) - Framework PHP
- [Livewire](https://livewire.laravel.com) - Framework fullstack
- [Flux UI](https://flux.laravel.com) - Composants UI
- [Tailwind CSS](https://tailwindcss.com) - Framework CSS
- [Vite](https://vitejs.dev) - Build tool
- [Pest](https://pestphp.com) - Framework de tests

## Licence

MIT License - voir le fichier LICENSE pour plus de détails.

## Support

Pour toute question ou problème :
- Ouvrir une issue sur GitHub
- Consulter la documentation Laravel
- Lire la [Politique de Sécurité](SECURITY.md) pour les problèmes de sécurité
