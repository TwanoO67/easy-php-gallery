#easyphpgallery


## Installation

Choose your http port, and the main folder to share, by editing .env

Launch the project
`docker-compose up -d`

Prepare your config, and edit to set the APP_URL (using the port you choose earlier)
`cp src/.env.example src/.env`

You can use a different database (by editing .env) or else create the sqlite one
`touch src/database.sqlite`
Warning the sqlite database must be in a folder with write permissions


## Setup

use the default credential to create your users / folders :

email: admin@easyphpgallery.io
password: secret

Then change the password, or definitively delete this account

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/badge.svg?style=beer-square)](https://beerpay.io/TwanoO67/easy-php-gallery)  [![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/make-wish.svg?style=flat-square)](https://beerpay.io/TwanoO67/easy-php-gallery?focus=wish)
=======

## TODO
Bug with space in folder or names
Update: /usr/local/lib/python2.7/site-packages/thumbor/handlers/imaging.py
