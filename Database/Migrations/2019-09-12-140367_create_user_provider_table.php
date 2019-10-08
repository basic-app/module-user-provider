<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\UserProvider\Database\Migrations;

use BasicApp\User\Models\UserModel;

class CreateUserProviderTable extends \BasicApp\Core\Migration
{

    public $tableName = 'user_provider';

    public function up()
    {
        $this->forge->addField([
            'id' => $this->primaryKeyColumn(),
            'created' => $this->createdColumn(),
            'provider' => $this->stringColumn([static::CONSTRAINT => 63]),
            'identifier' => $this->stringColumn([static::CONSTRAINT => 127]),
            'user_id' => $this->foreignKeyColumn()
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey(['provider', 'identifier'], false, true);

        $this->forge->addKey('provider', false, false);

        $this->forge->addForeignKey('user_id', 'user', UserModel::FIELD_PREFIX . 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable($this->tableName);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

}