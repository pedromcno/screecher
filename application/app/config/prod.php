<?php

// Timezone.
date_default_timezone_set('Europe/Berlin');

// Cache
$app['cache.path'] = __DIR__ . '/../cache';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

//Mandrill key
$app['mandrill.settings'] = [
    'key' => 'sExYc5cfZGaauNIHplGzTw',
    'senderName' => 'Screecher App',
    'senderEmail' => 'support@screecher.com',
];

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'screecher',
    'user'     => 'root',
    'password' => '',
);

$app['api_log.path'] = __DIR__. '/../../api_usage.log';
