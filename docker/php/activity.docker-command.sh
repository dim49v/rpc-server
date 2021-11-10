#!/bin/sh

rm -r /var/www/app/var/cache/*
composer --working-dir=/var/www/app dump-env prod --ansi
php /var/www/app/bin/console assets:install public
php /var/www/app/bin/console cache:clear
php /var/www/app/bin/console doctrine:migrations:migrate --no-interaction

symfony server:start