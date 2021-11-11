#!/bin/sh

until nc -z -v -w30 ${MYSQL_HOST} ${MYSQL_PORT}
do
  echo "Waiting for database connection..."
  sleep 5
done

rm -r /var/www/app/var/cache/*
composer --working-dir=/var/www/app dump-env prod --ansi
php /var/www/app/bin/console cache:clear
php /var/www/app/bin/console doctrine:migrations:migrate --no-interaction

/var/www/.symfony/bin/symfony server:start --port=80