<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\DespesaFormaBaixaModel;
use App\Models\FluxoModel;
use App\Models\FormaBaixaPagamentoModel;
use App\Models\FornecedorModel;
use App\Models\LancamentoModel;
use App\Models\PagamentoModel;
use App\Models\ReceitaFormaBaixaModel;
use App\Models\ReceitaModel;
use CodeIgniter\Controller;

class Lancamento extends Controller
{
    private $session;
    private $dbFornecedor;
    private $dbCliente;
    private $dbReceita;
    private $dbDespesa;
    private $dbPagamento;
    private $dbLanc;
    private $dbFormaPagamento;
    private $dbReceitaForma;
    private $dbDespesaForma;

    function __construct()
    {
        $this->session = session();
        $this->dbFornecedor = new FornecedorModel();
        $this->dbCliente = new ClienteModel();
        $this->dbReceita = new ReceitaModel();
        $this->dbDespesa = new FluxoModel();
        $this->dbPagamento = new PagamentoModel();
        $this->dbLanc = new LancamentoModel();
        $this->dbFormaPagamento = new FormaBaixaPagamentoModel();
        $this->dbReceitaForma = new ReceitaFormaBaixaModel();
        $this->dbDespesaForma = new DespesaFormaBaixaModel();
    }

    public function index()
    {
        $lancamento['lancamento'] = $this->dbLanc->where('id_usuario', $this->session->get('id_usuario'))->orderBy('id_lancamento', 'DESC')->findAll();
        echo View('templates/header');
        echo View('lancamento/index', $lancamento);
        echo View('templates/footer');
    }

    public function novo()
    {
        $fornecedor['fornecedor'] = $this->dbFornecedor->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $cliente['cliente']       = $this->dbCliente->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $receita['receita']       = $this->dbReceita->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $despesa['despesa']       = $this->dbDespesa->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $pagamento['pagamento']   = $this->dbPagamento->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $arrayDados = array_merge($fornecedor, $cliente, $receita, $despesa, $pagamento);
        echo View('templates/header');
        echo View('lancamento/formulario', $arrayDados);
        echo View('templates/footer');
    }
    public function salvar()
    {
        $request = request();
        $valor  = $request->getPost('valor');
        $valor = str_replace(',', '.', preg_replace('/[^\d,]/', '',  $valor));
        $valor = floatval($valor); 
        $lancamento = [
            'tipo'           => $request->getPost('tipo'),
            'descricao'      => $request->getPost('descricao'),
            'data_pagamento' => $request->getPost('data_pagamento'),
            'valor'          => $valor,
            'observacao'     => $request->getPost('observacao'),
            'status'         => 'Pago',
            'id_fornecedor'  => $request->getPost('id_fornecedor'),
            'id_cliente'     => $request->getPost('id_cliente'),
            'id_usuario'     => $this->session->get('id_usuario')
        ];
        $id_lancamento = $this->dbLanc->insert($lancamento);

        $formaBaixaPagamento = [
            'data_pagamento'  => $request->getPost('data_pagamento'),
            'valor'           => $valor,
            'id_pagamento'    => $request->getPost('id_pagamento'),
            'id_lancamento'   => $id_lancamento,
            'id_usuario'      => $this->session->get('id_usuario')
        ];

        $this->dbFormaPagamento->insert($formaBaixaPagamento);

        if (request()->getPost('tipo') == 'despesa') {
            $despesaFormaBaixa = [
                'data_pagamento'  => $request->getPost('data_pagamento'),
                'valor'           => $valor,
                'id_conta_fluxo'  => $request->getPost('id_despesa'),
                'id_lancamento'   => $id_lancamento,
                'id_usuario'      => $this->session->get('id_usuario')
            ];
            $this->dbDespesaForma->insert($despesaFormaBaixa);
        } else {
            $receitaFormaBaixa = [
                'data_pagamento'  => $request->getPost('data_pagamento'),
                'valor'           => $valor,
                'id_conta_fluxo'  => $request->getPost('id_receita'),
                'id_lancamento'   => $id_lancamento,
                'id_usuario'      => $this->session->get('id_usuario')
            ];
            $this->dbReceitaForma->insert($receitaFormaBaixa);
        }

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Lançamento feito com sucesso com sucesso!'
            ]
        );
        return redirect()->to('lancamento');
    }


    public function excluir()
    {
        $request = request();
        $id = $request->getPost('id_lancamento');

        $lancamento = $this->dbLanc->where(['id_lancamento' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();

        if ($lancamento['tipo'] == 'receita') {
            $this->dbReceitaForma->where(['id_usuario' => $this->session->get('id_usuario'), 'id_lancamento' => $lancamento['id_lancamento']])->delete();
        } else {
            $this->dbDespesaForma->where(['id_usuario' => $this->session->get('id_usuario'), 'id_lancamento' => $lancamento['id_lancamento']])->delete();
        }
        $this->dbFormaPagamento->where(['id_usuario' => $this->session->get('id_usuario'), 'id_lancamento' => $lancamento['id_lancamento']])->delete();
        $this->dbLanc->where(['id_usuario' => $this->session->get('id_usuario'), 'id_lancamento' => $lancamento['id_lancamento']])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Lançamento excluido com sucesso'
            ]
        );
        return redirect()->to('lancamento');
    }
}
