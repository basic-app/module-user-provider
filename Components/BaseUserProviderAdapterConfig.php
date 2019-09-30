<?php
/**
 * @license MIT
 * @author Basic App Dev Team
 */
namespace BasicApp\UserProvider\Components;

use Exception;

class BaseUserProviderAdapterConfig extends \CodeIgniter\Config\BaseConfig
{

    public $adapterClass;

    public $config = [];

    public function __construct()
    {
        if (!$this->adapterClass)
        {
            throw new Exception('Property ' . get_called_class() . '::$adapterClass is required.');
        }

        if (!$this->config)
        {
            throw new Exception('Property ' . get_called_class() . '::$config is required.');
        }
    }

}