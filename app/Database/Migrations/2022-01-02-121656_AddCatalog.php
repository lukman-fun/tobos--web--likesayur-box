<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatalog extends Migration
{
    protected $table = 'catalog';

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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'sub_title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
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
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
