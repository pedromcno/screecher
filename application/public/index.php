<?php

define('SCREECHER_PUBLIC_ROOT', __DIR__);

require_once '../vendor/autoload.php';

$app = new Silex\Application();
//
//$app['debug'] = true;
//$app['database'] = new PDO("mysql:host=localhost;dbname=mysql", 'root', '');
//
//$app->get('/', function() use($app) {
//    return 'Hello Igor! Your Silex application is up and running. Woot!';
//});
//
//$app->post('/', function (Request $request) {
//    $message = $request->get('message');
//    return new Response('You said: "' . $message . '". Thank you!', 201);
//});
//
//$app->error(function (\Exception $e, $code) {
//    return new Response('We are sorry, but something went terribly wrong.');
//});
//
//$app->run();

require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../src/app.php';
require __DIR__.'/../src/routes.php';

$app->run();