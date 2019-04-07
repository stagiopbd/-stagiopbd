#!/bin/sh
while true; do
    # cmd=`php artisan dbconnection`
    # echo Output: $cmd
    if [[ $(php artisan dbconnection) == "success" ]]; then
        break
    fi
    sleep .5
done

composer install
php artisan migrate
php artisan db:seed