<?php

passthru(sprintf(
    'php "%s/../bin/console" doctrine:database:create --if-not-exists --quiet --env=test',
    __DIR__
));

require __DIR__.'/../vendor/autoload.php';
