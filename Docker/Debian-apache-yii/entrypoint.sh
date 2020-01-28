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

user="${APACHE_RUN_USER:-www-data}"
group="${APACHE_RUN_GROUP:-www-data}"

# strip off any '#' symbol ('#1000' is valid syntax for Apache)
pound='#'
user="${user#$pound}"
group="${group#$pound}"

if [ ! -e ${DEST}yii ] && [ -e ${ORIG}basic/yii ]; then
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
    echo >&2 "Yii not found in destination"
fi
	
echo >&2 "Starting apache..."
apachectl -DFOREGROUND

exec "$@"