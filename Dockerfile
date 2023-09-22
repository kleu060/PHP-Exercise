# Use an official PHP and Apache image as the base image
FROM php:8.2-apache

# Install system dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql gd zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clean up
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Expose port 80 for the Apache web server
#EXPOSE 80

# Copy your PHP application files into the container
COPY . /var/www/html

# Run composer install to install PHP dependencies
# USER www-data:www-data
# RUN composer install


# Start Apache and keep it running
#CMD ["apache2-foreground"]