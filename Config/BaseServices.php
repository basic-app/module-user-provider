<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\UserProvider\Config;

use BasicApp\UserProvider\UserProviderService;

abstract class BaseServices extends \CodeIgniter\Config\BaseService
{

    public static function userProvider($getShared = true)
    {
        if (!$getShared)
        {
            $config = config(UserProvider::class);

            $service = new UserProviderService($config);

            return $service;
        }

        return static::getSharedInstance(__FUNCTION__);
    }

}