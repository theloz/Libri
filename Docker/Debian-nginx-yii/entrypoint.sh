#!/bin/bash

ORIG="/usr/src/"
DEST="/var/www/html/"

file_env() {
	local var="$1"
	local fileVar="${var}_FILE"
	local def="${2:-}"
	if [ "${!var:-}" ] && [ "${!fileVar:-}" ]; then
		echo >&2 "error: both $var and $fileVar are set (but are exclusive)"
		exit 1
	fi
	local val="$def"
	if [ "${!var:-}" ]; then
		val="${!var}"
	elif [ "${!fileVar:-}" ]; then
		val="$(< "${!fileVar}")"
	fi
	export "$var"="$val"
	unset "$fileVar"
}

user="${NGINX_WEB_USER:-www-data}"
group="${NGINX_WEB_GROUP:-www-data}"

if [ ! -e ${DEST}basic/yii ] && [ -e ${ORIG}basic/yii ]; then
    echo >&2 "Yii not found in $DEST - copying now..."

    cp -rp ${ORIG}basic $DEST
    rm -fr ${ORIG}basic

    # if the directory exists and WordPress doesn't appear to be installed AND the permissions of it are root:root, let's chown it (likely a Docker-created directory)
    #if [ "$(id -u)" = '0' ] && [ "$(stat -c '%u:%g' .)" = '0:0' ]; then
    #    chown "$user:$group" .
    #fi
    
    #generate cookivalidation key
    sed -i "s/'cookieValidationKey' => ''/'cookieValidationKey' => '$(date +%s | base64)'/g" /var/www/html/basic/config/web.php
else
    echo >&2 "Yii found in destination"
fi
#Setting PHP
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.3/fpm/php.ini
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 256M/g" /etc/php/7.3/cli/php.ini
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 256M/g" /etc/php/7.3/fpm/php.ini
sed -i "s/memory_limit = 128M/memory_limit = 4096M/g" /etc/php/7.3/fpm/php.ini
sed -i "s/max_execution_time = 30/max_execution_time = 120/g" /etc/php/7.3/fpm/php.ini

#Setting PHP-FPM
sed -i "s#listen = /run/php/php7.3-fpm.sock#listen = 127.0.0.1:9000#g" /etc/php/7.3/fpm/pool.d/www.conf
#
echo >&2 "Starting fpm...."
mkdir -p /run/php
/usr/sbin/php-fpm7.3 -D

echo >&2 "Starting nginx..."
nginx -g "daemon off;"

exec "$@"
