#easyphpgallery


## Installation

Choose your http port, and the main folder to share, by editing .env

Launch the project
`docker-compose up -d`

Prepare your config, and edit to set the APP_URL (using the port you choose earlier)
`cp src/.env.example src/.env`

You can use a different database or else create the sqlite one
`touch src/database.sqlite`


then, install dependencies and prepare the db by

```./enter.sh

composer install

php artisan key:generate

php artisan migrate

php artisan db:seed
```

## Setup

use the default credential to create your users / folders :

email: admin@easyphpgallery.io
password: secret

Then change the password, or definitively delete this account
