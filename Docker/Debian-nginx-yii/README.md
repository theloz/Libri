## Launch command

    docker run -p 80:80 -v /home/loz/volumes/www/basic:/var/www/html/basic -it -d --name="libri-dev" --restart=unless-stopped deb-nginx-yii2
