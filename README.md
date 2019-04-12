# EasyPHPhotoGallery

![Preview](https://github.com/TwanoO67/easy-php-gallery/raw/master/demo.png)

## Feature

* [x] Albums of your local photos
* [x] Automatic thumbnails with Thumbor
* [x] SlideShow and Fullscreen pictures
* [x] Search / Tagging with TensorFlowJS AI
* [ ] Let them Upload new photos
* [ ] Sharing with friends (publicly or private)
* [ ] Detect human faces
* [ ] Map of your GPS coordinates



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

## Source

TensorflowJS tuto => https://github.com/ADLsourceCode/TensorflowJS.git
http://jamesthom.as/blog/2018/08/07/machine-learning-in-node-dot-js-with-tensorflow-dot-js/

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/badge.svg?style=beer-square)](https://beerpay.io/TwanoO67/easy-php-gallery)  [![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/make-wish.svg?style=flat-square)](https://beerpay.io/TwanoO67/easy-php-gallery?focus=wish)
=======
