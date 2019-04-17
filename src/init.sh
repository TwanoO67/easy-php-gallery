#!/bin/bash
echo "Ouverture des droits"
chmod -R 777 /var/www/html

echo "Installation des dépendeances"
composer install

echo "Génération d'une clef de sécurité"
php artisan key:generate

#if [ ! -f /var/www/html/database.sqlite ]; then
#    echo "Création de la base de donnée"
#    touch database.sqlite
#    chmod -R 777 database.sqlite
    php artisan migrate --seed
#fi

echo "Installation des dépendeances node"
cd /var/www/tensorflow/local

npm install

echo "Premier import des images"
cd /var/www/html

php artisan import:scan
