<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



require '../vendor/autoload.php';
require '../src/config/db.php';
$app = new \Slim\App;

//Customers Routes
require '../src/routes/customers.php';
$app->run();