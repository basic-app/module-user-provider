<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\UserProvider\Models;

abstract class BaseUserProviderModel extends \BasicApp\Core\Model
{

    protected $table = 'user_provider';

    protected $primaryKey = 'id';

    protected $returnType = UserProvider::class;

}