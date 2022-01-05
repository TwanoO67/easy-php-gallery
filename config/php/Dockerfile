FROM php:7.4-apache

#Activation des modules apache
RUN a2enmod rewrite ssl proxy proxy_http headers

RUN apt-get update && apt-get install -y \
git \
subversion \
bash \
curl \
unzip \
vim \
supervisor \
bindfs \
libmcrypt-dev \
zlib1g-dev \
libicu-dev \
libzip-dev \
libonig-dev \
g++ \
gnupg \
libxml2-dev \
libfontconfig \
libxrender1 \
mariadb-client \
cron \
inetutils-ping \
#libcurl4-openssl-dev pkg-config libssl-dev \
#mysql-client \
telnet

#Ajout de PDO & MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli calendar intl pcntl zip sockets \
 && docker-php-ext-enable mysqli
#Ajout de SOAP
RUN docker-php-ext-install mbstring soap
#mcrypt

#Changement de timezone
RUN ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
 && echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=Europe/Paris" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

## Add mongo driver
RUN pecl install mongodb && docker-php-ext-enable mongodb

#Install de composer
ENV PATH "/composer/vendor/bin:$PATH"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --quiet --no-ansi --install-dir=/usr/bin --filename=composer \
&& rm composer-setup.php \
&& composer --ansi --version --no-interaction

USER root

#Ajout de node
RUN curl -sL curl -sL https://deb.nodesource.com/setup_16.x | bash - && apt-get install -y nodejs cmake

#copy du code
COPY src /var/www/html
RUN rm -f /var/www/html/.env

COPY vhosts /etc/apache2/sites-enabled
COPY tensorflow /var/www/tensorflow

#installation des dependances
WORKDIR /var/www/html
RUN sed -i -e 's/\r$//' init.sh && . ./init.sh