<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategory extends Migration
{
    protected $table = 'category';

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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => false
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
