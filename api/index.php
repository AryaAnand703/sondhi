<?php

// 1. Prepare writable /tmp storage directory structure for Vercel
$storagePath = '/tmp/storage';
foreach ([
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Set LARAVEL_STORAGE_PATH environment variables BEFORE loading Laravel
putenv('LARAVEL_STORAGE_PATH=' . $storagePath);
$_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;

// 3. Set log channel and framework caches to /tmp
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';

putenv('APP_SERVICES_CACHE=' . $storagePath . '/services.php');
putenv('APP_PACKAGES_CACHE=' . $storagePath . '/packages.php');
putenv('APP_CONFIG_CACHE=' . $storagePath . '/config.php');
putenv('APP_ROUTES_CACHE=' . $storagePath . '/routes.php');
putenv('APP_EVENTS_CACHE=' . $storagePath . '/events.php');

// Forward Vercel serverless requests to Laravel's public index.php
require __DIR__ . '/../public/index.php';
