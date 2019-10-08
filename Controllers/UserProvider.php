<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\UserProvider\Controllers;

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

        /*
        if ($adapter->isConnected())
        {
            $adapter->disconnect();
        }
        */

        $adapter->authenticate();

        if (!$adapter->isConnected())
        {
            throw new Exception('User is not connected.');
        }

        $profile = $adapter->getUserProfile();

        if (!$profile)
        {
            throw new Exception('Profile is empty.');
        }

        if (!$userProvider->loginByProfile($adapter, $profile, true, $error))
        {
            throw new Exception($error);
        }

        return $this->redirect(base_url());




        /*

        

        $profile = $adapter->getUserProfile();

        print_r($profile);

        var_dump($accessToken);

        die;
        */

        /*


        if ($accessToken)
        {

            var_dump($accessToken);

            die;

        }

        

        */
    }

}