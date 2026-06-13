FROM php:8.3.30-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache nginx supervisor mariadb-client caddy \
    && docker-php-ext-install pdo_mysql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expose port
EXPOSE 80

# Jalankan server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]