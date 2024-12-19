# Use the official PHP image as the base
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Install necessary PHP extensions and utilities
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files to the container
COPY src/ /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose the default port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
