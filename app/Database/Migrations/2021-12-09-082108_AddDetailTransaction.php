<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDetailTransaction extends Migration
{
    protected $table = 'detail_transaction';

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
            'transaction_id' => [
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
            ],
            'product_data' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 16,
                'null' => false
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
