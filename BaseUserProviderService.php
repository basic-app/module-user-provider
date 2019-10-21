<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\UserProvider;

use Exception;
use ReflectionClass;
use BasicApp\UserProvider\Models\UserProviderModel;
use BasicApp\UserProvider\Models\UserProvider;
use BasicApp\User\Models\UserModel;
use BasicApp\User\Models\User;

abstract class BaseUserProviderService
{

    protected $_config;

    protected $_userService;

    public function __construct($config)
    {
        if (!$config)
        {
            throw new Exception('Config is required.');
        }

        $this->_config = $config;

        $this->_userService = service('user');
    }

    public function getAdapterConfig($provider, &$error = null)
    {
        if (!array_key_exists($provider, $this->_config->providers))
        {
            $error = 'Provider not found.';

            return false;
        }

        $class = $this->_config->providers[$provider];

        $return = config($class);

        if (!$return)
        {
            $error = 'Adapter config empty.';

            return false;
        }

        return $return;
    }

    public function createAdapter($config, &$error = null)
    {
        $class = $config->getAdapterClass();

        $config = get_object_vars($config);

        $adapter = new $class($config);

        return $adapter;
    }

    public function getAdapter($provider, &$error = null)
    {
        $config = $this->getAdapterConfig($provider, $error);

        if (!$config)
        {
            return false;
        }

        return $this->createAdapter($config, $error);
    }

    public function createUserByProfile($providerId, $profile, &$error = null)
    {
        $params = [
            UserModel::FIELD_PREFIX . 'name' => $profile->displayName
        ];

        return UserModel::createUser($params, $error);
    }

    public function getUserByProfile($providerId, $profile, &$error = null)
    {
        if (!$profile->identifier)
        {
            $error = 'Identifier is empty.';

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

    public function loginByAccessToken($adapter, $accessToken, $rememberMe = true, &$error = null)
    {
        $adapter->setAccessToken($accessToken);

        $profile = $adapter->getUserProfile();

        return $this->loginByProfile($adapter, $profile, $rememberMe, $error);
    }

}