FROM php:8.1-fpm

RUN apt-get update && apt-get install -y  \
	git \
	libzip-dev \
	zip \
	unzip

RUN docker-php-ext-configure zip

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

COPY composer.lock composer.json /var/www/

COPY database /var/www/database

RUN sed -i 's/;extension=mysqli/extension=mysqli/g' /usr/local/etc/php/php.ini-development
RUN sed -i 's/;   extension=mysqli/extension=mysqli/g' /usr/local/etc/php/php.ini-development
RUN sed -i 's/;extension=pdo_mysql/extension=pdo_mysql/g' /usr/local/etc/php/php.ini-development
RUN sed -i 's/;extension=mysqli/extension=mysqli/g' /usr/local/etc/php/php.ini-production
RUN sed -i 's/;   extension=mysqli/extension=mysqli/g' /usr/local/etc/php/php.ini-production
RUN sed -i 's/;extension=pdo_mysql/extension=pdo_mysql/g' /usr/local/etc/php/php.ini-production

WORKDIR /var/www

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
	&& php composer-setup.php \
	&& php -r "unlink('composer-setup.php');"

COPY . /var/www

EXPOSE 9000

RUN chown -R www-data:www-data \
	/var/www/storage

RUN php artisan key:generate
RUN php artisan config:cache
