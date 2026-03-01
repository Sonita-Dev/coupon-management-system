<?php

declare(strict_types=1);

// Vercel's filesystem is read-only except /tmp. Point Laravel cache artifacts there.
foreach ([
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_ROUTES_CACHE' => '/tmp/routes-v7.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_COMMANDS_CACHE' => '/tmp/commands.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
] as $key => $value) {
    if (! getenv($key)) {
        putenv($key.'='.$value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Vercel runs this file as the serverless entrypoint.
// Forward the request to Laravel's public front controller.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../public';

require __DIR__.'/../public/index.php';
