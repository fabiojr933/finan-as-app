<?php

namespace App\Models;

use CodeIgniter\Model;

class FluxoModel extends Model
{
    protected $table = 'contafluxo';
    protected $primaryKey = 'id_conta_fluxo';
    protected $allowedFields = [
        'id_conta_fluxo',
        'nome',
        'id_usuario',
        'id_conta_dre',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
