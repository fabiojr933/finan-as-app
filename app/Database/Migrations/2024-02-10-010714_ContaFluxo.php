<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContaFluxo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_conta_fluxo'         => [
                'type'              => 'INT',
                'constraint'        => 9,
                'usigned'           => true,
                'auto_increment'    => true
            ],
            'nome'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 128
            ],
            'id_usuario'            => [
                'type'              => 'INT',
                'constraint'        => 9,
            ],
            'id_conta_dre'           => [
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
        $this->forge->addKey('id_conta_fluxo', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario');
        $this->forge->addForeignKey('id_conta_dre', 'contadre', 'id_conta_dre');
        $this->forge->createTable('contafluxo');     



    }

    public function down()
    {
        $this->forge->dropTable('contaFluxo');
    }
}
