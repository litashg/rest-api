FROM php:7.4-fpm

WORKDIR /var/www/html
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       openssl \
       openssh-server \
       libxml2-dev \
       nano\
       libzip-dev \
       curl \
       unzip \
       libmagickwand-dev \
       libmemcached-dev \
       supervisor \
       gsfonts \
       ffmpeg \
       cron

# Install PHP extensions and PECL modules.
RUN apt-get update && docker-php-ext-install ctype iconv json session simplexml tokenizer pdo_mysql bcmath sockets zip \
    && apt-get install supervisor -y \
    && pecl install imagick \
    && pecl install xdebug-3.0.4 \
    && pecl install memcached \
    && docker-php-ext-enable xdebug imagick memcached \
    && rm -r /var/lib/apt/lists/*

COPY /php/php.ini /usr/local/etc/php/php.ini
COPY /supervisor.conf /etc/
COPY /service.conf  /etc/supervisor/conf.d/

#COPY /php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
#RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

