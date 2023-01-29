# Use an official PHP image as the base image
FROM php:7.4-apache

# Install the APCu extension
RUN pecl install apcu \
    && docker-php-ext-enable apcu

# Install the Sodium extension
RUN apt-get update && apt-get install -y libsodium-dev \
    && docker-php-ext-install sodium

# Copy the application code to the container
COPY ./public /var/www/html/

# Set the working directory to the document root
WORKDIR /var/www/html/

# Expose port 80 for the web server to listen on
EXPOSE 80

RUN mkdir /var/www/logs/

# Start the Apache web server
CMD ["apache2-foreground"]