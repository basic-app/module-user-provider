<?php
/**
 * @license MIT
 * @author Basic App Dev Team
 */
namespace BasicApp\UserProvider\Models;

abstract class BaseUserProviderModel extends \BasicApp\Core\Model
{

    protected $table = 'user_provider';

    protected $primaryKey = 'id';

    protected $returnType = UserProvider::class;

}