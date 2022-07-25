<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once 'autoload.php';
include 'debug.php';

use lib\Application;
use Util\Json;

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);

try {
    $Application = new Application();
} catch (Exception $e) {
    echo Json::returnJson([$e->getMessage()]);
    exit;
}
