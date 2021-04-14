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

        Assert::notEmpty($profile, 'Profile not found.');

        $providerId = $userProvider->adapterName($adapter, $rememberMe);

        $user = $userProvider->getUserByProfile($providerId, $profile);

        Assert::notEmpty($user, 'User not found.');

        $event = LoginEvent::trigger($providerId, $profile, $user);

        Assert::true($event->result, $event->error ?? 'Login failed.');

        return $this->goHome();
    }

    /**
     * Display profile (test)
     */
    public function profile($provider)
    {
        $userProvider = service('userProvider');

        $adapter = $userProvider->getAdapter($provider);

        Assert::true($adapter->isConnected(), 'User not connected.');

        $profile = $adapter->getUserProfile();

        echo '<pre>';

        print_r($profile);

        echo '</pre>';
    }

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

        //Assert::notFalse($event->result, $event->error ?? 'Logout failed.');

        return $this->goHome();
    }

}