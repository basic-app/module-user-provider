<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\UserProvider\Database\Migrations;

use BasicApp\User\Models\UserModel;

class CreateUserProviderTable extends \BasicApp\Core\Migration
{

    public $tableName = 'user_provider';

    public function up()
    {
        $this->forge->addField([
            'id' => $this->primaryKey()->toArray(),
            'created' => $this->created()->toArray(),
            'provider' => $this->string(63)->toArray(),
            'identifier' => $this->string(127)->toArray(),
            'user_id' => $this->foreignKey()->toArray()
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey(['provider', 'identifier'], false, true);

        $this->forge->addKey('provider', false, false);

        $this->forge->addForeignKey('user_id', 'user', UserModel::FIELD_PREFIX . 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName);
    }

}