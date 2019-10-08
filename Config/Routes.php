<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
$routes->add('user-provider', 'BasicApp\UserProvider\Controllers\UserProvider::index');
$routes->add('user-provider/(:segment)', 'BasicApp\UserProvider\Controllers\UserProvider::$1');
$routes->add('user-provider/(:segment)/(:segment)', 'BasicApp\UserProvider\Controllers\UserProvider::$1/$2');