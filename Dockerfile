FROM php:8.1-apache

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libbz2-dev \
    libsodium-dev \
    zip \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && docker-php-ext-install mysqli pdo_mysql \
    && docker-php-ext-install bz2 \
    && docker-php-ext-install sodium

    # Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the Apache configuration file
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Docker exec for import db
# sudo docker exec -i pantera_db_1 mysql -u root -proot pantera < ./db/latest_pantera.sql