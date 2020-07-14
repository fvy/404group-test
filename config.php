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

// Routes to Controller
$routes = [
    // Testing form for user1-user3
    // http://domain-name/user/1/ - active
    // http://domain-name/user/2/ - NOT active token
    // http://domain-name/user/3/ - active
    //
    'user/([0-9]+)'  => 'home/index/$1',
    'form'           => 'home/form',
    //
    // Test page for  http://domain-name/6
    //
    '404error'       => 'home/show404',
    //
    // Anti-flood Page
    //
    'anti-flood-page' => 'home/antiflood',
    //
    // Redirects urls: http://domain-name/2Ti
    //
    '([0-9A-Za-z]+)' => 'home/redirect/$1',
    //
    // Home page: http://domain-name/
    //
    ''               => 'home/index',
];