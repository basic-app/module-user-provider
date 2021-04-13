<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Libraries;

use Exception;
use ReflectionClass;
use Hybridauth\HttpClient\Util;
use Hybridauth\Hybridauth;
use Webmozart\Assert\Assert;
use BasicApp\UserProvider\Config\UserProvider as UserProviderConfig;
use BasicApp\UserProvider\Models\UserProviderModel;
use BasicApp\UserProvider\Models\UserProvider;
use BasicApp\UserProvider\Events\LoginEvent;
use BasicApp\UserProvider\Events\LogoutEvent;

class UserProviderService
{

    protected $hybridAuth;

    public function __construct()
    {
        $config = [
            'callback' => Util::getCurrentUrl(false)
        ];

        $userProviderConfig = config(UserProviderConfig::class);

        Assert::notEmpty($userProviderConfig, UserProviderConfig::class);

        foreach(get_object_vars($userProviderConfig) as $key => $value)
        {
            $name = ucfirst($key);

            if (!$value)
            {
                continue;
            }

            $adapterConfig = config($value);

            Assert::notEmpty($adapterConfig, $value);

            $config['providers'][$name]['enabled'] = true;

            $config['providers'][$name]['keys'] = get_object_vars($adapterConfig);
        }

        $this->hybridAuth = new Hybridauth($config);
    }

    public function getAdapter(string $name)
    {
        $return = $this->hybridAuth->getAdapter($name);
    
        Assert::notEmpty($return);

        return $return;
    }



    /*

    public function createUserByProfile($providerId, $profile, &$error = null)
    {
        $params = [
            UserModel::FIELD_PREFIX . 'name' => $profile->displayName
        ];

        return UserModel::createUser($params, $error);
    }

    */

    /*

    public function getUserByProfile($providerId, $profile, &$error = null)
    {
        if (!$profile->identifier)
        {
            $error = lang('Identifier is empty.');

            return false;
        }

        $model = new UserProviderModel;

        $userProfile = $model
            ->where('provider', $providerId)
            ->where('identifier', $profile->identifier)
            ->first();

        if ($userProfile)
        {
            $user = $userProfile->getUser();

            if (!UserModel::getUserField($user, 'enabled'))
            {
                throw new Exception('Your account has been disabled.');
            }

            return $user;
        }
 
        $userService = service('user');

        $user = $userService->getUser();

        if (!$user)
        {
            $user = $this->createUserByProfile($providerId, $profile, $error);

            if (!$user)
            {
                return false;
            }
        }

        $provider = UserProviderModel::createEntity([
            'user_id' => UserModel::getUserField($user, 'id'),
            'provider' => $providerId,
            'identifier' => $profile->identifier
        ], true, false, $error);

        if (!$provider)
        {
            return false;
        }

        return $user;
    }

    */

    /*

    public function loginByProfile($adapter, $profile, $rememberMe = true, &$error = null)
    {
        $providerId = (new ReflectionClass($adapter))->getShortName();

        $user = $this->getUserByProfile($providerId, $profile, $error);

        if (!$user)
        {
            return false;
        }

        return $this->_userService->login($user, $rememberMe, $error);
    }

    */

    /*

    public function loginByAccessToken($adapter, $accessToken, $rememberMe = true, &$error = null)
    {
        $adapter->setAccessToken($accessToken);

        $profile = $adapter->getUserProfile();

        return $this->loginByProfile($adapter, $profile, $rememberMe, $error);
    }

    */

}