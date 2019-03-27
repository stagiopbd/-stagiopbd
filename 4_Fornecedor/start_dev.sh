# stop containers before doing anything
docker kill $(docker ps -q)

# remove previous information
rm -rf data/

docker-compose build

# start the containers
docker-compose -f docker-compose.development.yml up
