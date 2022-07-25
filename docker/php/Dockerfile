FROM php:7.4-cli-alpine

RUN apk add --no-cache $PHPIZE_DEPS icu-dev
# 注意：intlをインストールするにはicu-devが必要
RUN docker-php-ext-install pdo_mysql intl
# xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY 90-xdebug.ini /usr/local/etc/php/conf.d/
RUN echo ''

WORKDIR /src

# composer installation and default home config
RUN mkdir -p /home/default && chmod a+w /home/default
RUN mkdir /composer && chmod a+w /composer
ENV COMPOSER_HOME=/composer
ENV HOME=/home/default
# vendorフォルダのbinをPATHに追加する
ENV PATH=/src/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
COPY composer-installer.sh ./
RUN ./composer-installer.sh && mv ./composer.phar /usr/local/bin/composer && chmod a+x /usr/local/bin/composer
