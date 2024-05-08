FROM php:8.2-fpm-alpine

WORKDIR /lamoda_tech

COPY ./deploy.sh /lamoda_tech/
RUN chmod +x /lamoda_tech/deploy.sh

RUN set -ex

# Install packages
RUN apk update
RUN apk add bash postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run
CMD [ "sh", "/lamoda_tech/deploy.sh" ]

EXPOSE 9000
