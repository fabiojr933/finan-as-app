<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ContasReceberModel;
use App\Models\FluxoModel;
use App\Models\FormaBaixaPagamentoModel;
use App\Models\PagamentoModel;
use App\Models\ReceitaFormaBaixaModel;
use App\Models\ReceitaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class ContasReceber extends Controller
{
    private $session;
    private $dbCliente;
    private $dbUsuario;
    private $dbFluxo;
    private $dbReceita;
    private $dbContasReceber;
    private $dbPagamento;
    private $dbFormaPagamento;
    private $dbReceitaForma;

    function __construct()
    {
        $this->session = session();
        $this->dbContasReceber = new ContasReceberModel();
        $this->dbCliente = new ClienteModel();
        $this->dbUsuario = new UsuarioModel();
        $this->dbFluxo = new FluxoModel();
        $this->dbReceita = new ReceitaModel();
        $this->dbPagamento = new PagamentoModel();
        $this->dbFormaPagamento = new FormaBaixaPagamentoModel();
        $this->dbReceitaForma = new ReceitaFormaBaixaModel();
    }

    public function index()
    {
        $dados['contasReceber'] = $this->dbContasReceber->where(['contasreceber.id_usuario' => $this->session->get('id_usuario'), 'contasreceber.status' => 'Pendente'])
            ->select('
            contasreceber.id_contas_receber,
            cliente.nome,
            contasreceber.vencimento,
            contasreceber.valor,
            contasreceber.status
        ')
            ->join('cliente', 'contasreceber.id_cliente = cliente.id_cliente')
            ->orderBy('contasreceber.vencimento', 'ASC')
            ->findAll();

        $dados2['contasReceberPagos'] = $this->dbContasReceber->where(['contasreceber.id_usuario' => $this->session->get('id_usuario'), 'contasreceber.status' => 'Pago'])
            ->select('
            contasreceber.id_contas_receber,
            cliente.nome,
            contasreceber.vencimento,
            contasreceber.valor,
            contasreceber.status
        ')
            ->join('cliente', 'contasreceber.id_cliente = cliente.id_cliente')
            ->orderBy('contasreceber.vencimento', 'ASC')
            ->findAll();

        $receita['receita'] = $this->dbReceita->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $pagamento['pagamento'] = $this->dbPagamento->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $mergedData = array_merge($dados, $dados2, $receita, $pagamento);

        echo View('templates/header');
        echo View('contasReceber/index', $mergedData);
        echo View('templates/footer');
    }

    public function novo()
    {
        $dados['cliente'] = $this->dbCliente->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('contasReceber/formulario', $dados);
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
            'id_cliente'      => intval($request->getPost('id_cliente')),
            'id_usuario'      => intval($this->session->get('id_usuario')),
            'observacao'     => $request->getPost('observacao'),
        ];
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas a receber cadastrada com sucesso!'
            ]
        );

        $this->dbContasReceber->insert($dados);
        return redirect()->to('contasReceber');
    }

    public function visualizar($id)
    {
        $perfil['perfil'] = $this->dbUsuario->where('id_usuario', $this->session->get('id_usuario'))->first();
        $dados['contasReceber'] = $this->dbContasReceber->where(['contasreceber.id_usuario' => $this->session->get('id_usuario'), 'contasreceber.id_contas_receber' => $id])
            ->select('
            contasreceber.id_contas_receber,
            cliente.nome,
            cliente.id_cliente,
            contasreceber.vencimento,
            contasreceber.valor,
            contasreceber.status,
            contasreceber.observacao,
            contasreceber.descricao,
        ')
            ->join('cliente', 'contasreceber.id_cliente = cliente.id_cliente')
            ->first();
        echo View('templates/header', $perfil);
        echo View('contasReceber/visualizar', $dados);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbContasReceber->where(['id_contas_receber' => $request->getGet('id_contas_receber'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas receber excluída com sucesso!'
            ]
        );
        return redirect()->to('/contasReceber');
    }

    public function pagamento()
    {
        $request = request();
        $id_contasReceber    = $request->getPost('id_contas_receber_recebimento');
        $id_usuario          = $this->session->get('id_usuario');
        $valor               = $request->getPost('valor_contas_receber');        
        $valor               = str_replace(',', '.', preg_replace('/[^\d,]/', '',  $valor));
        $valor               = floatval($valor);
        $data                = date('Y-m-d');
      
        $contaReceber = [
            'status'         => 'Pago',
            'data_pagamento' => $data
        ];
        $this->dbContasReceber->where(['id_contas_receber' => $id_contasReceber, 'id_usuario' => $id_usuario])->set($contaReceber)->update();

        $formaBaixaPagamento = [
            'data_pagamento'    => $data,
            'valor'             => $valor,
            'id_pagamento'      => $request->getPost('id_pagamento'),
            'id_contas_receber' => $id_contasReceber,
            'id_usuario'        => $this->session->get('id_usuario')
        ];

        $this->dbFormaPagamento->insert($formaBaixaPagamento);

        $receitaFormaBaixa = [
            'data_pagamento'    => $data,
            'valor'             => $valor,
            'id_receita'        => $request->getPost('id_receita'),
            'id_contas_receber' => $id_contasReceber,
            'id_usuario'        => $this->session->get('id_usuario')
        ];
        $this->dbReceitaForma->insert($receitaFormaBaixa);

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Conta PAGA com sucesso'
            ]
        );
        return redirect()->to('contasReceber');
    }


    public function cancelamento()
    {
        $request = request();
        $id = $request->getPost('id_contas_receber2');

        $recebimento = $this->dbContasReceber->where(['id_contas_receber' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();

        $this->dbReceitaForma->where(['id_usuario' => $this->session->get('id_usuario'), 'id_contas_receber' => $recebimento['id_contas_receber']])->delete();

        $this->dbFormaPagamento->where(['id_usuario' => $this->session->get('id_usuario'), 'id_contas_receber' => $recebimento['id_contas_receber']])->delete();


        $contaReceber = [
            'status'         => 'Pendente',
            'data_pagamento' => null
        ];
        $this->dbContasReceber->where(['id_contas_receber' => $recebimento['id_contas_receber'], 'id_usuario' => $this->session->get('id_usuario')])->set($contaReceber)->update();

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Contas a receber esta pendente novamente'
            ]
        );
        return redirect()->to('contasReceber');
    }
}
