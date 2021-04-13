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
use BasicApp\UserProvider\Events\CreateUserEvent;

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

        foreach($userProviderConfig->providers as $name => $class)
        {
            if (!$value)
            {
                continue;
            }

            $adapterConfig = config($class);

            Assert::notEmpty($adapterConfig, $class);

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

    public function adapterName(string $name)
    {
        return (new ReflectionClass($adapter))->getShortName();
    }

    public function getUserByProfile(string $name, $profile, &$error = null)
    {
        Assert::notEmpty($profile->identifier);
   
        $userProviderModel = model(UserProviderModel::class);

        $userProvider = $userProviderModel->where('provider', $providerId)
            ->where('identifier', $profile->identifier)
            ->one();

        if (!$userProfile)
        {
            $adapter = $this->getAdapter($name);

            Assert::notEmpty($adapter, 'Adapter not found.');

            $providerId = $this->adapterName($adapter);

            $event = CreateUserEvent::trigger($providerId, $userProfile);

            Assert::notEmpty($event->userID, 'User not found.');

            $userProvider = $userProviderModel->createEntity([
                'user_id' => $userID,
                'provider' => $providerId,
                'identifier' => $profile->identifier
            ]);

            $userProviderModel->saveOrFail($userProfile);
        }
 
        $user = $userProviderModel->user($userProvider);

        Assert::notEmpty($user);

        return $user;
    }

    public function getUserProfileByAccessToken(string $name, $accessToken)
    {
        $adapter = $this->getAdapter($name);

        Assert::notEmpty($adapter);

        $adapter->setAccessToken($accessToken);

        return $adapter->getUserProfile();
    }

}