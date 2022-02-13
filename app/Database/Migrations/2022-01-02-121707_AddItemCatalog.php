<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddItemCatalog extends Migration
{
    protected $table = 'item_catalog';

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
            'catalog_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'null' => true
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'null' => true
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
