FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    npm \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo_mysql mbstring zip xml

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copier uniquement les fichiers de dépendances pour optimiser le cache
COPY composer.json composer.lock package.json package-lock.json ./

# Installer les dépendances PHP et JS
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install && npm run build

# Copier le reste du projet
COPY . .

# Génère la clé Laravel uniquement si APP_KEY est vide, puis optimise et migre
RUN if grep -q '^APP_KEY=$' .env; then php artisan key:generate --force; fi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
