<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

// Base de données de test recréée à chaque exécution, avec les fixtures.
$console = escapeshellarg(PHP_BINARY).' '.escapeshellarg(dirname(__DIR__).'/bin/console').' --env=test -q';
passthru($console.' doctrine:schema:drop --force --full-database');
passthru($console.' doctrine:schema:create');
passthru($console.' doctrine:fixtures:load -n');
