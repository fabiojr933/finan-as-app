<?php

namespace App\Controllers;

use App\Models\ReceitaModel;

class Receita extends BaseController
{
    private $session;
    private $dbReceita;

    function __construct()
    {
        $this->session = session();
        $this->dbReceita = new ReceitaModel();
    }

    public function index()
    {
        $dados['receita'] = $this->dbReceita->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('receita/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        echo View('templates/header');
        echo View('receita/formulario');
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

        $this->dbReceita->insert($dados);
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'receita cadastrada com sucesso!'
            ]
        );

        return redirect()->to('receita');
    }

    public function atualizar()
    {
        $request = request();
        $id_receita = $request->getPost('id_receita');
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
                'titulo' => 'Condição de receita alterada com sucesso!'
            ]
        );
        $this->dbReceita->where(['id_receita' => $id_receita, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();

        return redirect()->to('receita');
    }

    public function visualizar($id)
    {
        $data['receita'] = $this->dbReceita->where(['id_receita' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('receita/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['receita'] = $this->dbReceita->where(['id_receita' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('receita/editar', $data);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbReceita->where(['id_receita' => $request->getPost('id_receita'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'receita excluído com sucesso!'
            ]
        );
        return redirect()->to('/receita');
    }
}
