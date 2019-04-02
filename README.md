#easyphpgallery

![Preview](https://github.com/TwanoO67/easy-php-gallery/raw/master/demo.png)

## Feature

Albums of your local photos
Automatic thumbnails with Thumbor
Search / Tagging with TensorFlowJS AI
Map of your GPS coordinates
Sharing with friends (publicly or private)
Let them Upload new photos

This project use your pictures in your server in read-only.
So you can order it on your disk as you want. Finally!

## Installation

Choose your http port, and the main folder to share
`cp .env.example .env; vi .env`

Launch the project
`docker-compose up -d`

Prepare your config, and edit to set the APP_URL (using the port you choose earlier)
`cp src/.env.example src/.env`

You can use a different database (by editing .env) or else create the sqlite one
`touch src/database.sqlite`
Warning the sqlite database must be in a folder with write permissions


## Setup

1) Register a new account

2) Connect using this account :

email: admin@easyphpgallery.io
password: secret

3) Use the default credential to set your new user as admin

4) Then disconnect and use your new account to definitively delete this account for security reasons

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/badge.svg?style=beer-square)](https://beerpay.io/TwanoO67/easy-php-gallery)  [![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/make-wish.svg?style=flat-square)](https://beerpay.io/TwanoO67/easy-php-gallery?focus=wish)
=======
