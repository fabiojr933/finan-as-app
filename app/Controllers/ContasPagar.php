<?php

namespace App\Controllers;

use App\Models\ContasPagarModel;
use App\Models\DespesaFormaBaixaModel;
use App\Models\FluxoModel;
use App\Models\FormaBaixaPagamentoModel;
use App\Models\FornecedorModel;
use App\Models\PagamentoModel;
use App\Models\ReceitaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class ContasPagar extends Controller
{
    private $session;
    private $dbFornecedor;
    private $dbUsuario;
    private $dbFluxo;
    private $dbContasPagar;
    private $dbPagamento;
    private $dbFormaPagamento;
    private $dbDespesaForma;

    function __construct()
    {
        $this->session = session();
        $this->dbContasPagar = new ContasPagarModel();
        $this->dbFornecedor = new FornecedorModel();
        $this->dbUsuario = new UsuarioModel();
        $this->dbFluxo = new FluxoModel();
        $this->dbPagamento = new PagamentoModel();
        $this->dbFormaPagamento = new FormaBaixaPagamentoModel();
        $this->dbDespesaForma = new DespesaFormaBaixaModel();
    }

    public function index()
    {
        $dados['contasPagar'] = $this->dbContasPagar->where(['contaspagar.id_usuario' => $this->session->get('id_usuario'), 'contaspagar.status' => 'Pendente'])
            ->select('
            contaspagar.id_contas_pagar,
            fornecedor.nome,
            contaspagar.vencimento,
            contaspagar.valor,
            contaspagar.status
        ')
            ->join('fornecedor', 'contaspagar.id_fornecedor = fornecedor.id_fornecedor')
            ->orderBy('contaspagar.vencimento', 'ASC')
            ->findAll();

        $dados2['contasPagarPagos'] = $this->dbContasPagar->where(['contaspagar.id_usuario' => $this->session->get('id_usuario'), 'contaspagar.status' => 'Pago'])
            ->select('
            contaspagar.id_contas_pagar,
            fornecedor.nome,
            contaspagar.vencimento,
            contaspagar.valor,
            contaspagar.status
        ')
            ->join('fornecedor', 'contaspagar.id_fornecedor = fornecedor.id_fornecedor')
            ->orderBy('contaspagar.vencimento', 'ASC')
            ->findAll();

        $despesa['despesa'] = $this->dbFluxo->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $pagamento['pagamento'] = $this->dbPagamento->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $mergedData = array_merge($dados, $dados2, $despesa, $pagamento);

        echo View('templates/header');
        echo View('contasPagar/index', $mergedData);
        echo View('templates/footer');
    }

    public function novo()
    {

        $dados['fornecedor'] = $this->dbFornecedor->where('id_usuario', $this->session->get('id_usuario'))->findAll();        
        echo View('templates/header');
        echo View('contasPagar/formulario', $dados);
        echo View('templates/footer');
    }

    public function salvar()
    {
        $request = request();
        $valor = $request->getPost('valor');
        $valor = str_replace(',', '.', preg_replace('/[^\d,]/', '',  $valor));
        $valor = floatval($valor);

        $dados = [
            'status'          => $request->getPost('status'),
            'descricao'       => $request->getPost('descricao'),
            'vencimento'      => $request->getPost('vencimento'),
            'valor'           => floatval($valor),
            'id_fornecedor'      => intval($request->getPost('id_fornecedor')),
            'id_usuario'      => intval($this->session->get('id_usuario')),
            'observacao'     => $request->getPost('observacao'),
        ];
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas a pagar cadastrada com sucesso!'
            ]
        );

        $this->dbContasPagar->insert($dados);
        return redirect()->to('contasPagar');
    }

    public function visualizar($id)
    {
        $dados['contasPagar'] = $this->dbContasPagar->where(['contaspagar.id_usuario' => $this->session->get('id_usuario'), 'contaspagar.id_contas_pagar' => $id])
            ->select('
            contaspagar.id_contas_pagar,
            fornecedor.nome,
            fornecedor.id_fornecedor,
            contaspagar.vencimento,
            contaspagar.valor,
            contaspagar.status,
            contaspagar.observacao,
            contaspagar.descricao,
        ')
            ->join('fornecedor', 'contaspagar.id_fornecedor = fornecedor.id_fornecedor')
            ->first();
        echo View('templates/header');
        echo View('contasPagar/visualizar', $dados);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbContasPagar->where(['id_contas_pagar' => $request->getGet('id_contas_pagar'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas a pagar excluída com sucesso!'
            ]
        );
        return redirect()->to('/contasPagar');
    }

    public function pagamento()
    {
        $request = request();
        $id_contasPagar    = $request->getPost('id_contas_pagar_recebimento');
        $id_usuario          = $this->session->get('id_usuario');
        $valor               = $request->getPost('valor_contas_pagar');
        $valor               = str_replace(',', '.', preg_replace('/[^\d,]/', '',  $valor));
        $valor               = floatval($valor);
        $data                = date('Y-m-d');

        $contaPagar = [
            'status'         => 'Pago',
            'data_pagamento' => $data
        ];
        $this->dbContasPagar->where(['id_contas_pagar' => $id_contasPagar, 'id_usuario' => $id_usuario])->set($contaPagar)->update();

        $formaBaixaPagamento = [
            'data_pagamento'    => $data,
            'valor'             => $valor,
            'id_pagamento'      => $request->getPost('id_pagamento'),
            'id_contas_pagar'   => $id_contasPagar,
            'id_usuario'        => $this->session->get('id_usuario')
        ];

        $this->dbFormaPagamento->insert($formaBaixaPagamento);

        $despesaFormaBaixa = [
            'data_pagamento'    => $data,
            'valor'             => $valor,
            'id_conta_fluxo'    => $request->getPost('id_conta_fluxo'),
            'id_contas_pagar'   => $id_contasPagar,
            'id_usuario'        => $this->session->get('id_usuario')
        ];
        $this->dbDespesaForma->insert($despesaFormaBaixa);
       
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Conta paga com sucesso'
            ]
        );
        return redirect()->to('contasPagar');
    }


    public function cancelamento()
    {
        $request = request();
        $id = $request->getPost('id_contas_pagar2');

        $recebimento = $this->dbContasPagar->where(['id_contas_pagar' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();

        $this->dbDespesaForma->where(['id_usuario' => $this->session->get('id_usuario'), 'id_contas_pagar' => $recebimento['id_contas_pagar']])->delete();

        $this->dbFormaPagamento->where(['id_usuario' => $this->session->get('id_usuario'), 'id_contas_pagar' => $recebimento['id_contas_pagar']])->delete();


        $contaPagar = [
            'status'         => 'Pendente',
            'data_pagamento' => null
        ];
        $this->dbContasPagar->where(['id_contas_pagar' => $recebimento['id_contas_pagar'], 'id_usuario' => $this->session->get('id_usuario')])->set($contaPagar)->update();

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas a pagar esta pendente novamente'
            ]
        );
        return redirect()->to('contasPagar');
    }
}
