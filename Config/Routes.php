<?php

$routes->add('user-provider', 'BasicApp\UserProvider\Controllers\UserProvider::index');
$routes->add('user-provider/(:segment)', 'BasicApp\UserProvider\Controllers\UserProvider::$1');
$routes->add('user-provider/(:segment)/(:segment)', 'BasicApp\UserProvider\Controllers\UserProvider::$1/$2');
$routes->add('user-provider/(:segment)/(:segment)/(:segment)', 'BasicApp\UserProvider\Controllers\UserProvider::$1/$2/$3');