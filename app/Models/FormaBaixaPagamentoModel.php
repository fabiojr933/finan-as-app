<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaBaixaPagamentoModel extends Model
{
    protected $table = 'formabaixapagamento';
    protected $primaryKey = 'id_forma_baixa_pagamento';
    protected $allowedFields = [
        'id_forma_baixa_pagamento',
        'data_pagamento',
        'valor',
        'id_pagamento',
        'id_lancamento',
        'id_contas_receber',
        'id_contas_pagar',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
