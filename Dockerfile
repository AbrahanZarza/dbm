FROM php:8.3-alpine3.20

EXPOSE 8000

RUN apk --update add \
    alpine-sdk \
    openssl-dev \
    linux-headers \
    postgresql-dev \
    sqlite \
    sqlite-dev \
    && rm -rf /var/cache/apk/*

RUN pecl channel-update pecl.php.net

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite

ENV TZ=${TZ}

RUN apk add --update --upgrade tzdata autoconf g++ make \
    && ln -s /usr/share/zoneinfo/$TZ /etc/localtime \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer