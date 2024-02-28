FROM php:8.3-fpm

ENV PHPGROUP=laravel
ENV PHPUSER=laravel
ENV XDEBUG_MODE=coverage

RUN mkdir -p /var/www/html/public

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]