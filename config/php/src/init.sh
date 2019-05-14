#!/bin/bash
echo "Ouverture des droits"
chmod -R 777 /var/www/html

echo "Installation des dépendeances"
composer install

echo "Installation des dépendeances node"
cd /var/www/tensorflow/local

npm install
