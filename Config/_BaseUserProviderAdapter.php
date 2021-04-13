<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Config;

use Exception;

abstract class BaseUserProviderAdapter extends \CodeIgniter\Config\BaseConfig
{

    protected $adapterClass;

    public $callback;

    public function __construct()
    {
        parent::__construct();

        if (!$this->adapterClass)
        {
            throw new Exception('Property ' . get_called_class() . '::$adapterClass is required.');
        }

        if (!$this->callback)
        {
            $this->callback = \Hybridauth\HttpClient\Util::getCurrentUrl(true);
        }
    }

    public function getAdapterClass()
    {
        return $this->adapterClass;
    }

}