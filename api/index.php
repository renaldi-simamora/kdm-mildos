<?php

// Ensure serverless storage folders exist in /tmp
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Ensure SQLite database exists in writable /tmp if using SQLite
if (! getenv('DB_DATABASE') || getenv('DB_DATABASE') === database_path('database.sqlite')) {
    $defaultSqlite = __DIR__.'/../database/database.sqlite';
    $tmpSqlite = '/tmp/database.sqlite';

    if (file_exists($defaultSqlite) && ! file_exists($tmpSqlite)) {
        copy($defaultSqlite, $tmpSqlite);
    } elseif (! file_exists($tmpSqlite)) {
        touch($tmpSqlite);
    }

    putenv("DB_DATABASE={$tmpSqlite}");
    $_ENV['DB_DATABASE'] = $tmpSqlite;
    $_SERVER['DB_DATABASE'] = $tmpSqlite;
}

require __DIR__.'/../public/index.php';
