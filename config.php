<?php

use Fvy\Group404\Db\DbConfiguration;
use Fvy\Group404\Db\DbConnection;
use Fvy\Psr4Autoloader;

const TEMPLATE_PATH = __DIR__ . '/src/Views';

define('ROOT', dirname(__FILE__));

$loader = new Psr4Autoloader;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('Fvy\Group404', __DIR__ . '/src');
//$loader->addNamespace('Fvy\Group404', __DIR__ . '/tests');

//DB connection
$dbConf = new DbConfiguration(
    "mysql",
    3306,
    "group404",
    "group404",
    "Z3pq76@y"
);

$dbConn = new DbConnection($dbConf);
$conn = $dbConn->getDsn();

$routes = [
    'user/([0-9]+)'  => 'home/index/$1',
    'form'           => 'home/form',
    '404error'       => 'home/show404',
    'anti-flood-page' => 'home/antiflood',
    '([0-9A-Za-z]+)' => 'home/redirect/$1',
    ''               => 'home/index',
];