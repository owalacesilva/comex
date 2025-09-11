FROM php:8.2-fpm-alpine

# Create the conf.d directory first
RUN mkdir -p /usr/local/etc/php/conf.d

# Destination directories as build-time constants
ARG PHP_INI_DIR=/usr/local/etc/php/conf.d
ARG PHP_FPM_DIR=/usr/local/etc/php-fpm.d

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    libpq-dev
#
## Install PHP extensions
#RUN docker-php-ext-install \
#    pgsql \
#    pdo_pgsql \
#    mbstring \
#    exif \
#    pcntl \
#    bcmath \
#    gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Copy configuration with explicit permissions
COPY --chmod=0644 .docker/php/php.ini ${PHP_INI_DIR}/custom.ini
COPY --chmod=0644 .docker/php/php-fpm.conf ${PHP_FPM_DIR}/php-fpm.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm", "-F"]