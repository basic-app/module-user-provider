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
use BasicApp\UserProvider\Models\UserProvider as UserProviderModel;
use BasicApp\UserProvider\Events\CreateUserEvent;
use Hybridauth\Exception\RuntimeException;

class UserProvider
{

    protected $hybridAuth;

    protected $userProviderModel;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->userProviderModel = model(UserProviderModel::class);

        Assert::notEmpty($this->userProviderModel, 'Model not found: ' . UserProviderModel::class);

        $config = [
            'callback' => Util::getCurrentUrl(false)
        ];

        foreach($this->config->providers as $name => $class)
        {
            if (!$class)
            {
                continue;
            }

            $adapterConfig = config($class);

            Assert::notEmpty($adapterConfig, 'Config not found: ' . $class);

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

    public function adapterName(object $adapter)
    {
        return (new ReflectionClass($adapter))->getShortName();
    }

    public function getUserByProfile(string $provider, $profile, & $error = null) : ?int
    {
        Assert::notEmpty($profile->identifier, 'Profile identifier empty.');
   
        $userProvider = $this->userProviderModel->where('provider', $provider)
            ->where('identifier', $profile->identifier)
            ->one();

        if ($userProvider)
        {
            $userID = $userProvider->user_id;
        }
        else
        {
            $userID = user_id();

            if (!$userID)
            {
                $adapter = $this->getAdapter($provider);

                Assert::notEmpty($adapter, 'Adapter not found.');

                $providerId = $this->adapterName($adapter);

                $event = CreateUserEvent::trigger($providerId, $profile, $error);

                if (!$event->userID)
                {
                    $error = $event->error;

                    return null;                    
                }

                $userID = $event->userID;
            }

            $userProvider = $this->userProviderModel->createData([
                'provider' => $providerId,
                'identifier' => $profile->identifier,
                'user_id' => $userID
            ]);

            $this->userProviderModel->saveOrFail($userProvider);
        }

        return $userID;
    }

    public function getUserProfileByAccessToken(string $name, $accessToken)
    {
        $adapter = $this->getAdapter($name);

        Assert::notEmpty($adapter, 'Adapter not found.');

        $adapter->setAccessToken($accessToken);

        return $adapter->getUserProfile();
    }

    public function onLogin($event)
    {
        // Nothing to do...
    }

    public function onLogout($event)
    {
        try
        {
            $this->hybridAuth->disconnectAllAdapters();
        }
        catch(RuntimeException $e)
        {
            $event->result = false;

            $event->error = $e->getMessage();
        }
    }

}