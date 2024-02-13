<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'Inicio::index');
$routes->get('/inicio', 'Inicio::index');


//Usuario
$routes->get('/login', 'Usuario::index');
$routes->get('/registrar', 'Usuario::registrar');
$routes->post('/usuario/autenticar', 'Usuario::autenticar');
$routes->post('/usuario/salvar', 'Usuario::salvar');
$routes->post('/usuario/mudarSenha', 'Usuario::mudarSenha');
$routes->get('/usuario/sair', 'Usuario::sair');
$routes->post('/usuario/mudarSenha', 'Usuario::mudarSenha');
$routes->get('/usuario/trocarSenha', 'Usuario::trocaSenha');


//Pagamento
$routes->get('/pagamento', 'Pagamento::index');
$routes->get('/pagamento/novo', 'Pagamento::novo');
$routes->get('/pagamento/editar/(:num)', 'Pagamento::editar/$1');
$routes->post('/pagamento/atualizar', 'Pagamento::atualizar');
$routes->post('/pagamento/salvar', 'Pagamento::salvar');
$routes->post('/pagamento/excluir', 'Pagamento::excluir');
$routes->get('/pagamento/visualizar/(:num)', 'Pagamento::visualizar/$1');

//Cliente
$routes->get('/cliente', 'Cliente::index');
$routes->get('/cliente/novo', 'Cliente::novo');
$routes->get('/cliente/editar/(:num)', 'Cliente::editar/$1');
$routes->post('/cliente/atualizar', 'Cliente::atualizar');
$routes->post('/cliente/salvar', 'Cliente::salvar');
$routes->post('/cliente/excluir', 'Cliente::excluir');
$routes->get('/cliente/visualizar/(:num)', 'Cliente::visualizar/$1');


//fornecedor
$routes->get('/fornecedor', 'Fornecedor::index');
$routes->get('/fornecedor/novo', 'Fornecedor::novo');
$routes->get('/fornecedor/editar/(:num)', 'Fornecedor::editar/$1');
$routes->post('/fornecedor/atualizar', 'Fornecedor::atualizar');
$routes->post('/fornecedor/salvar', 'Fornecedor::salvar');
$routes->post('/fornecedor/excluir', 'Fornecedor::excluir');
$routes->get('/fornecedor/visualizar/(:num)', 'Fornecedor::visualizar/$1');

//receita
$routes->get('/receita', 'Receita::index');
$routes->get('/receita/novo', 'Receita::novo');
$routes->get('/receita/editar/(:num)', 'Receita::editar/$1');
$routes->post('/receita/atualizar', 'Receita::atualizar');
$routes->post('/receita/salvar', 'Receita::salvar');
$routes->post('/receita/excluir', 'Receita::excluir');
$routes->get('/receita/visualizar/(:num)', 'Receita::visualizar/$1');

//contaDre
$routes->get('/contaDre', 'ContaDre::index');
$routes->get('/contaDre/novo', 'ContaDre::novo');
$routes->get('/contaDre/editar/(:num)', 'ContaDre::editar/$1');
$routes->post('/contaDre/atualizar', 'ContaDre::atualizar');
$routes->post('/contaDre/salvar', 'ContaDre::salvar');
$routes->post('/contaDre/excluir', 'ContaDre::excluir');
$routes->get('/contaDre/visualizar/(:num)', 'ContaDre::visualizar/$1');

//contaFluxo
$routes->get('/contaFluxo', 'ContaFluxo::index');
$routes->get('/contaFluxo/novo', 'ContaFluxo::novo');
$routes->get('/contaFluxo/editar/(:num)', 'ContaFluxo::editar/$1');
$routes->post('/contaFluxo/atualizar', 'ContaFluxo::atualizar');
$routes->post('/contaFluxo/salvar', 'ContaFluxo::salvar');
$routes->post('/contaFluxo/excluir', 'ContaFluxo::excluir');
$routes->get('/contaFluxo/visualizar/(:num)', 'ContaFluxo::visualizar/$1');


//lancamento
$routes->get('/lancamento', 'Lancamento::index');
$routes->get('/lancamento/novo', 'Lancamento::novo');
$routes->post('/lancamento/salvar', 'Lancamento::salvar');
$routes->post('/lancamento/excluir', 'Lancamento::excluir');

//contas receber
$routes->get('/contasReceber', 'ContasReceber::index');
$routes->get('/contasReceber/novo', 'ContasReceber::novo');
$routes->post('/contasReceber/salvar', 'ContasReceber::salvar');
$routes->get('/contasReceber/visualizar/(:num)', 'ContasReceber::visualizar/$1');
$routes->post('/contasReceber/pagamento', 'ContasReceber::pagamento');
$routes->get('/contasReceber/recebimento', 'ContasReceber::recebimento');
$routes->get('/contasReceber/excluir', 'ContasReceber::excluir');
$routes->post('/contasReceber/cancelamento', 'ContasReceber::cancelamento');

//contas a pagar
$routes->get('/contasPagar', 'ContasPagar::index');
$routes->get('/contasPagar/novo', 'ContasPagar::novo');
$routes->post('/contasPagar/salvar', 'ContasPagar::salvar');
$routes->get('/contasPagar/visualizar/(:num)', 'ContasPagar::visualizar/$1');
$routes->post('/contasPagar/pagamento', 'ContasPagar::pagamento');
$routes->get('/contasPagar/recebimento', 'ContasPagar::recebimento');
$routes->get('/contasPagar/excluir', 'ContasPagar::excluir');
$routes->post('/contasPagar/cancelamento', 'ContasPagar::cancelamento');

//dre
$routes->get('/dre/sintetico', 'Dre::sintetico');
$routes->get('/dre/analitico', 'Dre::analitico');



//Relatorios
$routes->get('/relatorio/receita', 'Relatorio::receita');
$routes->get('/relatorio/despesa', 'Relatorio::despesa');


//Relatorios
$routes->get('/grafico/receita', 'Grafico::receita');
$routes->get('/grafico/despesa', 'Grafico::despesa');
$routes->get('/grafico/pagamento', 'Grafico::pagamento');

//backup 
$routes->get('/backup', 'Backup::index');
$routes->get('/backup/sistema', 'Backup::backup');