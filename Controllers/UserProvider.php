<?php
/**
 * @license MIT
 * @author Basic App Dev Team
 */
namespace BasicApp\UserProvider\Controllers;

use BasicApp\UserProvider\Config\UserProvider as UserProviderConfig;
use Exception;

class UserProvider extends \BasicApp\Core\PublicController
{

    public function authenticate($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider, $error);

        if (!$adapter)
        {
            throw new Exception($error);
        }

        $profile = $adapter->getUserProfile();

        if ($profile)
        {
            if (!$userProvider->loginByProfile($profile, true, $error))
            {
                throw new Exception($error);
            }

            return $this->goHome();
        }

        $adapter->authenticate();
    }

}