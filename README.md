# EasyPHPhotoGallery

Photo Gallery for your own NAS server.
This project use your already existing image folder, and you organize and share its pictures.
It handle Folders, Tags, Thumbnails, Virtual Albums, Face Detection, and many more to come.

[![Build Status](https://travis-ci.org/TwanoO67/easy-php-gallery.svg?branch=develop)](https://travis-ci.org/TwanoO67/easy-php-gallery)

## Demo

[![Preview](https://github.com/TwanoO67/easy-php-gallery/raw/master/demo.png)](https://youtu.be/W7Ff-VXIsFQ)

Demonstration of the tagging process: [EPG Tagging on Youtube](https://youtu.be/W7Ff-VXIsFQ)

## Feature

* [x] Albums of your local photos
* [x] On-fly thumbnails resizing and caching with Thumbor
* [x] SlideShow and Fullscreen pictures
* [x] Search / Tagging with TensorFlowJS AI
* [x] Create folder, Delete, Move files
* [x] Upload new photos with shunked transfer
* [x] Create virtual albums
* [ ] Sharing with friends (publicly, limited or private)
* [ ] Limit visibility of files only to admin
* [ ] Detection and recognition of human faces and regroup pictures by people
* [ ] Map of your picture's GPS coordinates
* [ ] Fully tested API with PHPUnit
* [ ] Fully tested feature with Cypress

BTW: This project doesn't need to move your picture in order to work.
So you can keep them ordered on your disk as you want. Finally!

## Installation

Choose your http port, and the main folder to share
`cp .env.example .env; vi .env`

Launch the project
`docker-compose up -d`

Prepare your config, and edit to set the APP_URL (using the port you choose earlier)
`cp src/.env.example src/.env`

Install dependencies
`source enter.sh`
`./init.sh `



## Setup

1) Register a new account with your email

2) Then Connect using this account :

email: admin@easyphpgallery.io
password: secret

3) Using the admin account go to "administration" and to set your new user as admin

4) Then disconnect and use your new account to definitively delete the previous admin account for security reasons

## Recommandations

To optimize your experience, you can think your mobile phone photo folder with this app, by using sync apps like this:

https://play.google.com/store/apps/details?id=dk.tacit.android.foldersync.lite&hl=fr

## Source

TensorflowJS tuto => https://github.com/ADLsourceCode/TensorflowJS.git
http://jamesthom.as/blog/2018/08/07/machine-learning-in-node-dot-js-with-tensorflow-dot-js/

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/badge.svg?style=beer-square)](https://beerpay.io/TwanoO67/easy-php-gallery)  [![Beerpay](https://beerpay.io/TwanoO67/easy-php-gallery/make-wish.svg?style=flat-square)](https://beerpay.io/TwanoO67/easy-php-gallery?focus=wish)
=======
