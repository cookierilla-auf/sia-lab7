<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = getConnection();

$catModel = new \App\Models\CatModel($db);
$catController = new \App\Controllers\CatController($catModel);

$router = new \Bramus\Router\Router();

$router->mount('/cats', function() use ($router, $catController) {

    $router->get('/', function() use ($catController) {
        $catController->index();
    });

    $router->get('/(\d+)', function($id) use ($catController) {
        $catController->show($id);
    });

    $router->post('/', function() use ($catController) {
        $catController->store();
    });

    $router->put('/(\d+)', function($id) use ($catController) {
        $catController->update($id);
    });

    $router->delete('/(\d+)', function($id) use ($catController) {
        $catController->destroy($id);
    });
});

$router->run();
