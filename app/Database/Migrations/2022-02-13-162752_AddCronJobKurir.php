<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCronJobKurir extends Migration
{
    protected $table = 'cronjob_kurir';

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
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => false
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true
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
