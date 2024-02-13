<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use CodeIgniter\Controller;

class Cliente extends Controller
{
    private $session;
    private $dbCliente;



    function __construct()
    {
        $this->session = session();
        $this->dbCliente = new ClienteModel();
    }

    public function index()
    {
        $dados['cliente'] = $this->dbCliente->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('cliente/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        echo View('templates/header');
        echo View('cliente/formulario');
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

        $this->dbCliente->insert($dados);
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'cliente cadastrada com sucesso!'
            ]
        );

        return redirect()->to('cliente');
    }

    public function atualizar()
    {
        $request = request();
        $id_cliente = $request->getPost('id_cliente');
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
                'titulo' => 'Condição de cliente alterada com sucesso!'
            ]
        );
        $this->dbCliente->where(['id_cliente' => $id_cliente, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();

        return redirect()->to('cliente');
    }

    public function visualizar($id)
    {
        $data['cliente'] = $this->dbCliente->where(['id_cliente' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('cliente/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['cliente'] = $this->dbCliente->where(['id_cliente' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        echo View('templates/header');
        echo View('cliente/editar', $data);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();
        $this->dbCliente->where(['id_cliente' => $request->getPost('id_cliente'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'cliente excluído com sucesso!'
            ]
        );
        return redirect()->to('/cliente');
    }
}
