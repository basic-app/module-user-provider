<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\UserProvider\Database\Migrations;

class Migration_CreateUserProviderTable extends \BasicApp\Migration\BaseMigration
{

    public $table = 'user_provider';

    public function up()
    {
        $this->forge->addField([
            'id' => $this->primaryKey()->toArray(),
            'created' => $this->created()->toArray(),
            'user_id' => $this->foreignKey()->toArray(),
            'provider' => $this->string(63)->toArray(),
            'identifier' => $this->string(127)->toArray()
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey(['provider', 'identifier'], false, true);

        $this->forge->addKey('provider', false, false);

        $this->forge->addForeignKey('user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }

}