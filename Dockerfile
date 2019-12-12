FROM php:7.3-cli-alpine

LABEL maintainer "Gustavo Gama <gustavobgama@gmail.com>"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer global require hirak/prestissimo