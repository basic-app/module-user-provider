<?php
/**
 * @license MIT
 * @author Basic App Dev Team
 */
namespace BasicApp\UserProvider\Controllers;

use Exception;
use ReflectionClass;

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

        $providerId = (new ReflectionClass($adapter))->getShortName();

        $profile = $adapter->getUserProfile();

        if ($profile)
        {
            if (!$userProvider->login($providerId, $profile, true, $error))
            {
                throw new Exception($error);
            }

            return $this->goHome();
        }

        $adapter->authenticate();
    }

}