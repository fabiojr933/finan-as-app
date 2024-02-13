<?php

namespace App\Controllers;

use App\Models\DespesaFormaBaixaModel;
use App\Models\ReceitaFormaBaixaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use DateTime;

class Relatorio extends Controller
{
    private $session;
    private $dbUsuario;
    private $dbReceitaLancamento;
    private $dbDespesaLancamento;

    function __construct()
    {
        $this->session = session();
        $this->dbUsuario = new UsuarioModel();
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
                       LEFT JOIN receitaformabaixa a ON a.id_receita = r.id_receita
                                            AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                    WHERE r.id_usuario = '$id_usuario'
                        AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                    GROUP BY r.id_receita, r.nome;";

        $valoresReceita['valoresReceita'] =  $this->dbReceitaLancamento->query($sqlReceita)->getResultArray();

        $arrayData = array_merge($valoresReceita, $data);
        echo View('templates/header');
        echo View('relatorio/receita', $arrayData);
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
                        LEFT JOIN despesaformabaixa a ON a.id_conta_fluxo = f.id_conta_fluxo
                                                AND a.data_pagamento BETWEEN '$data_inicio' and '$data_final'
                        WHERE f.id_usuario = '$id_usuario'
                            AND (a.data_pagamento IS NULL OR a.data_pagamento BETWEEN '$data_inicio' and '$data_final')
                        GROUP BY f.id_conta_fluxo, f.nome; ";
        $valoresDespesa['valoresDespesa'] =  $this->dbDespesaLancamento->query($sqlDespesa)->getResultArray();

        $arrayData = array_merge($valoresDespesa, $data);
        echo View('templates/header');
        echo View('relatorio/despesa', $arrayData);
        echo View('templates/footer');
    }



    function obterDatasMes($ano, $mes)
    {
        $dataInicial = new DateTime("$ano-$mes-01");
        $ultimoDia = $dataInicial->format('t');
        $dataFinal = new DateTime("$ano-$mes-$ultimoDia");
        return [
            'inicial' => $dataInicial->format('Y-m-d'),
            'final' => $dataFinal->format('Y-m-d'),
        ];
    }
}
