FROM php:7.4-cli-alpine

RUN docker-php-ext-install pdo_mysql

WORKDIR /src

# composer installation and default home config
RUN mkdir -p /home/default && chmod a+w /home/default
RUN mkdir /composer && chmod a+w /composer
ENV COMPOSER_HOME=/composer
ENV HOME=/home/default
COPY composer-installer.sh ./
RUN ./composer-installer.sh && mv ./composer.phar /usr/local/bin/composer && chmod a+x /usr/local/bin/composer
