<?php

$app['controllers']->convert('apiId', function ($id) use ($app) {
    if ($id) {
        return $app['repository.api']->find($id);
    }
});

$app->get('/', 'Screecher\Controller\IndexController::indexAction')
    ->bind('homepage');

$app->match('/run_screecher', 'Screecher\Controller\ScreecherController::runAction')
    ->bind('run_screecher');

$app->match('/add_maintainer', 'Screecher\Controller\IndexController::addMaintainerAction')
    ->bind('add_maintainer');

$app->get('/api/api/{apiId}', 'Screecher\Controller\ApiApiController::viewAction')
    ->bind('api_show')->assert('apiId', '\d+');

$app->post('/api/maintainer', 'Screecher\Controller\ApiApiController::addMaintainerAction')
    ->bind('api_add_maintainer');
