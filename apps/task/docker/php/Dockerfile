FROM php:8.2-cli as development


RUN apt-get -qq update && apt-get -qq -y install \
    git \
    libzip-dev \
    unzip \
    librabbitmq-dev

RUN apt-get update \
  && docker-php-ext-install pdo_mysql mysqli sockets zip

RUN pecl install amqp
RUN docker-php-ext-enable amqp

