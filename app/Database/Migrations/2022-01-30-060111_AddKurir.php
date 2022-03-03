<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKurir extends Migration
{
    protected $table = 'kurir';

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
                'constraint' => 16,
                'null' => true,
                'unique' => true
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
