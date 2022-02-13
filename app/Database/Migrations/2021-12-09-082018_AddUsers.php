<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
    protected $table = 'users';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => true
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'unique' => true
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable($this->table, TRUE);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
