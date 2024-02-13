<?php

namespace App\Controllers;

use App\Models\DespesaFormaBaixaModel;
use App\Models\ReceitaFormaBaixaModel;
use CodeIgniter\Controller;
use DateTime;

class Grafico extends Controller
{

    private $session;
    private $dbReceitaLancamento;
    private $dbDespesaLancamento;


    function __construct()
    {
        $this->session = session();
        $this->dbReceitaLancamento = new ReceitaFormaBaixaModel();
        $this->dbDespesaLancamento = new DespesaFormaBaixaModel();
    }

    public function receita()
    {
        $request = request();
        $data_inicio = $request->getGet('data_inicio');
        $data_final = $request->getGet('data_final');
        $dataAtual = new DateTime();
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


        $sqlReceita = "SELECT
                        r.id_receita,
                        r.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                        FROM  receita r
                        JOIN receitaformabaixa a ON a.id_receita = r.id_receita
                                            AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        WHERE r.id_usuario = '$id_usuario'
                        AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                        GROUP BY r.id_receita, r.nome;";

        $valoresReceita['valoresReceita'] =  $this->dbReceitaLancamento->query($sqlReceita)->getResultArray();

        if (empty($valoresReceita['valoresReceita']) || !is_array($valoresReceita['valoresReceita']) || count($valoresReceita['valoresReceita']) === 0) {           
            $valoresReceita['valoresReceita'] = [['nome' => 'Nenhum', 'total' => 0.01]];
        }

        $arrayData = array_merge($valoresReceita, $data);

   
        echo View('templates/header');
        echo View('grafico/receita', $arrayData);
        echo View('templates/footer');
    }


    public function despesa()
    {

        $request = request();
        $data_inicio = $request->getGet('data_inicio');
        $data_final = $request->getGet('data_final');
        $dataAtual = new DateTime();
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

        $sqlDespesa = "SELECT DISTINCT
                        f.id_conta_fluxo,
                        f.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                        FROM contafluxo f
                        JOIN despesaformabaixa a ON a.id_conta_fluxo = f.id_conta_fluxo
                                                AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        WHERE f.id_usuario = '$id_usuario'
                            AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                        GROUP BY f.id_conta_fluxo, f.nome; ";
        $valoresDespesa['valoresDespesa'] =  $this->dbDespesaLancamento->query($sqlDespesa)->getResultArray();

        if (empty($valoresDespesa['valoresDespesa']) || !is_array($valoresDespesa['valoresDespesa']) || count($valoresDespesa['valoresDespesa']) === 0) {           
            $valoresDespesa['valoresDespesa'] = [['nome' => 'Nenhum', 'total' => 0.01]];
        }

        $arrayData = array_merge($valoresDespesa, $data);


        echo View('templates/header');
        echo View('grafico/despesa', $arrayData);
        echo View('templates/footer');
    }

    public function pagamento()
    {

        $request = request();
        $data_inicio = $request->getGet('data_inicio');
        $data_final = $request->getGet('data_final');
        $dataAtual = new DateTime();
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

        $sqlpagamento = "SELECT DISTINCT
                        f.nome,
                        COALESCE(SUM(g.valor), '00.00') as total
                        FROM pagamento f
                        JOIN formabaixapagamento g on f.id_pagamento = g.id_pagamento                             
                        WHERE f.id_usuario = '$id_usuario'
                        AND g.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        GROUP BY f.nome;";

        $valoresPagamento['valoresPagamento'] =  $this->dbDespesaLancamento->query($sqlpagamento)->getResultArray();

        if (empty($valoresPagamento['valoresPagamento']) || !is_array($valoresPagamento['valoresPagamento']) || count($valoresPagamento['valoresPagamento']) === 0) {           
            $valoresPagamento['valoresPagamento'] = [['nome' => 'Nenhum', 'total' => 0.01]];
        }

        $arrayData = array_merge($valoresPagamento, $data);




        echo View('templates/header');
        echo View('grafico/pagamento', $arrayData);
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
