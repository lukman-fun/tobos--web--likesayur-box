<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCart extends Migration
{

    protected $table = 'cart';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'auto_increment' => true,
                'null'=> true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned'=> true,
                'null' => true
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned'=> true,
                'null' => true
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 16,
                'null' => false,
                'default' => 0
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
