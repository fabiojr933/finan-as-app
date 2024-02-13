<?php

namespace App\Models;

use CodeIgniter\Model;

class ReceitaFormaBaixaModel extends Model
{
    protected $table = 'receitaformabaixa';
    protected $primaryKey = 'id_receita_forma_baixa';
    protected $allowedFields = [
        'id_receita_forma_baixa',
        'data_pagamento',
        'valor',
        'id_receita',
        'id_lancamento',
        'id_contas_receber',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
