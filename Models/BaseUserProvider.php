<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Models;

use BasicApp\UserProvider\Entities\UserProvider as UserProviderEntity;

abstract class BaseUserProvider extends \BasicApp\Model\BaseModel
{

    protected $table = 'user_provider';

    protected $primaryKey = 'id';

    protected $returnType = UserProviderEntity::class;

    protected $allowedFields = ['provider', 'identifier', 'user_id'];

}