<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = [
        'id_cliente',        
        'nome',        
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function inserirCliente($id)
    {
        $data = [         
            'nome'         => 'Cliente padrão',           
            'id_usuario'   => $id,
        ];
        $this->insert($data);
    }
}
