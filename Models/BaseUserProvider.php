<?php
/**
 * @author Basic App Dev Team
 * @license MIT
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