<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\UserProvider\Models;

use BasicApp\User\Models\UserModel;

abstract class BaseUserProvider extends \BasicApp\Core\Entity
{

    protected $modelClass = UserProviderModel::class;

    public function getUser()
    {
        return UserModel::findByPk($this->user_id);
    }

}