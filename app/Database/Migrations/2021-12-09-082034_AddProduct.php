<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProduct extends Migration
{
    protected $table = 'product';

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
            'category_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 16,
                'null' => false
            ],
            'discon' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => false,
                'default' => 0
            ],
            'max_buy_discon' => [
                'type' => 'INT',
                'constraint' => 16,
                'null' => false,
                'default' => 0
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 16,
                'null' => false,
                'default' => 0
            ],
            'information' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'per' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => false,
                'default' => ''
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
