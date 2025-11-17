# Guide de déploiement sécurisé / Secure Deployment Guide

Ce guide fournit des instructions détaillées pour déployer l'application HistoSport en production de manière sécurisée.

## Table des matières

1. [Prérequis](#prérequis)
2. [Configuration du serveur](#configuration-du-serveur)
3. [Configuration de l'application](#configuration-de-lapplication)
4. [Déploiement](#déploiement)
5. [Maintenance et surveillance](#maintenance-et-surveillance)

## Prérequis

### Serveur

- OS : Ubuntu 22.04 LTS ou Debian 11+ (recommandé)
- PHP >= 8.2 avec extensions : pdo, mbstring, xml, gd, zip, memcached
- Composer 2.x
- Node.js >= 18.x
- Serveur web : Nginx ou Apache
- Base de données : MySQL 8.0+, PostgreSQL 14+, ou SQLite (non recommandé en production)
- SSL/TLS : Certificat valide (Let's Encrypt recommandé)

### Comptes requis

- Compte utilisateur non-root avec privilèges sudo
- Accès SSH avec clé (pas de mot de passe)
- Compte de base de données dédié (pas root)

## Configuration du serveur

### 1. Sécurité du système

```bash
# Mettre à jour le système
sudo apt update && sudo apt upgrade -y

# Installer fail2ban pour la protection contre les attaques par force brute
sudo apt install fail2ban -y

# Configurer le pare-feu
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow http
sudo ufw allow https
sudo ufw enable
```

### 2. Installation de PHP et extensions

```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install php8.3 php8.3-fpm php8.3-cli php8.3-common \
    php8.3-mysql php8.3-pgsql php8.3-sqlite3 \
    php8.3-mbstring php8.3-xml php8.3-gd \
    php8.3-zip php8.3-curl php8.3-memcached \
    php8.3-redis -y
```

### 3. Installation de Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

### 4. Installation de Node.js

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y
```

### 5. Installation et configuration de Nginx

```bash
sudo apt install nginx -y

# Configuration Nginx pour Laravel
sudo tee /etc/nginx/sites-available/histosport << 'EOF'
server {
    listen 80;
    server_name votre-domaine.fr www.votre-domaine.fr;
    
    # Redirection vers HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name votre-domaine.fr www.votre-domaine.fr;
    
    root /var/www/histosport/public;
    index index.php;
    
    # Certificats SSL (à configurer avec Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/votre-domaine.fr/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/votre-domaine.fr/privkey.pem;
    
    # Configuration SSL sécurisée
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    # Headers de sécurité
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    # Logs
    access_log /var/log/nginx/histosport-access.log;
    error_log /var/log/nginx/histosport-error.log;
    
    # Taille maximale des uploads
    client_max_body_size 100M;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Timeout pour les requêtes longues
        fastcgi_read_timeout 300;
    }
    
    # Bloquer l'accès aux fichiers sensibles
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~ /\.env {
        deny all;
    }
    
    location ~ /\.git {
        deny all;
    }
}
EOF

# Activer le site
sudo ln -s /etc/nginx/sites-available/histosport /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 6. Configuration SSL avec Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d votre-domaine.fr -d www.votre-domaine.fr

# Renouvellement automatique (déjà configuré par défaut)
sudo systemctl status certbot.timer
```

### 7. Configuration de la base de données

Pour MySQL :

```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation

# Créer la base de données et l'utilisateur
sudo mysql
```

```sql
CREATE DATABASE histosport CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'histosport_user'@'localhost' IDENTIFIED BY 'mot_de_passe_tres_fort_ici';
GRANT ALL PRIVILEGES ON histosport.* TO 'histosport_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## Configuration de l'application

### 1. Déploiement du code

```bash
# Créer le répertoire
sudo mkdir -p /var/www/histosport
sudo chown $USER:www-data /var/www/histosport

# Cloner le dépôt (ou utiliser la méthode de déploiement de votre choix)
cd /var/www
git clone https://github.com/djcraft/histosport.git histosport
cd histosport
```

### 2. Configuration de l'environnement

```bash
# Copier le fichier d'exemple
cp .env.example .env

# Éditer avec vos paramètres de production
nano .env
```

**Configuration critique dans `.env` :**

```env
# Application
APP_NAME="HistoSport"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.fr

# Générer avec: php artisan key:generate
APP_KEY=base64:votre_cle_generee_ici

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=histosport
DB_USERNAME=histosport_user
DB_PASSWORD=mot_de_passe_tres_fort_ici

# Cache & Sessions
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Mail (configurez selon votre fournisseur)
MAIL_MAILER=smtp
MAIL_HOST=smtp.exemple.fr
MAIL_PORT=587
MAIL_USERNAME=votre_email@exemple.fr
MAIL_PASSWORD=votre_mot_de_passe_mail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@votre-domaine.fr
MAIL_FROM_NAME="${APP_NAME}"

# Telescope - DÉSACTIVÉ en production
TELESCOPE_ENABLED=false

# Inscription utilisateur
ALLOW_REGISTRATION=false
```

### 3. Installation des dépendances

```bash
# PHP
composer install --no-dev --optimize-autoloader --no-interaction

# JavaScript
npm ci --production
npm run build
```

### 4. Configuration des permissions

```bash
# Propriétaire des fichiers
sudo chown -R $USER:www-data /var/www/histosport

# Permissions
sudo find /var/www/histosport -type f -exec chmod 644 {} \;
sudo find /var/www/histosport -type d -exec chmod 755 {} \;

# Storage et cache doivent être inscriptibles par le serveur web
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### 5. Initialisation de l'application

```bash
# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## Configuration avec Docker (alternative)

### 1. Variables d'environnement pour docker-compose

Créez un fichier `.env` à la racine avec les variables nécessaires :

```env
# Chemins
APP_PATH=/opt/histosport
MYSQL_DATA_PATH=/opt/histosport/mysql-data

# Base de données
DB_HOST=mysql
DB_DATABASE=histosport
DB_USERNAME=histosport_user
DB_PASSWORD=votre_mot_de_passe_fort
MYSQL_ROOT_PASSWORD=votre_mot_de_passe_root_fort
```

### 2. Sécuriser l'accès

**IMPORTANT:** Ne jamais exposer directement les ports de base de données sur Internet.

Le fichier `docker-compose.yml` actuel expose phpMyAdmin sur le port 3307. En production :

- Supprimez complètement le service phpMyAdmin, OU
- Limitez l'accès avec un reverse proxy authentifié
- Utilisez un VPN pour l'administration

### 3. Déploiement avec GitHub Actions

Le workflow `.github/workflows/deploy.yml` est déjà configuré. Vous devez ajouter ces secrets dans GitHub :

- `SSH_HOST` : Adresse IP ou domaine de votre serveur
- `SSH_USER` : Nom d'utilisateur SSH
- `SSH_PRIVATE_KEY` : Clé SSH privée pour la connexion

## Maintenance et surveillance

### 1. Sauvegardes

```bash
# Script de sauvegarde de la base de données
#!/bin/bash
BACKUP_DIR="/backup/histosport"
DATE=$(date +%Y%m%d_%H%M%S)

# Base de données
mysqldump -u histosport_user -p histosport > "$BACKUP_DIR/db_$DATE.sql"

# Fichiers uploadés (storage)
tar -czf "$BACKUP_DIR/storage_$DATE.tar.gz" /var/www/histosport/storage/app

# Nettoyer les anciennes sauvegardes (garder 30 jours)
find $BACKUP_DIR -mtime +30 -delete
```

Ajoutez ce script à cron :

```bash
# Sauvegardes quotidiennes à 2h du matin
0 2 * * * /usr/local/bin/backup-histosport.sh
```

### 2. Surveillance des logs

```bash
# Logs Laravel
tail -f /var/www/histosport/storage/logs/laravel.log

# Logs Nginx
tail -f /var/log/nginx/histosport-error.log
tail -f /var/log/nginx/histosport-access.log

# Logs système
journalctl -u nginx -f
journalctl -u php8.3-fpm -f
```

### 3. Mises à jour de sécurité

```bash
# Système
sudo apt update && sudo apt upgrade -y

# Dépendances PHP
cd /var/www/histosport
composer audit
composer update --with-all-dependencies

# Dépendances JavaScript
npm audit
npm audit fix

# Après les mises à jour
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart php8.3-fpm
```

### 4. Monitoring des performances

Considérez l'installation de :

- **Laravel Pulse** : Monitoring des performances de l'application
- **New Relic** ou **DataDog** : Monitoring APM
- **Uptime Robot** : Monitoring de disponibilité
- **Sentry** : Tracking des erreurs

### 5. Queue Workers (si utilisé)

```bash
# Créer un service systemd pour les workers
sudo tee /etc/systemd/system/histosport-worker.service << 'EOF'
[Unit]
Description=HistoSport Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
RestartSec=5s
ExecStart=/usr/bin/php /var/www/histosport/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
EOF

sudo systemctl enable histosport-worker
sudo systemctl start histosport-worker
```

## Checklist de déploiement

Avant de mettre en production :

- [ ] Serveur configuré et sécurisé (firewall, fail2ban, etc.)
- [ ] PHP 8.2+ installé avec toutes les extensions
- [ ] Nginx/Apache configuré avec HTTPS
- [ ] Certificat SSL valide installé
- [ ] Base de données créée avec utilisateur dédié
- [ ] `.env` configuré avec valeurs de production
- [ ] `APP_ENV=production` et `APP_DEBUG=false`
- [ ] `APP_KEY` généré
- [ ] `TELESCOPE_ENABLED=false`
- [ ] Dépendances installées (`composer install --no-dev`)
- [ ] Assets compilés (`npm run build`)
- [ ] Migrations exécutées
- [ ] Permissions fichiers correctement configurées
- [ ] Caches optimisés (config, route, view)
- [ ] Sauvegardes automatiques configurées
- [ ] Logs configurés et rotations en place
- [ ] Monitoring en place
- [ ] Tests de charge effectués
- [ ] Plan de rollback préparé

## Support

En cas de problème :

1. Consultez les logs (Laravel, Nginx, système)
2. Vérifiez la [documentation Laravel](https://laravel.com/docs)
3. Consultez la [Politique de Sécurité](SECURITY.md)
4. Ouvrez une issue sur GitHub (pas pour les problèmes de sécurité)

## Ressources additionnelles

- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Forge](https://forge.laravel.com) - Service de déploiement Laravel (payant)
- [Envoyer](https://envoyer.io) - Déploiement zero-downtime (payant)
- [DigitalOcean Laravel Guide](https://www.digitalocean.com/community/tags/laravel)
