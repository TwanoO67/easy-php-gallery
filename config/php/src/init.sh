#!/bin/bash
echo "Ouverture des droits"
chmod -R 777 storage
chmod -R 777 database.sqlite
chmod -R 777 bootstrap/cache

echo "Installation des dépendeances"
composer install

if [ ! -f .env ]; then
    echo "Création du fichier d'env de laravel"
    cp .env.example .env
fi

echo "Génération d'une clef de sécurité"
php artisan key:generate

if [ ! -f /var/www/html/database.sqlite ]; then
    echo "Création de la base de donnée"
    touch database.sqlite
    chmod -R 777 database.sqlite
    php artisan migrate
    php artisan db:seed
fi
