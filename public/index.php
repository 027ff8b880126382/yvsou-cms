<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


define('LARAVEL_START', microtime(true));


$installedFlag = __DIR__ . '/../storage/installed.lock';
$installedconfigFlag = __DIR__ . '/../config/yvsou_config.php';
$inInstaller = strpos($_SERVER['REQUEST_URI'], '/install') !== false;

if (!file_exists($installedFlag) && !file_exists($installedconfigFlag) && !$inInstaller) {
    header('Location: /install/step1');
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
