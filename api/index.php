<?php

// Prepare storage directory structure in /tmp for serverless environment
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Ensure SQLite database exists in writable /tmp if using SQLite
$dbDatabase = getenv('DB_DATABASE');
$defaultSqlite = __DIR__.'/../database/database.sqlite';
$tmpSqlite = '/tmp/database.sqlite';

if (! $dbDatabase || $dbDatabase === $defaultSqlite || ! str_contains($dbDatabase, '/tmp/')) {
    if (file_exists($defaultSqlite) && ! file_exists($tmpSqlite)) {
        copy($defaultSqlite, $tmpSqlite);
    } elseif (! file_exists($tmpSqlite)) {
        touch($tmpSqlite);
    }

    putenv("DB_DATABASE={$tmpSqlite}");
    $_ENV['DB_DATABASE'] = $tmpSqlite;
    $_SERVER['DB_DATABASE'] = $tmpSqlite;
}

// Set storage path for serverless
putenv('APP_STORAGE=/tmp/storage');
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_SERVER['APP_STORAGE'] = '/tmp/storage';

require __DIR__.'/../public/index.php';
