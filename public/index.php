<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


define('LARAVEL_START', microtime(true));



$installedFlag = __DIR__ . '/../storage/installed.lock';
#$installedconfigFlag = __DIR__ . '/../config/yvsou_config.php';
$inInstaller = strpos($_SERVER['REQUEST_URI'], '/install') !== false;

if (!file_exists($installedFlag) && !$inInstaller) {

    // Check storage structure
    $dirs = [
        '../storage',
        '../storage/app',
        '../storage/framework',
        '../storage/app/private',
        '../storage/app/public',
        '../storage/app/protected-files',
        '../storage/framework/cache',
        '../storage/framework/sessions',
        '../storage/framework/testing',
        '../storage/framework/views',
        '../storage/logs',
    ];

    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true); // 0775 is more secure than 0777
        }
    }

    $filePath =  __DIR__ . '/../storage/tmp-install.sqlite';

    if (!file_exists($filePath)) {
        // Create an empty file
        file_put_contents($filePath, '');
    }

    header('Location: /install');
    exit;
}



// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
