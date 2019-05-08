#!/bin/sh

# install dependencies if needed
echo "Installing dependencies"
composer install > /dev/null 2>&1

echo "Generating encryption key"
php artisan key:generate > /dev/null 2>&1

echo -e '############'
php artisan dbconnection
echo -e '############'

# wait for db connection
while true; do
    cmd=`php artisan dbconnection`
    echo Output: $cmd
    if [[ $cmd == "success" ]]; then
        echo exiting
        break
    fi
    sleep .5
done

# execute postscript commands
echo "Running migrations..."
php artisan migrate > /dev/null 2>&1
echo "Running seeders..."
php artisan db:seed > /dev/null 2>&1

exit 0
