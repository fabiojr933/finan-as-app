<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <?php
            $session = session();
            $alert = $session->get('alert');
            ?>

            <?php if (isset($alert)) : ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-<?php echo $alert['cor'] ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $alert['titulo'] ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lista de condição de pagamento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-primary" href="/pagamento/novo"> <i class="nav-icon fas fa-plus"></i></a>
                        </div> <br>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table id="tabelaDados" class="table table-hover text-nowrap table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 35px">#</th>
                                        <th>Nome</th> 
                                        <th class="no-print" style="width: 130px">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pagamento)) : ?>
                                        <?php foreach ($pagamento as $data) : ?>
                                            <tr>
                                                <td><?php echo $data['id_pagamento'] ?></td>
                                                <td><?php echo $data['nome'] ?></td>                                                                                             
                                                <td>
                                                    <a href="/pagamento/visualizar/<?php echo $data['id_pagamento'] ?>" class="btn btn-primary btn-xs"><i class="fas fa-search"></i></a>
                                                    <a href="/pagamento/editar/<?php echo $data['id_pagamento'] ?>" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
                                                    <button type="button" onclick="document.getElementById('id_pagamento').value = '<?php echo  $data['id_pagamento'] ?>'" data-toggle="modal" data-target="#modal-default" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3">Nenhuma condição de pagamento cadastrada</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/pagamento/excluir" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Deseja realmente excluir ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_pagamento" name="id_pagamento" value="" />
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-primary">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--
<script>
    function confirmaExclusao(id_receita) {
        var conf = confirm('Deseja realmente excluir ?', 'Atenção');
        if (conf) {
            $.ajax({
                url: '',
                method: 'get',
                success: function(response) {
                    window.location.href = '';
                },
                error: function(error) {
                    // Lógica em caso de erro
                    console.error(error);
                }
            });
        }
    }
</script>  -->