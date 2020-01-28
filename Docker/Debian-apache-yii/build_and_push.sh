#!/bin/bash
docker build . -t deb-apache-yii
docker login
docker tag deb-apache-yii theloz/yii2-apache:debian-slim
docker push theloz/yii2-apache:debian-slim