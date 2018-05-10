# Base image, official docker PHP image
FROM php:7.2-fpm





# Install Linux dependencies
RUN apt-get update \
  && apt-get install -my --no-install-recommends \
  zlib1g-dev \
  libicu-dev \
  g++ \
  libmagickwand-dev \
  imagemagick \
  libpng-dev \
  libmemcached-dev \
  libevent-dev \
  openssl \
  jq \
  zip \
  unzip \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libbz2-dev \
  libmcrypt-dev





# Install imagick extension
# ADD https://github.com/mkoppanen/imagick/archive/phpseven.tar.gz /tmp/phpimagick.tar.gz
# RUN mkdir -p /usr/src/php/ext/imagick\
  # && tar xf /tmp/phpimagick.tar.gz -C /usr/src/php/ext/imagick --strip-components=1

# Configure and install
# RUN docker-php-ext-configure imagick\
  # && docker-php-ext-install imagick

# Cleanup
# RUN rm -rd /usr/src/php/ext/imagick && rm /tmp/phpimagick.tar.gz





# Install basic extensions
RUN docker-php-ext-install sockets iconv
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install bz2
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gettext
RUN docker-php-ext-install calendar
RUN docker-php-ext-install zip
RUN docker-php-ext-install soap

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

# Install intl extensions
RUN docker-php-ext-configure intl && docker-php-ext-install intl





# Install event extension
ADD https://pecl.php.net/get/event-2.0.3.tgz /tmp/event.tar.gz
RUN mkdir -p /usr/src/php/ext/event && tar xf /tmp/event.tar.gz -C /usr/src/php/ext/event --strip-components=1
RUN rm -rd /usr/src/php/ext/event && rm /tmp/event.tar.gz





# Install memcached extension
ADD https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz /tmp/phpmemcached.tar.gz
RUN mkdir -p /usr/src/php/ext/memcached && tar xf /tmp/phpmemcached.tar.gz -C /usr/src/php/ext/memcached --strip-components=1
RUN docker-php-ext-configure memcached && docker-php-ext-install memcached
RUN rm -rd /usr/src/php/ext/memcached && rm /tmp/phpmemcached.tar.gz





# Install APCu extension
ADD https://pecl.php.net/get/apcu-5.1.3.tgz /tmp/apcu.tar.gz
RUN mkdir -p /usr/src/php/ext/apcu && tar xf /tmp/apcu.tar.gz -C /usr/src/php/ext/apcu --strip-components=1
RUN docker-php-ext-configure apcu && docker-php-ext-install apcu
RUN rm -rd /usr/src/php/ext/apcu && rm /tmp/apcu.tar.gz





# Install APCu-BC extension
ADD https://pecl.php.net/get/apcu_bc-1.0.3.tgz /tmp/apcu_bc.tar.gz
RUN mkdir -p /usr/src/php/ext/apcu-bc && tar xf /tmp/apcu_bc.tar.gz -C /usr/src/php/ext/apcu-bc --strip-components=1
RUN docker-php-ext-configure apcu-bc && docker-php-ext-install apcu-bc
RUN rm -rd /usr/src/php/ext/apcu-bc && rm /tmp/apcu_bc.tar.gz
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini
RUN echo extension=apcu.so > /usr/local/etc/php/conf.d/20-php-ext-apcu.ini
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-apc.ini
RUN echo extension=apc.so > /usr/local/etc/php/conf.d/21-php-ext-apc.ini





# Install GD
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd





# Install MySQL tools
RUN docker-php-ext-install pdo && docker-php-ext-enable pdo
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli





# Install xdebug
RUN pecl install xdebug-2.6.0
RUN docker-php-ext-enable xdebug




# Install composer and put binary into $PATH
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/ \
  && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer





# Opcache
RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache





# Bash
COPY .profile /root/.profile
COPY .profile /root/.bashrc





# Additional tools
RUN apt-get install -y cron sudo
RUN apt-get install -y git
