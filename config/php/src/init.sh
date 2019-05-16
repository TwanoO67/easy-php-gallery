#!/bin/bash


echo "Installation des dépendeances api"
cd /var/www/html
composer install --no-scripts
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "Installation des dépendeances node"
cd /var/www/tensorflow/local
npm install

echo "Ouverture des droits"
chmod -R 777 /var/www/html
chown -R www-data:www-data /var/www/html
cd -
