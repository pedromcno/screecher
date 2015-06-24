<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once '../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;
$app['database'] = new PDO('127.0.0.1', 'root', '');

$app->get('/', function() use($app) {
    return 'Hello Igor! Your Silex application is up and running. Woot!';
});

$app->post('/', function (Request $request) {
    $message = $request->get('message');
    return new Response('You said: "' . $message . '". Thank you!', 201);
});

$app->error(function (\Exception $e, $code) {
    return new Response('We are sorry, but something went terribly wrong.');
});

$app->run();