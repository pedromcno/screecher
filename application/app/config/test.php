<?php

// include the prod configuration
require __DIR__.'/prod.php';

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'screecher_test',
    'user'     => 'root',
    'password' => '',
);

