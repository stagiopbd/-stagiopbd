#!/bin/bash

while :
do
  docker-compose exec app php artisan producer-kafka;
  sleep 3600;
done
