<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Events;

class LogoutEvent extends \BasicApp\Event\BaseEvent
{

    public $provider;

    public function __construct(string $provider)
    {
        parent::__construct();

        $this->provider = $provider;
    }

}