<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Controllers;

use Exception;
use Webmozart\Assert\Assert;
use BasicApp\UserProvider\Events\LoginEvent;
use BasicApp\UserProvider\Events\LogoutEvent;

class UserProvider extends \CodeIgniter\Controller
{

    public function logout($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider);

        if ($adapter->isConnected())
        {
            $adapter->disconnect();
        }

        $providerId = $userProvider->adapterName($adapter);

        $event = LogoutEvent::trigger($providerId);

        Assert::true($event->result, 'Logout error.');

        return $this->goHome();
    }

    public function login($provider, $rememberMe = 1)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider);

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

        $providerId = $userProvider->adapterName($adapter, $rememberMe);

        $event = LoginEvent::trigger($providerId, $identifier, $profile);

        Assert::true($event->result, 'Login error.');

        return $this->goHome();
    }

    /**
     * Display profile (test)
     */
    public function profile($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider);

        if (!$adapter->isConnected())
        {
            throw new Exception('User is not connected.');
        }

        $profile = $adapter->getUserProfile();

        echo '<pre>';

        print_r($profile);

        echo '</pre>';
    }

}