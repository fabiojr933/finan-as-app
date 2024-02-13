<?php

namespace App\Controllers;

use App\Models\ContasPagarModel;
use App\Models\ContasReceberModel;
use App\Models\DespesaFormaBaixaModel;
use App\Models\LancamentoModel;
use App\Models\ReceitaFormaBaixaModel;
use CodeIgniter\Controller;
use DateTime;


class Inicio extends Controller
{
    private $session;
    private $dbContasPagar;
    private $dbContasReceber;
    private $dbReceitaFormaBaixa;
    private $dbDespesaFormaBaixa;

    function __construct()
    {
        $this->session = session();
        $this->dbContasPagar = new ContasPagarModel();
        $this->dbContasReceber = new ContasReceberModel();
        $this->dbReceitaFormaBaixa = new ReceitaFormaBaixaModel();
        $this->dbDespesaFormaBaixa = new DespesaFormaBaixaModel();
 
    }

    public function index()
    {
        $request = request();

        //data do request
        $data_inicio = $request->getGet('data_inicio');
        $data_final = $request->getGet('data_final');
        $dataAtual = new DateTime();

        //pega o mes e o ano atual; 
        $ano = $dataAtual->format('Y');
        $mes = $dataAtual->format('m');

        $datasMes = self::obterDatasMes($ano, $mes);
        if ($data_inicio == null || $data_final == null) {
            $data_inicio =  $datasMes['inicial'];
            $data_final =  $datasMes['final'];
        } else {
            $data_inicio =  $data_inicio;
            $data_final =  $data_final;
        }

        $data['data'] = [
            'data_inicio' => $data_inicio,
            'data_final'  => $data_final,
        ];

        $id_usuario = $this->session->get('id_usuario');


        $contas_a_receber['contas_a_receber'] = $this->dbContasReceber
            ->where(['id_usuario' => $id_usuario, 'status' => 'Pendente', 'vencimento >=' => $data_inicio, 'vencimento <=' => $data_final])
            ->selectSum('valor', 'contas_a_receber')->get()->getRow()->contas_a_receber;


        $contas_a_pagar['contas_a_pagar'] = $this->dbContasPagar
            ->where(['id_usuario' => $id_usuario, 'status' => 'Pendente', 'vencimento >=' => $data_inicio, 'vencimento <=' => $data_final])
            ->selectSum('valor', 'total_a_pagar')->get()->getRow()->total_a_pagar;

        $total_receita['total_receita'] = $this->dbReceitaFormaBaixa
            ->where(['id_usuario' => $id_usuario, 'data_pagamento >=' => $data_inicio, 'data_pagamento <=' => $data_final])
            ->selectSum('valor', 'total_receita')->get()->getRow()->total_receita;

        $total_despesa['total_despesa'] = $this->dbDespesaFormaBaixa
            ->where(['id_usuario' => $id_usuario, 'data_pagamento >=' => $data_inicio, 'data_pagamento <=' => $data_final])
            ->selectSum('valor', 'total_despesa')->get()->getRow()->total_despesa;


        $contas_recebido['contas_recebido'] = $this->dbContasReceber
            ->where(['id_usuario' => $id_usuario, 'status' => 'Pago', 'data_pagamento >=' => $data_inicio, 'data_pagamento <=' => $data_final])
            ->selectSum('valor', 'contas_recebido')->get()->getRow()->contas_recebido;


        $contas_pago['contas_pago'] = $this->dbContasPagar
            ->where(['id_usuario' => $id_usuario, 'status' => 'Pago', 'data_pagamento >=' => $data_inicio, 'data_pagamento <=' => $data_final])
            ->selectSum('valor', 'contas_pago')->get()->getRow()->contas_pago;

        $grafico_total_pago_pendente = "SELECT 
                                        a.status,
                                        SUM(a.valor) as total_pago   
                                    FROM contaspagar a
                                    WHERE 
                                        ((a.status = 'Pago' AND a.data_pagamento BETWEEN '$data_inicio' AND '$data_final') OR 
                                        (a.status = 'Pendente' AND a.vencimento BETWEEN '$data_inicio' AND '$data_final'))
                                        AND a.id_usuario = '$id_usuario'
                                    GROUP BY a.status;";

        $graficoPagarPago['graficoPagarPago'] =  $this->dbContasPagar->query($grafico_total_pago_pendente)->getResultArray();

        // print_r($graficoPagarPago); exit;
        if (empty($graficoPagarPago['graficoPagarPago']) || !is_array($graficoPagarPago['graficoPagarPago']) || count($graficoPagarPago['graficoPagarPago']) === 0) {
            $graficoPagarPago['graficoPagarPago'] = [['status' => 'Nenhum', 'total_pago' => 0.01]];
        }

        $grafico_total_receber_pendente = "SELECT 
                                        a.status,
                                        SUM(a.valor) as total_receber   
                                    FROM contasreceber a
                                    WHERE 
                                        ((a.status = 'Pago' AND a.data_pagamento BETWEEN '$data_inicio' AND '$data_final') OR 
                                        (a.status = 'Pendente' AND a.vencimento BETWEEN '$data_inicio' AND '$data_final'))
                                        AND a.id_usuario = '$id_usuario'
                                    GROUP BY a.status;";

        $graficoReceberPago['graficoReceberPago'] =  $this->dbContasReceber->query($grafico_total_receber_pendente)->getResultArray();

        if (empty($graficoReceberPago['graficoReceberPago']) || !is_array($graficoReceberPago['graficoReceberPago']) || count($graficoReceberPago['graficoReceberPago']) === 0) {
            $graficoReceberPago['graficoReceberPago'] = [['status' => 'Nenhum', 'total_receber' => 0.01]];
        }

        $dadosContasPagar['dadosContasPagar'] = $this->dbContasPagar->where(['contaspagar.id_usuario' => $this->session->get('id_usuario'), 'contaspagar.status' => 'Pendente'])
            ->select('
        contaspagar.id_contas_pagar,
        fornecedor.nome,
        contaspagar.vencimento,
        contaspagar.valor
    ')
            ->join('fornecedor', 'contaspagar.id_fornecedor = fornecedor.id_fornecedor')
            ->orderBy('contaspagar.vencimento', 'ASC')
            ->findAll(5);

        $dadosReceber['dadosReceber'] = $this->dbContasReceber->where(['contasreceber.id_usuario' => $this->session->get('id_usuario'), 'contasreceber.status' => 'Pendente'])
            ->select('
        contasreceber.id_contas_receber,
        cliente.nome,
        contasreceber.vencimento,
        contasreceber.valor,
        contasreceber.status
    ')
            ->join('cliente', 'contasreceber.id_cliente = cliente.id_cliente')
            ->orderBy('contasreceber.vencimento', 'ASC')
            ->findAll(5);

        $dadosReceitaLancamento['dadosReceitaLancamento'] = $this->dbReceitaFormaBaixa->where('receitaformabaixa.id_usuario', $this->session->get('id_usuario'))
            ->select('
        receita.nome,
        receitaformabaixa.valor,
        receitaformabaixa.data_pagamento')
            ->join('receita', 'receitaformabaixa.id_receita = receita.id_receita')
            ->orderBy('receitaformabaixa.data_pagamento', 'ASC')
            ->findAll(5);


        $dadosDespesaLancamento['dadosDespesaLancamento'] = $this->dbDespesaFormaBaixa->where('despesaformabaixa.id_usuario', $this->session->get('id_usuario'))
            ->select('
    contafluxo.nome,
    despesaformabaixa.valor,
    despesaformabaixa.data_pagamento')
            ->join('contafluxo', 'despesaformabaixa.id_conta_fluxo = contafluxo.id_conta_fluxo')
            ->orderBy('despesaformabaixa.data_pagamento', 'ASC')
            ->findAll(5);





        $sqlDias = "SELECT 
        DATE_FORMAT(todas_datas.dia, '%d.%m.%Y') AS dia,
        COALESCE(SUM(a.valor), 0.00) AS total
    FROM 
        (
            SELECT 
                DATE('$data_inicio' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) AS dia
            FROM 
                (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a,
                (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b,
                (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
            WHERE 
                '$data_inicio' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY BETWEEN '$data_inicio' AND '$data_final'
        ) todas_datas
    LEFT JOIN 
        despesaformabaixa a ON DATE(a.data_pagamento) = todas_datas.dia AND a.id_usuario = '$id_usuario'
    GROUP BY 
        todas_datas.dia
    ORDER BY 
        todas_datas.dia; ";



        $graficodias['graficodias'] =  $this->dbDespesaFormaBaixa->query($sqlDias)->getResultArray();
        if (empty($graficodias['graficodias']) || !is_array($graficodias['graficodias']) || count($graficodias['graficodias']) === 0) {
            $graficodias['graficodias'] = [['dia' => 'Nenhum', 'total' => 0.01]];
        }
  


        $arrayData = array_merge(
            $contas_a_pagar,
            $contas_a_receber,
            $total_receita,
            $total_despesa,
            $contas_recebido,
            $graficoPagarPago,
            $contas_pago,
            $graficoReceberPago,
            $dadosContasPagar,
            $dadosReceber,
            $dadosReceitaLancamento,
            $dadosDespesaLancamento,
            $graficodias,
            $data
        );


        echo View('templates/header');
        echo View('inicio/index', $arrayData);
        echo View('templates/footer');
    }

    function obterDatasMes($ano, $mes)
    {
        // Criar objeto DateTime para o primeiro dia do mês
        $dataInicial = new DateTime("$ano-$mes-01");

        // Obter o último dia do mês
        $ultimoDia = $dataInicial->format('t');

        // Criar objeto DateTime para o último dia do mês
        $dataFinal = new DateTime("$ano-$mes-$ultimoDia");

        // Retornar um array com as datas inicial e final
        return [
            'inicial' => $dataInicial->format('Y-m-d'),
            'final' => $dataFinal->format('Y-m-d'),
        ];
    }
}
