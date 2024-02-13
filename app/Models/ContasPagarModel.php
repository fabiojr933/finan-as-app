<?php

namespace App\Models;

use CodeIgniter\Model;

class ContasPagarModel extends Model
{
    protected $table = 'contaspagar';
    protected $primaryKey = 'id_contas_pagar';
    protected $allowedFields = [
        'id_contas_pagar',
        'status',
        'descricao',
        'vencimento',
        'data_pagamento',
        'valor',
        'id_usuario',
        'id_fornecedor',
        'observacao',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
