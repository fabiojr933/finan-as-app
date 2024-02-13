<?php

namespace App\Controllers;

use App\Models\FornecedorModel;

class Fornecedor extends BaseController
{
    private $session;
    private $dbFornecedor;

    function __construct()
    {
        $this->session = session();
        $this->dbFornecedor = new FornecedorModel();
    }

    public function index()
    {
        $dados['fornecedor'] = $this->dbFornecedor->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('fornecedor/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        echo View('templates/header');
        echo View('fornecedor/formulario');
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

        $this->dbFornecedor->insert($dados);
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'fornecedor cadastrada com sucesso!'
            ]
        );

        return redirect()->to('fornecedor');
    }

    public function atualizar()
    {
        $request = request();
        $id_fornecedor = $request->getPost('id_fornecedor');
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
                'titulo' => 'Condição de fornecedor alterada com sucesso!'
            ]
        );
        $this->dbFornecedor->where(['id_fornecedor' => $id_fornecedor, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();

        return redirect()->to('fornecedor');
    }

    public function visualizar($id)
    {
        $data['fornecedor'] = $this->dbFornecedor->where(['id_fornecedor' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('fornecedor/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['fornecedor'] = $this->dbFornecedor->where(['id_fornecedor' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('fornecedor/editar', $data);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbFornecedor->where(['id_fornecedor' => $request->getPost('id_fornecedor'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'fornecedor excluído com sucesso!'
            ]
        );
        return redirect()->to('/fornecedor');
    }
}
