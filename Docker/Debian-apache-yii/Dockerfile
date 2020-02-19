FROM debian:buster-slim
LABEL   version="1.0" \
        author="Lorenzo Lombardi" \
        email="thelozspot@gmail.com"
RUN apt-get -y update && apt-get -y upgrade
#Debian essential tools
RUN apt-get install -y curl unzip wget lsb-release apt-transport-https ca-certificates apt-utils vim
RUN apt-get update
#Installing php and extensions
RUN apt-get -y install php
RUN apt-get install -y php-bcmath \
php-bz2 php-intl php-xsl php-gd php-mbstring php-mysql \
php-zip php-xml php-mysql php-pgsql \
php-sqlite3 php-memcache php-memcached \
php-gettext php7.3-opcache php-net-ftp php-igbinary \
php-json php-mbstring php-msgpack php-readline php-net-socket \
php-tokenizer php-imagick
RUN apt-get install -y apache2

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
RUN chown -R www-data:www-data /usr/src/basic
RUN chmod 777 /usr/src/basic/web/assets
RUN chmod 777 /usr/src/basic/runtime
RUN chmod 777 /usr/src/basic/log
ENV YII_VERSION 2.0.32

# Configure apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

COPY entrypoint.sh /usr/local/bin/

ENTRYPOINT ["bash", "entrypoint.sh"]

#CMD ["%%CMD%%"]