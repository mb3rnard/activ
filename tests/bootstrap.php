<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// Should update expectations (api outputs, dumps, ...) automatically or not.
// Don't blindly update, check the diff!
define('UPDATE_EXPECTATIONS', filter_var(getenv('UPDATE_EXPECTATIONS'), FILTER_VALIDATE_BOOLEAN));

const FIXTURES_DIR = __DIR__ . '/fixtures';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
