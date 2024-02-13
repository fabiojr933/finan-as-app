<?php

namespace App\Models;

use CodeIgniter\Model;

class ReceitaModel extends Model
{
    protected $table = 'receita';
    protected $primaryKey = 'id_receita';
    protected $allowedFields = [
        'id_receita',
        'nome',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function inserirReceita($id)
    {
        $data = [
            [
                'nome'       => 'Vendas a vista',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Entrada de venda a prazo',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Recebimento de duplicata',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Recebimento de juros e multa',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Outras entrada',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Salario',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Decimo 13°',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Pagamento de Serviços Prestados',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Aluguel de Propriedades',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Venda de Ativos',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Subsídios e Doações',               
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Comissões',               
                'id_usuario' => $id,
            ],
        ];
        foreach ($data as $dados) {          
            $this->insert($dados);
        }
    }

}
