<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Fornecedor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_fornecedor'         => [
                'type'              => 'INT',
                'constraint'        => 9,
                'usigned'           => true,
                'auto_increment'    => true
            ],
            'nome'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 128,
                'null'              => true,
            ],
            'id_usuario'            => [
                'type'              => 'INT',
                'constraint'        => 9,
            ],
            'created_at'            => [
                'type'              => 'DATETIME'
            ],
            'updated_at'            => [
                'type'              => 'DATETIME'
            ],
            'deleted_at'            => [
                'type'              => 'DATETIME'
            ]
        ]);
        $this->forge->addKey('id_fornecedor', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario');
        $this->forge->createTable('fornecedor');
    }

    public function down()
    {
        $this->forge->dropTable('fornecedor');
    }
}
