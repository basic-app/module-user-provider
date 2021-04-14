<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Events;

class CreateUserEvent extends \BasicApp\Event\BaseEvent
{

    public $provider;

    public $profile;

    public $user;

    public $userID;

    public $error;

    public function __construct($provider, $profile)
    {
        parent::__construct();

        $this->provider = $provider;

        $this->profile = $profile;
    }

}