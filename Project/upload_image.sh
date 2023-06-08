#!/bin/bash

# Stop execution if a step fails
set -e

IMAGE_NAME=git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2284 # Replace with your group's image name

# Ensure that dependencies are available
composer install
php artisan config:clear
php artisan clear-compiled
php artisan optimize

#docker buildx build --push --platform linux/amd64 -t $IMAGE_NAME .
#docker build -t $IMAGE_NAME .
#docker push $IMAGE_NAME

if [ "$(uname)" == "Darwin" ]; then
    # Do something under Mac OS X platform   
    echo 'You are on Mac OS X platform!'
    docker buildx build --push --platform linux/amd64 -t $IMAGE_NAME .     
elif [ "$(expr substr $(uname -s) 1 5)" = "Linux" ]; then
    # Do something under GNU/Linux platform
    echo 'You are on Linux platform!'
    docker build -t $IMAGE_NAME .
    docker push $IMAGE_NAME
    echo 'You are on Linux platform!'
elif [ "$(expr substr $(uname -s) 1 10)" = "MINGW32_NT" ]; then
    # Do something under 32 bits Windows NT platform
    echo 'You are on Windows32 platform!'
    docker build -t $IMAGE_NAME .
    docker push $IMAGE_NAME
elif [ "$(expr substr $(uname -s) 1 10)" = "MINGW64_NT" ]; then
    # Do something under 64 bits Windows NT platform
    echo 'You are on Windows64 platform!'
    docker build -t $IMAGE_NAME .
    docker push $IMAGE_NAME
fi
