<?php

declare(strict_types=1);

// Vercel runs this file as the serverless entrypoint.
// Forward the request to Laravel's public front controller.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../public';

require __DIR__.'/../public/index.php';
