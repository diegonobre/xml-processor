FROM php:7-apache

# Install packages
RUN apt-get update
RUN apt-get install -my \
    && docker-php-ext-install pdo pdo_mysql

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 80 443
