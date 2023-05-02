FROM php:apache
EXPOSE 80
COPY ./ /var/www/html/
WORKDIR /var/www/html/
RUN docker-php-ext-install pdo mysqli pdo_mysql