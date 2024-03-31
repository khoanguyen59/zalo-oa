FROM ubuntu:18.04

ENV PHP_VERSION 7.2
ENV DEBIAN_FRONTEND=nonintercative

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install -y software-properties-common language-pack-en-base
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update && apt-get install -y zip nano curl wget

# Install GIT
RUN apt-get install software-properties-common -y
RUN add-apt-repository ppa:git-core/ppa && apt-get update && apt-get install git -y

# Install nginx
COPY config/etc/apt/sources.list.d/nginx-ubuntu-stable-xenial.list /etc/apt/sources.list.d/nginx-ubuntu-stable-xenial.list
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com 00A6F0A3C300EE8C
RUN apt-get update && apt-get install -y nginx

# Install nodejs
RUN apt-get update && apt-get install -y curl
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get update && apt-get install -y nodejs
RUN npm install -g bower
RUN npm install -g yarn
RUN npm install -g gulp

#Install supervisor
RUN apt-get install supervisor -y

# Copy Config
COPY config/supervisor.conf /etc/supervisor/conf.d/supervisor.conf
COPY config/nginx.conf /etc/nginx/nginx.conf

# Install nginx_ensite
RUN apt-get install -y make
RUN git clone https://github.com/perusio/nginx_ensite.git /tmp/nginx_ensite &&  cd /tmp/nginx_ensite/ && make install && rm -r /tmp/nginx_ensite

RUN wget https://getcomposer.org/download/$(curl -s https://api.github.com/repos/composer/composer/releases/latest | grep 'tag_name' | cut -d '"' -f 4)/composer.phar -O /usr/local/bin/composer && chmod +x /usr/local/bin/composer

# Install php7 & module
RUN apt-get install -y php$PHP_VERSION php$PHP_VERSION-cli php$PHP_VERSION-fpm
RUN apt-get install -y php$PHP_VERSION-gd php$PHP_VERSION-json php$PHP_VERSION-mysql
RUN apt-get install -y php$PHP_VERSION-readline php$PHP_VERSION-mbstring
RUN apt-get install -y php$PHP_VERSION-dom php$PHP_VERSION-curl
RUN apt-get install -y php$PHP_VERSION-zip php$PHP_VERSION-redis php$PHP_VERSION-memcached
RUN apt-get install -y php$PHP_VERSION-bcmath php$PHP_VERSION-bz2 php$PHP_VERSION-gmp php$PHP_VERSION-mongo php$PHP_VERSION-intl php$PHP_VERSION-soap

RUN service php$PHP_VERSION-fpm start
RUN chown -R www-data:www-data /var/www

COPY config/etc/php/$PHP_VERSION/fpm/pool.d/www.conf /etc/php/$PHP_VERSION/fpm/pool.d/www.conf
COPY config/etc/php/$PHP_VERSION/fpm/php.ini /etc/php/$PHP_VERSION/fpm/php.ini
COPY config/etc/php/$PHP_VERSION/fpm/php-fpm.conf /etc/php/$PHP_VERSION/fpm/php-fpm.conf

#RUN apt-get upgrade -y && apt-get autoremove

# Install mongodb
RUN apt-get install gnupg
RUN wget -qO - https://www.mongodb.org/static/pgp/server-4.2.asc | apt-key add -
RUN echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.2 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-4.2.list
RUN apt-get update
RUN apt-get install -y mongodb-org
