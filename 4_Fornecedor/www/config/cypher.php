<?php

return [
    'ssl' => false,
    'connection' => 'default',
    'host'   => env('DB_HOST_NEO', '35.226.117.219'),
    'port'   => env('DB_PORT_NEO', '7474'),
    'username' => env('DB_USERNAME_NEO', 'neo4j'),
    'password' => env('DB_PASSWORD_NEO', 'stagie')
];