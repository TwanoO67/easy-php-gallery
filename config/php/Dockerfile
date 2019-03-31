FROM php:7.1-apache

RUN a2enmod rewrite headers

RUN apt-get update && apt-get install -y vim git subversion bash curl unzip inetutils-ping libmcrypt-dev \
zlib1g-dev \
libicu-dev \
g++ \
gnupg \
libxml2-dev \
libfontconfig \
libxrender1 \
mysql-client

#Ajout de PDO & MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli calendar mbstring mcrypt intl pcntl zip soap sockets && docker-php-ext-enable mysqli

## Add mongo driver
RUN pecl install mongodb && docker-php-ext-enable mongodb

#Changement de timezone
RUN ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
 && echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=Europe/Paris" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

#Install de composer
ENV PATH "/composer/vendor/bin:$PATH"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --quiet --no-ansi --install-dir=/usr/bin --filename=composer \
&& rm composer-setup.php \
&& composer --ansi --version --no-interaction

COPY src /var/www/html
COPY vhosts /etc/apache2/sites-enabled

RUN ./init.sh
