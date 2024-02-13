<?php

namespace App\Controllers;

use App\Models\DreModel;
use App\Models\contaDreModel;

class ContaDre extends BaseController
{
    private $session;
    private $dbContaDre;

    function __construct()
    {
        $this->session = session();
        $this->dbContaDre = new DreModel();
    }

    public function index()
    {
        $dados['contaDre'] = $this->dbContaDre->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('contaDre/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        echo View('templates/header');
        echo View('contaDre/formulario');
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

        $this->dbContaDre->insert($dados);
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'contaDre cadastrada com sucesso!'
            ]
        );

        return redirect()->to('contaDre');
    }

    public function atualizar()
    {
        $request = request();
        $id_conta_dre = $request->getPost('id_conta_dre');
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
                'titulo' => 'Condição de contaDre alterada com sucesso!'
            ]
        );
        $this->dbContaDre->where(['id_conta_dre' => $id_conta_dre, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();

        return redirect()->to('contaDre');
    }

    public function visualizar($id)
    {
        $data['contaDre'] = $this->dbContaDre->where(['id_conta_dre' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('contaDre/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['contaDre'] = $this->dbContaDre->where(['id_conta_dre' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('contaDre/editar', $data);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbContaDre->where(['id_conta_dre' => $request->getPost('id_conta_dre'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'contaDre excluído com sucesso!'
            ]
        );
        return redirect()->to('/contaDre');
    }
}
