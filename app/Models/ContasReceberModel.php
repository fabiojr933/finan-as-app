<?php

namespace App\Models;

use CodeIgniter\Model;

class ContasReceberModel extends Model
{
    protected $table = 'contasreceber';
    protected $primaryKey = 'id_contas_receber';
    protected $allowedFields = [
        'id_contas_receber',
        'status',
        'descricao',
        'vencimento',
        'data_pagamento',
        'valor',
        'id_usuario',
        'id_cliente',
        'observacao',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
