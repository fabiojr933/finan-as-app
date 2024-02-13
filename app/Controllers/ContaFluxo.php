<?php

namespace App\Controllers;

use App\Models\DreModel;
use App\Models\FluxoModel;

use App\Models\UsuarioModel;

class ContaFluxo extends BaseController
{
    private $session;
    private $dbUsuario;
    private $dbFluxo;
    private $dbcontaDre;

    function __construct()
    {
        $this->session = session();
        $this->dbUsuario = new UsuarioModel();
        $this->dbFluxo = new FluxoModel();
        $this->dbcontaDre = new DreModel();
    }

    public function index()
    {
        $dados['contaFluxo'] = $this->dbFluxo->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('contaFluxo/index', $dados);
        echo View('templates/footer');
    }

    public function novo()
    {
        $dados['contaDre'] = $this->dbcontaDre->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        echo View('templates/header');
        echo View('contaFluxo/formulario', $dados);
        echo View('templates/footer');
    }

    public function salvar()
    {
        $request = request();
        $id_conta_dre = $request->getPost('id_conta_dre');
        $dados = [
            'nome'          => $request->getPost('nome'),
            'id_usuario'    => $this->session->get('id_usuario'),
            'id_conta_dre'   => $id_conta_dre
        ];
        //insert  
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Conta Dre cadastrada com sucesso!'
            ]
        );
        $this->dbFluxo->insert($dados);

        return redirect()->to('contaFluxo');
    }


    public function atualizar()
    {
        $request = request();
        $id_contaFluxo = $request->getPost('id_conta_fluxo');
        $dados = [
            'nome'          => $request->getPost('nome'),
            'id_usuario'    => $this->session->get('id_usuario'),
            'id_conta_dre'   => $request->getPost('id_conta_dre'),
        ];

        //Update

        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Conta Dre alterada com sucesso!'
            ]
        );
        $this->dbFluxo->where(['id_conta_fluxo' => $id_contaFluxo, 'id_usuario' => $this->session->get('id_usuario')])->set($dados)->update();
        return redirect()->to('contaFluxo');
    }


    public function visualizar($id)
    {
        $data['contaFluxo'] = $this->dbFluxo->where(['contafluxo.id_usuario' => $this->session->get('id_usuario'), 'contafluxo.id_conta_fluxo' => $id])
            ->select('
    contafluxo.id_conta_fluxo,
    contafluxo.nome as nome,
    contadre.id_conta_dre,
    contadre.nome as nomedre
')
            ->join('contadre', 'contafluxo.id_conta_dre = contadre.id_conta_dre')
            ->findAll();
        echo View('templates/header');
        echo View('contaFluxo/visualizar', $data);
        echo View('templates/footer');
    }

    public function editar($id)
    {
        $data['contaFluxo'] = $this->dbFluxo->where(['id_conta_fluxo' => $id, 'id_usuario' => $this->session->get('id_usuario')])->first();
        $data2['contaDre'] = $this->dbcontaDre->where('id_usuario', $this->session->get('id_usuario'))->findAll();
        $mergedData = array_merge($data, $data2);
        echo View('templates/header');
        echo View('contaFluxo/editar', $mergedData);
        echo View('templates/footer');
    }

    public function excluir()
    {
        $request = request();

        $this->dbFluxo->where(['id_conta_fluxo' => $request->getPost('id_conta_fluxo'), 'id_usuario' => $this->session->get('id_usuario')])->delete();
        $this->session->setFlashdata(
            'alert',
            [
                'tipo'  => 'sucesso',
                'cor'   => 'primary',
                'titulo' => 'Conta do Fluxo excluída com sucesso!'
            ]
        );
        return redirect()->to('/contaFluxo');
    }
}
