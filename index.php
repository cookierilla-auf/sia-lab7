<?php

require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->get('/', function() {
    echo "Welcome to the AUF SIA API Platform";
});

$router->run();