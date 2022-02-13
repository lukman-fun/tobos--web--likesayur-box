<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaction extends Migration
{
    protected $table = 'transaction';

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
            'no_transaction' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'null' => true
            ],
            'data_delivery' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'process' => [
                'type' => 'ENUM("0", "1", "2", "3")',
                'default' => '0',
                'null' => false
            ],
            'status' => [
                'type' => 'ENUM("0", "1", "-1")',
                'default' => '0',
                'null' => false
            ],
            'kurir_id' => [
                'type' => 'INT',
                'constraint' => 16,
                'unsigned' => true,
                'null' => true
            ],
            'kurir_status' => [
                'type' => 'ENUM("0", "1", "-1")',
                'default' => '0',
                'null' => false
            ],
            'payment_id' => [
                'type' => 'VARCHAR',
                'default' => '60',
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
