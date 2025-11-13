FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    npm \
    libmemcached-dev \
    zlib1g-dev \
    libzip-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip xml gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copie des fichiers de l'application
COPY . .

# Installer les dépendances PHP et JS
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/*

# Ajout du script d'entrée et permission exécutable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
