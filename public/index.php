<?php

define('LARAVEL_START', microtime(true));

// Set safe PHP upload temp folder for mobile uploads
$tmpPath = realpath(__DIR__ . '/../storage') . '/tmp';
if (!file_exists($tmpPath)) {
    mkdir($tmpPath, 0775, true);
}
ini_set('upload_tmp_dir', $tmpPath);

// Check maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
