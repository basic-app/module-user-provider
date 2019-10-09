<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\UserProvider\Controllers;

use Exception;

class UserProvider extends \BasicApp\Core\PublicController
{

    /**
     * Display profile (test)
     */
    public function profile($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider, $error);

        if (!$adapter)
        {
            throw new Exception($error);
        }

        if (!$adapter->isConnected())
        {
            throw new Exception('User is not connected.');
        }

        $profile = $adapter->getUserProfile();

        echo '<pre>';

        print_r($profile);

        echo '</pre>';
    }

    public function logout($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider, $error);

        if (!$adapter)
        {
            throw new Exception($error);
        }

        if ($adapter->isConnected())
        {
            $adapter->disconnect();
        }

        return $this->goHome();
    }

    public function login($provider, $rememberMe = 1)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider, $error);

        if (!$adapter)
        {
            throw new Exception($error);
        }

        $adapter->authenticate();

        if (!$adapter->isConnected())
        {
            throw new Exception('User is not connected.');
        }

        $profile = $adapter->getUserProfile();

        if (!$profile)
        {
            throw new Exception('User profile is empty.');
        }

        if (!$userProvider->loginByProfile($adapter, $profile, (bool) $rememberMe, $error))
        {
            throw new Exception($error);
        }

        return $this->goHome();
    }

}