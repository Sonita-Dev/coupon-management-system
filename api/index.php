<?php

declare(strict_types=1);

/**
 * Serve static files from /public through the PHP runtime.
 * This avoids Vercel static routing edge cases for Laravel + Vite setups.
 */
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestPath = urldecode($requestUri);
$publicRoot = realpath(__DIR__.'/../public');

if ($publicRoot !== false && $requestPath !== '/') {
    $staticExtensions = '/\.(?:css|js|map|json|txt|xml|jpg|jpeg|png|gif|svg|webp|ico|woff|woff2|ttf|eot)$/i';

    if (preg_match($staticExtensions, $requestPath) === 1) {
        $candidate = realpath($publicRoot.$requestPath);
        $allowedPrefix = rtrim($publicRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if ($candidate !== false && str_starts_with($candidate, $allowedPrefix) && is_file($candidate)) {
            $mimeType = mime_content_type($candidate) ?: 'application/octet-stream';
            $isManifest = str_ends_with($requestPath, '/manifest.json');
            $cacheControl = $isManifest
                ? 'public, max-age=300'
                : 'public, max-age=31536000, immutable';

            header('Content-Type: '.$mimeType);
            header('Cache-Control: '.$cacheControl);
            readfile($candidate);
            exit;
        }
    }
}

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
