#!/usr/bin/php
<?php

echo "Bootstrapping machine...\n";

if (!copy('nginx/default', '/etc/nginx/sites-enabled/default')) {
    die("ERROR: Failed to copy default config for nginx.\n");
}

exec("service nginx restart");

echo "All done!\n\n";