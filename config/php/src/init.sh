#!/bin/bash

echo "Installation des dépendeances"
composer install

echo "Génération d'une clef de sécurité"
php artisan key:generate

if [ ! -f /var/www/html/database.sqlite ]; then
    echo "Création de la base de donnée"
    touch /var/www/html/database.sqlite
    php artisan migrate
    php artisan db:seed
fi
