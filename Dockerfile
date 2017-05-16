FROM php:7-apache
# Install packages
RUN apt-get update
RUN apt-get install -my \
    && docker-php-ext-install pdo pdo_mysql

# ADD web /var/www/html
RUN ["chmod", "777", "-Rf", "/var/www/html/app/cache”]
RUN ["chmod", "777", "-Rf", "/var/www/html/app/logs”]

EXPOSE 80 443
