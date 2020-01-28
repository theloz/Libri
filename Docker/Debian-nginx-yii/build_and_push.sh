#!/bin/bash
docker build . -t deb-nginx-yii2
docker login
docker tag deb-nginx-yii2 theloz/yii2-nginx:debian-slim
docker push theloz/yii2-nginx:debian-slim