FROM php:8.2-apache

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

COPY --chown=www-data:www-data . /var/www/html

RUN sed -i -e 's,/var/www/html,/var/www/html/public,g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80
