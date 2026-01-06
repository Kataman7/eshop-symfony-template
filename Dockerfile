# syntax=docker/dockerfile:1

FROM composer:2.7 AS build

WORKDIR /app

# Copy all files
COPY . .

# Install dependencies without scripts
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    netcat-openbsd \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy PHP application from build
COPY --from=build /app/vendor /var/www/html/vendor
COPY --from=build /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock symfony.lock /var/www/html/
COPY .env /var/www/html/.env
COPY . /var/www/html/

# Set environment variables for shop configuration
ENV SHOP_NAME=Picokeebs
ENV SHOP_DESCRIPTION="Votre boutique en ligne de claviers mécaniques et accessoires gaming"
ENV SHOP_EMAIL=contact@picokeebs.com
ENV SHOP_PHONE="+33 1 23 45 67 89"
ENV SHOP_ADDRESS="Paris, France"

# Compile .env for production
# RUN composer dump-env prod

# Clear cache to ensure new env vars are loaded
RUN rm -rf var/cache/prod

# Set permissions
RUN mkdir -p /var/www/html/var/cache/prod && chown -R www-data:www-data /var/www/html/var/cache/prod

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/DocumentRoot/a \
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80