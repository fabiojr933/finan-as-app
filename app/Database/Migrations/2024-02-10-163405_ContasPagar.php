<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContasPagar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_contas_pagar'       => [
                'type'              => 'INT',
                'constraint'        => 9,
                'usigned'           => true,
                'auto_increment'    => true
            ],
            'status'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 20
            ],
            'descricao'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 150
            ],
            'vencimento'                 => [
                'type'              => 'DATE',
            ],
            'data_pagamento'        => [
                'type'              => 'DATE',               
            ],
            'valor'                 => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,2',
                'default'           => 0.00
            ],
            'observacao'            => [
                'type'              => 'VARCHAR',
                'constraint'        => 255
            ],
            'id_usuario'            => [
                'type'              => 'INT',
                'constraint'        => 9,
            ],
            'id_fornecedor'            => [
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
        $this->forge->addKey('id_contas_pagar', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario');
        $this->forge->addForeignKey('id_fornecedor', 'fornecedor', 'id_fornecedor');
        $this->forge->createTable('contaspagar');
    }

    public function down()
    {
        $this->forge->dropTable('contaspagar');
    }
}
