printmsg() {
    echo -e "\e[33m\e[7m:: $1\e[0m"
}

printmsg "Stop containers before doing anything..."
docker kill $(docker ps -q) > /dev/null 2>&1

printmsg "Building dockerfiles..."
docker-compose build > /dev/null 2>&1

printmsg "Starting the containers..."
docker-compose up -d

printmsg "Executing postinstall script..."
docker-compose exec app ./postconfig.sh