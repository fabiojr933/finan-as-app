<?php

namespace App\Controllers;

use App\Models\DespesaFormaBaixaModel;
use App\Models\DreModel;
use App\Models\FluxoModel;
use App\Models\ReceitaFormaBaixaModel;
use App\Models\ReceitaModel;
use CodeIgniter\Controller;
use DateTime;

class Dre extends Controller
{
    private $session;
    private $dbReceita;
    private $dbContaDre;
    private $dbContaFluxo;
    private $dbReceitaLancamento;
    private $dbDespesaLancamento;

    function __construct()
    {
        $this->session = session();
        $this->dbReceita = new ReceitaModel();
        $this->dbContaDre = new DreModel();
        $this->dbContaFluxo = new FluxoModel();
        $this->dbReceitaLancamento = new ReceitaFormaBaixaModel();
        $this->dbDespesaLancamento = new DespesaFormaBaixaModel();
    }

    public function sintetico()
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

        $receita['receita'] = $this->dbReceita->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $contaDre['contaDre'] = $this->dbContaDre->where('id_usuario', $this->session->get('id_usuario'))->findAll();

        $sqlDespesa = "SELECT DISTINCT
                        c.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                        FROM contafluxo f
                        LEFT JOIN contadre c on c.id_conta_dre = f.id_conta_dre
                        LEFT JOIN despesaformabaixa a ON a.id_conta_fluxo = f.id_conta_fluxo
                                                AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        WHERE f.id_usuario = '$id_usuario'
                            AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                        GROUP BY c.nome; ";
        $valoresDespesa['valoresDespesa'] =  $this->dbDespesaLancamento->query($sqlDespesa)->getResultArray();

        $sqlReceita = "SELECT
                        r.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                       FROM  receita r
                       LEFT JOIN receitaformabaixa a ON a.id_receita = r.id_receita
                                            AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                    WHERE r.id_usuario = '$id_usuario'
                        AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                    GROUP BY  r.nome;";

        $valoresReceita['valoresReceita'] =  $this->dbReceitaLancamento->query($sqlReceita)->getResultArray();

        $arrayData = array_merge($receita, $contaDre, $valoresReceita, $valoresDespesa, $data);

       // print_r($arrayData); exit;
        echo View('templates/header');
        echo View('dre/sintetico', $arrayData);
        echo View('templates/footer');
    }
    public function analitico()
    {
        try {
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

        $receita['receita'] = $this->dbReceita->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $contaDre['contaDre'] = $this->dbContaDre->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $contaFluxo['contaFluxo'] = $this->dbContaFluxo->where('id_usuario', $this->session->get('id_usuario'))->findAll();

        $sqlDespesa = "SELECT
                        f.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                        FROM contafluxo f
                        LEFT JOIN despesaformabaixa a ON a.id_conta_fluxo = f.id_conta_fluxo
                                                AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        WHERE f.id_usuario = '$id_usuario'
                            AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                        GROUP BY f.nome; ";
        $valoresDespesa['valoresDespesa'] =  $this->dbDespesaLancamento->query($sqlDespesa)->getResultArray();

        $sqlReceita = "SELECT
                        r.nome,
                        COALESCE(SUM(a.valor), '00.00') as total
                       FROM  receita r
                       LEFT JOIN receitaformabaixa a ON a.id_receita = r.id_receita
                                            AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                    WHERE r.id_usuario = '$id_usuario'
                        AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                    GROUP BY  r.nome;";

        $valoresReceita['valoresReceita'] =  $this->dbReceitaLancamento->query($sqlReceita)->getResultArray();

        $arrayData = array_merge($receita, $contaDre, $valoresReceita, $valoresDespesa, $contaFluxo, $data);
        echo View('templates/header');
        echo View('dre/analitico', $arrayData);
        echo View('templates/footer');
        } catch (\Throwable $th) {
           print_r($th); exit;
        }
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
