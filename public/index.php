<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Fvy\Group404\Components\Router;
use Fvy\Group404\Db\DbMapper;
use Fvy\Group404\Db\DbUsers;
use Fvy\Group404\Db\DbUsersStats;

require_once '../src/Psr4Autoloader.php';
require_once '../config.php';

$dbMapper = new DbMapper($conn);
$dbUsers = new DbUsers($conn);
$dbUsersStats = new DbUsersStats($conn);

$router = new Router($routes);
$router->run();