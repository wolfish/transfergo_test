FROM php:8.2-fpm

RUN apt-get update && \
apt-get install -y git zip unzip libicu-dev curl librabbitmq-dev libssh-dev && \
pecl install amqp && \
docker-php-ext-install pdo pdo_mysql intl && \
docker-php-ext-enable pdo_mysql intl amqp

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD composer install -o && \
php bin/console --no-interaction doctrine:database:create --if-not-exists && \
php bin/console --no-interaction doctrine:migration:migrate --allow-no-migration && \
chown 100:101 -R * && \
chmod g+w -R var && \
php-fpm 

EXPOSE 9000