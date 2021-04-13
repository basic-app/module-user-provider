<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Config;

use BasicApp\UserProvider\Libraries\UserProviderService;

class Services extends \CodeIgniter\Config\BaseService
{

    public static function userProvider($getShared = true)
    {
        if (!$getShared)
        {
            $config = config(UserProvider::class);

            return new UserProviderService($config);
        }

        return static::getSharedInstance(__FUNCTION__);
    }

}