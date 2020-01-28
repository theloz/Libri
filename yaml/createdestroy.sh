#!/bin/bash

if [ $2 = "www" ]; then
    if [ $1 = "create" ]; then
    echo "Creating www"
        kubectl create -f pv/wwwpv.yml
        kubectl create -f secrets/secret.yml
        kubectl create -f pvc/wwwpvc.yml
        kubectl create -f services/wwwservice.yml
        kubectl create -f webserver.yml
    elif [ $1 = "delete" ]; then
        echo "Deleting www..."
        kubectl delete -f webserver.yml
        kubectl delete -f services/wwwservice.yml
        kubectl delete -f pvc/wwwpvc.yml
        kubectl delete -f secrets/secret.yml
        kubectl delete -f pv/wwwpv.yml
    fi
elif [ $2 = "db" ]; then
    if [ $1 eq "create" ]; then
    echo "Creating db..."
        kubectl create -f pv/dbpv.yml
        kubectl create -f secrets/secret.yml
        kubectl create -f pvc/dbpvc.yml
        kubectl create -f services/dbservice.yml
        kubectl create -f db.yml
    elif [ $1 = "delete" ]; then
        echo "Deleting db..."
        kubectl delete -f db.yml
        kubectl delete -f services/dbservice.yml
        kubectl delete -f pvc/dbpvc.yml
        kubectl delete -f secrets/secret.yml
        kubectl delete -f pv/dbpv.yml
    fi
fi