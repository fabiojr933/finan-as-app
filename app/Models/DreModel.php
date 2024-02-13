<?php

namespace App\Models;

use CodeIgniter\Model;

class DreModel extends Model
{
    protected $table = 'contadre';
    protected $primaryKey = 'id_conta_dre';
    protected $allowedFields = [
        'id_conta_dre',
        'nome',
        'id_usuario',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function inserirContaDre($id)
    {
        $data = [
            [
                'nome'       => 'Despesas com vendas',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesas fixa',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesa variavel',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesas com fornecedores',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesas com pro labore',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesas com imposto',
                'id_usuario' => $id,
            ],
            [
                'nome'      => 'Despesas financeiras',
                'id_usuario' => $id,
            ]
        ];


        foreach ($data as $dados) {
            $db2 = new FluxoModel();

            if ($dados['nome'] == 'Despesas com vendas') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Despesas com viagens',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Publicidade e propaganda',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Doações e patrocinios',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Brindes',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Comissões sobre venda',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Frete sobre compra',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }


            //Despesas fixas
            if ($dados['nome'] == 'Despesas fixa') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Aluguel',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Energia',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Agua',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Internet',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Mensalidade de sistema',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Segurança',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Seguro',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Honorarios profissionais',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Associações',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }

            //Despesa variavel
            if ($dados['nome'] == 'Despesa variavel') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Cartorio',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Correios',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Energia Elétrica',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Material de Escritório',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Gastos com Viagens e Estadias',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Despesas Bancárias',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Impressos e formularios',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Manutenção casa',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Manutenção maquina e equipamento',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Manutenção de veiculo',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Combustivel moto',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Combustivel carro',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Roupas e vestuarios',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Eventos diversos',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Refeições e lanches',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Custos de Manutenção de Sites de E-commerce',
                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }




            //Despesas com fornecedores
            if ($dados['nome'] == 'Despesas com fornecedores') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Fornecedores de mercadorias externos',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Fornecedores de mercadoria interno',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Fornecedores outros',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Fornecedores parceiros',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Desconto obtidos fornecedores',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Juros e multas pagas fornecedores',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }


            //Despesas com imposto
            if ($dados['nome'] == 'Despesas com imposto') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Simples',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Fgts',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Icms',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Iptu',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Alvara',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Ipva e seguro obrigatorios',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Contribuição sindical',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Irpj',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Irpf',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Issqn',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }



            //Despesas financeiras
            if ($dados['nome'] == 'Despesas financeiras') {
                $idFluxo = $this->insert($dados);

                $data2 = [
                    [
                        'nome'       => 'Pagamento de emprestimo bancario',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Financiamento',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Juros bancarios',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Perda e danos',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Tarifas bancarias',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ],
                    [
                        'nome'       => 'Taxas de custadias',

                        'id_usuario' => $id,
                        'id_conta_dre' => $idFluxo,
                    ]
                ];

                foreach ($data2 as $dados2) {
                    $db2->insert($dados2);
                }
            }
        }
    }
}
