<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
use CodeIgniter\Events\Events;

Events::on('login', function(...$params) {

    service('userProvider')->onLogin(...$params);
});

Events::on('logout', function(...$params) {

    service('userProvider')->onLogout(...$params);
});
