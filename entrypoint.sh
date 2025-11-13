#!/bin/sh

# Génère la clé Laravel si absente
if grep -q '^APP_KEY=$' .env; then
    echo "Génération de la clé Laravel..."
    php artisan key:generate --force
fi


# Lance la migration
php artisan migrate --force

# Optimise le cache Laravel
php artisan optimize

# Démarre le serveur PHP-FPM
exec php-fpm
