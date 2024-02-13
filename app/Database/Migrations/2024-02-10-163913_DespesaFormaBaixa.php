<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DespesaFormaBaixa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_despesa_forma_baixa'    => [
                'type'              => 'INT',
                'constraint'        => 9,
                'usigned'           => true,
                'auto_increment'    => true
            ],
            'data_pagamento'        => [
                'type'              => 'DATE',
                'default'           => date('Y-m-d'),
            ],
            'valor'                 => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,2',
                'default'           => 0.00
            ],
            'id_conta_fluxo'          => [
                'type'              => 'INT',
                'constraint'        => 9,
                'null'              => true,
            ],
            'id_lancamento'             => [
                'type'              => 'INT',
                'constraint'        => 9,
                'null'              => true,
            ],                        
            'id_contas_pagar'       => [
                'type'              => 'INT',
                'constraint'        => 9,
                'null'              => true,
            ],
            'id_contas_receber'     => [
                'type'              => 'INT',
                'constraint'        => 9,
                'null'              => true,
            ],
            'id_usuario'            => [
                'type'              => 'INT',
                'constraint'        => 9,
                'null'              => true,
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
        $this->forge->addKey('id_despesa_forma_baixa', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario');
        $this->forge->addForeignKey('id_conta_fluxo', 'contafluxo', 'id_conta_fluxo');
        $this->forge->addForeignKey('id_lancamento', 'lancamento', 'id_lancamento');

        $this->forge->addForeignKey('id_contas_receber', 'contasreceber', 'id_contas_receber');
        $this->forge->addForeignKey('id_contas_pagar', 'contaspagar', 'id_contas_pagar');
        
        $this->forge->createTable('despesaformabaixa');
    }

    public function down()
    {
        $this->forge->dropTable('despesaformabaixa');
    }
}
