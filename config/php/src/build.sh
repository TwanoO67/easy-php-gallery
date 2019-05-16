#!/bin/bash

#On fais un check des env, pour le CI ou on n'a pas de setup
if [ ! -f /var/www/html/.env ]
then
 cp /var/www/html/.env.example /var/www/html/.env
fi

cd /var/www/html
composer dump-autoload

echo "Génération d'une clef de sécurité"
php artisan key:generate

echo "Préparation de la base"
php artisan migrate:fresh --seed

php artisan optimize

php artisan import:scan &


