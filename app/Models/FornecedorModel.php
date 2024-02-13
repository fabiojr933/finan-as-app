<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorModel extends Model
{
    protected $table = 'fornecedor';
    protected $primaryKey = 'id_fornecedor';
    protected $allowedFields = [
        'id_fornecedor',        
        'nome',       
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function inserirFornecedor($id)
    {
        $data = [          
            'nome'         => 'Fornecedor padrão',           
            'id_usuario'   => $id,
        ];
        $this->insert($data);
    }
}
