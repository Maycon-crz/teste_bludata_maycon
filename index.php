<?php

use \CoffeeCode\Router\Router;

require __DIR__."/vendor/autoload.php";

$router = new Router(ROOT);
$router->namespace("Source\Controllers");

$router->group(null);
$router->get("/", "Web:home");
$router->get("/painel", "Web:painel");

$router->dispatch();

if ($router->error()) {
    var_dump($router->error());
}