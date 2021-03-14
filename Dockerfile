FROM larueli/php-base-image:8.0

USER 0

COPY . /var/www/html/

RUN composer install && chmod g+rwx /var/www/html

ENTRYPOINT bash -c "php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration && apache2-foreground"

USER 154778