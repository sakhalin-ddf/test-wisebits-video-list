<?php

declare(strict_types=1);

// load env variables
\Dotenv\Dotenv::createImmutable(\dirname(__DIR__), '.env')->load();

// define constants
\defined('YII_DEBUG') or \define('YII_DEBUG', (bool) $_ENV['APP_DEBUG']);
\defined('YII_ENV') or \define('YII_ENV', $_ENV['APP_ENV']);
