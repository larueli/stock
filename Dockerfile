FROM larueli/php-symfony-base-image

COPY . /var/www/html/

RUN composer install

ENTRYPOINT bash -c "php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration && apache2-foreground"