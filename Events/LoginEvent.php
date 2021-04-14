<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Events;

use Hybridauth\User\Profile;

class LoginEvent extends \BasicApp\Event\BaseEvent
{

    public $provider;

    public $profile;

    public $userID;

    public $rememberMe;

    public $result;

    public $error;

    public $user;

    public function __construct(string $provider, Profile $profile, int $userID, bool $rememberMe = true)
    {
        parent::__construct();

        $this->provider = $provider;

        $this->profile = $profile;

        $this->userID = $userID;

        $this->rememberMe = $rememberMe;
    }

}