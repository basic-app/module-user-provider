<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
$routes->add('user-provider', '\BasicApp\UserProvider\Controllers\UserProvider::index');
$routes->add('user-provider/(:segment)', '\BasicApp\UserProvider\Controllers\UserProvider::$1');
$routes->add('user-provider/(:segment)/(:segment)', '\BasicApp\UserProvider\Controllers\UserProvider::$1/$2');
$routes->add('user-provider/(:segment)/(:segment)/(:segment)', '\BasicApp\UserProvider\Controllers\UserProvider::$1/$2/$3');