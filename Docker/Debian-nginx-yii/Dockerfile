FROM debian:buster-slim
LABEL   version="1.0" \
        author="Lorenzo Lombardi" \
        email="thelozspot@gmail.com"

#Debian essential tools & nginx
RUN apt-get -y update && apt-get -y upgrade
RUN apt-get install -y curl gnupg2 ca-certificates lsb-release wget procps vim less
RUN echo "deb http://nginx.org/packages/mainline/debian `lsb_release -cs` nginx" \ | tee /etc/apt/sources.list.d/nginx.list
RUN curl -fsSL https://nginx.org/keys/nginx_signing.key | apt-key add -
RUN apt-get update
RUN apt-get install nginx
COPY default.conf /etc/nginx/conf.d/default.conf
ENV NGINX_RUN_USER root
ENV NGINX_WEB_USER www-data
ENV NGINX_WEB_GROUP www-data

#Installing php and extensions
RUN apt-get -y install php php-bcmath php-fpm \
php-bz2 php-intl php-xsl php-gd php-mbstring php-mysql \
php-zip php-xml php-mysql php-pgsql \
php-sqlite3 php-memcache php-memcached \
php-gettext php7.3-opcache php-net-ftp php-igbinary \
php-json php-mbstring php-msgpack php-readline php-net-socket \
php-tokenizer php-imagick

#Installing composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

#Clean packages directory
RUN apt-get clean && apt-get autoclean && apt-get autoremove

VOLUME ["/var/www/html/public","/var/src/private"]

#Installing YII
RUN wget https://github.com/yiisoft/yii2/releases/download/2.0.32/yii-basic-app-2.0.32.tgz
RUN tar zxvf yii-basic-app-2.0.32.tgz -C /usr/src/
RUN rm yii-basic-app-2.0.32.tgz
RUN mkdir -p /usr/src/basic/log
RUN chown -R www-data:www-data /usr/src/basic
RUN chmod 777 /usr/src/basic/web/assets
RUN chmod 777 /usr/src/basic/runtime
ENV YII_VERSION 2.0.32

COPY entrypoint.sh /usr/local/bin/

ENTRYPOINT ["bash", "entrypoint.sh"]
