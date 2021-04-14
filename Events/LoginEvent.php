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

    public $user;

    public $result;

    public $error;

    public function __construct(string $provider, Profile $profile, $user)
    {
        parent::__construct();

        $this->provider = $provider;

        $this->profile = $profile;

        $this->user = $user;
    }

}