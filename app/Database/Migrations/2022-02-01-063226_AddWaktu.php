<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaktu extends Migration
{
    protected $table = 'waktu';

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
                'constraint' => 60,
                'null' => false
            ],
            'start' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true
            ],
            'end' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true
            ],
            'timezone' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
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
