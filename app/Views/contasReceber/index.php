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
                    <h1 class="m-0">Contas a receber</h1>
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
                            <a class="btn btn-primary" href="/contasReceber/novo"> <i class="nav-icon fas fa-plus"></i></a>
                        </div><br>

                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="card card-primary card-tabs">
                                    <div class="card-header p-0 pt-1">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Abertas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Pagas</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                <div class="row">
                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0">
                                                        <table id="tabelaDados" class="table table-hover text-nowrap table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Cliente</th>
                                                                    <th>Vencimento</th>
                                                                    <th>Valor</th>
                                                                    <th>Status</th>

                                                                    <th class="no-print" style="width: 130px">Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($contasReceber)) : ?>
                                                                    <?php foreach ($contasReceber as $data) : ?>
                                                                        <tr>
                                                                            <td><?php echo $data['nome'] ?></td>
                                                                            <td><?php echo date('d/m/Y', strtotime($data['vencimento'])); ?></td>
                                                                            <td>R$: <?php echo number_format($data['valor'], 2, ',', '.'); ?></td>
                                                                            <td>
                                                                                <?php echo (strtotime($data['vencimento']) <= strtotime(date('Y-m-d'))) ? '<span class="badge bg-danger">Vencido</span>' : '<span class="badge bg-primary">Pendente</span>'; ?>
                                                                            </td>
                                                                            <td>
                                                                                <a href="/contasReceber/visualizar/<?php echo $data['id_contas_receber'] ?>" class="btn btn-primary btn-xs"><i class="fas fa-search"></i></a>
                                                                                <!-- <button type="button" onclick="confirmaExclusao('<php echo $data['id_receita'] ?>')" class="btn btn-danger btn-xs">Excluir</button> -->
                                                                                <button type="button" onclick="document.getElementById('id_contas_receber').value = '<?php echo  $data['id_contas_receber'] ?>'" data-toggle="modal" data-target="#modal-default" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                                                                <a type="button" onclick="setcontasReceberValues('<?php echo $data['id_contas_receber']; ?>', '<?php echo $data['valor']; ?>')" data-toggle="modal" data-target="#modal-default_receber" class=""><span class="badge bg-success">Receber</span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="5">Nenhuma conta a receber cadastrada</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                <div class="row">
                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0">
                                                        <table id="tabelaDados2" class="table table-hover text-nowrap table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Cliente</th>
                                                                    <th>Vencimento</th>
                                                                    <th>Valor</th>
                                                                    <th>Status</th>
                                                                    <th class="no-print" style="width: 130px">Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($contasReceberPagos)) : ?>
                                                                    <?php foreach ($contasReceberPagos as $data) : ?>
                                                                        <tr>
                                                                            <td><?php echo $data['nome'] ?></td>
                                                                            <td><?php echo date('d/m/Y', strtotime($data['vencimento'])); ?></td>
                                                                            <td>R$: <?php echo number_format($data['valor'], 2, ',', '.'); ?></td>
                                                                            <td><?php echo $data['vencimento']  ?></td>
                                                                            <td>
                                                                                <button type="button" onclick="document.getElementById('id_contas_receber2').value = '<?php echo  $data['id_contas_receber'] ?>'" data-toggle="modal" data-target="#modal-default2" class="btn btn-danger btn-xs"><i class="fa fa-undo"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="5">Nenhuma conta a receber baixada</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
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
            <form action="/contasReceber/excluir" method="get">
                <div class="modal-header">
                    <h4 class="modal-title">Deseja realmente excluir ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_contas_receber" name="id_contas_receber" value="" />
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-primary">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/contasReceber/cancelamento" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Deseja realmente cancelar essa BAIXA ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_contas_receber2" name="id_contas_receber2" value="" />
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-primary">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade" id="modal-default_receber">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/contasReceber/pagamento" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Deseja Receber esse documento ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_contas_receber_recebimento" name="id_contas_receber_recebimento" value="" />
                    <input type="hidden" id="valor_contas_receber" name="valor_contas_receber" value="" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>É uma Despesa ou uma Receita?</label>
                            <select class="form-control select2bs4" name="ip_tipo" id="ip_tipo" style="width: 100%;" onchange="alteraTipo()">
                                <option selected value="receita">Receita</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="id_receita">
                        <div class="form-group">
                            <label>Escolha a Receita</label>
                            <select class="form-control select2bs4" name="id_receita" id="id_receita" style="width: 100%;">

                                <?php foreach ($receita as $re) {  ?>
                                    <option value="<?php echo $re['id_receita'] ?>"><?php echo $re['nome'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tipo pagamento</label>
                            <select class="form-control select2bs4" name="id_pagamento" id="id_pagamento" style="width: 100%;">
                                <?php foreach ($pagamento as $data) { ?>
                                    <option value="<?php echo $data['id_pagamento'] ?>"><?php echo $data['nome'] ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary">RECEBER</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setcontasReceberValues(idcontasReceber, valorcontasReceber) {

        

        document.getElementById('id_contas_receber_recebimento').value = idcontasReceber;
       
        document.getElementById('valor_contas_receber').value = parseFloat(valorcontasReceber).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');;
    }
</script>

<script>
    $(document).ready(function() {
        // Aplica a máscara ao campo de saldo
        $('#valor input[name="valor_contas_receber"]').inputmask('currency', {
            radixPoint: ',',
            groupSeparator: '.',
            allowMinus: false, // Descomente esta linha se quiser permitir números negativos
            prefix: '',
            autoUnmask: true
        });
    });
</script>