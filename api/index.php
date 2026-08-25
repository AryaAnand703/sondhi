<?php

// Prepare writable /tmp directory structure for Vercel serverless execution
$tmpStorage = '/tmp/storage';
$dirs = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Set environment variables for serverless execution
putenv('APP_SERVICES_CACHE=' . $tmpStorage . '/services.php');
putenv('APP_PACKAGES_CACHE=' . $tmpStorage . '/packages.php');
putenv('APP_CONFIG_CACHE=' . $tmpStorage . '/config.php');
putenv('APP_ROUTES_CACHE=' . $tmpStorage . '/routes.php');
putenv('APP_EVENTS_CACHE=' . $tmpStorage . '/events.php');
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');

// Forward Vercel serverless requests to Laravel's public index.php
require __DIR__ . '/../public/index.php';
