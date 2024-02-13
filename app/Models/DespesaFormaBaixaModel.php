<?php

namespace App\Models;

use CodeIgniter\Model;

class DespesaFormaBaixaModel extends Model
{
    protected $table = 'despesaformabaixa';
    protected $primaryKey = 'id_despesa_forma_baixa';
    protected $allowedFields = [
        'id_despesa_forma_baixa',
        'data_pagamento',
        'valor',
        'id_conta_fluxo',
        'id_lancamento',
        'id_contas_pagar',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
