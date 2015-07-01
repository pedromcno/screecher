<?php

require __DIR__.'/../src/bootstrap.php';

if ('test' == $app['env']) {
    return $app;
} else {
    $app->run();
}