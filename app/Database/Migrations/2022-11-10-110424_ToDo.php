<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ToDo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        $this->forge->createTable('to-do-list-php');
    }

    public function down()
    {
        $this->forge->dropTable('to-do-list-php');
    }
}
