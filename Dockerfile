FROM php:8.2-fpm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y     git     curl     libpng-dev     libonig-dev     libxml2-dev     zip     unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY backend/ .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -     && apt-get install -y nodejs     && npm install     && npm run build

# Set permissions
RUN chown -R www-data:www-data /app     && chmod -R 755 /app/storage     && chmod -R 755 /app/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
