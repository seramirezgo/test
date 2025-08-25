FROM php:8.2-apache

# System dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
       --with-jpeg \
       --with-freetype \
    && docker-php-ext-install pdo_mysql zip intl gd \
    && a2enmod rewrite

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy entrypoint
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy minimal files needed for composer install cache (composer.json)
COPY composer.json ./

# Install PHP dependencies (will run again at container start if volume overrides vendor)
RUN composer install --no-interaction --prefer-dist || true

# Copy app source (note: will be mounted as volume in dev)
COPY . .

EXPOSE 80

CMD ["bash", "-lc", "/usr/local/bin/entrypoint.sh"]


