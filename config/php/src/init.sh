#!/bin/bash
echo "Ouverture des droits"
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap

echo "Installation des dépendeances"
composer install

echo "Installation des dépendeances node"
cd /var/www/tensorflow/local

npm install
