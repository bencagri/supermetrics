FROM php:7.2-fpm-alpine
USER root
RUN echo "ipv6" >> /etc/modules

#install php and some dependencies
RUN apk add --no-cache \
        php7 \
        php7-common \
        php7-cli \
        php7-mbstring

RUN mkdir -p /supermetrics
ADD . /supermetrics
WORKDIR /supermetrics

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer install

EXPOSE 8082
CMD ["php", "-S", "0.0.0.0:8082", "index.php"]
