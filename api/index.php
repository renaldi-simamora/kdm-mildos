<?php

/**
 * Vercel Serverless Bridge for Laravel
 *
 * Vercel's filesystem is read-only except for /tmp.
 * We redirect all writable paths (cache, views, logs, sessions) to /tmp
 * BEFORE Laravel boots, so every service provider picks up the correct paths.
 */

// ── 1. Create required writable directories in /tmp ────────────────────────
$tmpStorage = '/tmp/storage';
$tmpBootstrap = '/tmp/bootstrap';

foreach ([
    $tmpStorage.'/app/public',
    $tmpStorage.'/framework/cache/data',
    $tmpStorage.'/framework/sessions',
    $tmpStorage.'/framework/testing',
    $tmpStorage.'/framework/views',
    $tmpStorage.'/logs',
    $tmpBootstrap.'/cache',
] as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// ── 2. Copy bootstrap/cache PHP files to /tmp so Opcache can write them ────
$srcCache = __DIR__.'/../bootstrap/cache';
if (is_dir($srcCache)) {
    foreach (glob($srcCache.'/*.php') as $file) {
        $dest = $tmpBootstrap.'/cache/'.basename($file);
        if (! file_exists($dest)) {
            copy($file, $dest);
        }
    }
}

// ── 3. Set environment variables BEFORE Laravel reads them ─────────────────
// These tell Laravel where to write cache, sessions, views, and logs.
putenv('APP_STORAGE_PATH='.$tmpStorage);
putenv('APP_BOOTSTRAP_CACHE_PATH='.$tmpBootstrap.'/cache');

// Serverless-safe drivers (no database connection needed for sessions/cache)
putenv('SESSION_DRIVER=file');
putenv('CACHE_STORE=file');
putenv('LOG_CHANNEL=stderr');

// ── 4. Patch Laravel's storagePath and bootstrapPath at runtime ────────────
// We monkey-patch the Application instance right after it is created
// by wrapping the bootstrap/app.php require via an output buffer trick.
require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

// Override the storage and bootstrap paths on the already-created instance
$app->useStoragePath($tmpStorage);
$app->useBootstrapPath($tmpBootstrap.'/cache');

// ── 5. Handle the incoming request ────────────────────────────────────────
use Illuminate\Http\Request;

$app->handleRequest(Request::capture());
