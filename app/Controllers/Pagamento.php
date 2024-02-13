<?php

namespace App\Controllers;

use App\Models\PagamentoModel;

class Pagamento extends BaseController
{
    private $session;
    private $dbPagamento;

    function __construct()
    {
        $this->session = session();
        $this->dbPagamento = new PagamentoModel();
    }

    public function index()
    {
        $dados['pagamento'] = $this->dbPagamento->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('pagamento/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        echo View('templates/header');
        echo View('pagamento/formulario');
        echo View('templates/footer');
    }

    public function salvar()
    {
        $request = request();
        $dados = [
            'nome'          => $request->getPost('nome'),
            'id_usuario'    => $this->session->get('id_usuario'),
        ];
        //insert  

        $this->dbPagamento->insert($dados);
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Pagamento cadastrada com sucesso!'
            ]
        );

        return redirect()->to('pagamento');
    }

    public function atualizar()
    {
        $request = request();
        $id_pagamento = $request->getPost('id_pagamento');
        $dados = [
            'nome'          => $request->getPost('nome'),
            'id_usuario'    => $this->session->get('id_usuario'),
        ];

        //Update

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Condição de pagamento alterada com sucesso!'
            ]
        );
        $this->dbPagamento->where(['id_pagamento' => $id_pagamento, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();

        return redirect()->to('pagamento');
    }

    public function visualizar($id)
    {
        $data['pagamento'] = $this->dbPagamento->where(['id_pagamento' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('pagamento/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['pagamento'] = $this->dbPagamento->where(['id_pagamento' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('pagamento/editar', $data);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbPagamento->where(['id_pagamento' => $request->getPost('id_pagamento'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Pagamento excluído com sucesso!'
            ]
        );
        return redirect()->to('/pagamento');
    }
}
