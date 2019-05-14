#!/bin/bash

echo "Génération d'une clef de sécurité"
php artisan key:generate

echo "Préparation de la base"
php artisan migrate:fresh --seed

echo "Premier import des images"
cd /var/www/html

php artisan import:scan &


