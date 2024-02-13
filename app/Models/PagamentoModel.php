<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
    protected $table = 'pagamento';
    protected $primaryKey = 'id_pagamento';
    protected $allowedFields = [
        'id_pagamento',
        'nome',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function inserirPagamento($id)
    {
        $data = [
            [
                'nome'         => 'Pix',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Cartão de credito',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Cartão de debito',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Dinheiro',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Cheque',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Boleto',
                'id_usuario'   => $id,
            ],
            [
                'nome'         => 'Transferencia bancaria',
                'id_usuario'   => $id,
            ],
        ];
        foreach($data as $d){
            $this->insert($d);
        }       
    }
}
