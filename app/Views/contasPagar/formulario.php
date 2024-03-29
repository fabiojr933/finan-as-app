<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cadastro de conta a receber</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-primary btn-group" style="margin-right: 15px;" href="/contasPagar"><i class="fas fa-share"></i></a>
                        <li class="breadcrumb-item"><a href="/inicio">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/contasPagar">contasPagar</a></li>
                        <li class="breadcrumb-item active">Novo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">



            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Digite os campos abaixo</h3>
                        </div>
                        <form action="/contasPagar/salvar" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status" style="width: 100%;" required>
                                                <option value="Pendente" selected>Pendente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Descrição</label>
                                            <input type="text" class="form-control" name="descricao" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Data de Venc.</label>
                                            <input type="date" class="form-control" name="vencimento" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group" id="valor">
                                            <label for="">Valor</label>
                                            <input type="text" class="form-control" id="valor" name="valor" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Fornecedor</label>
                                            <select class="form-control select2bs4" name="id_fornecedor" style="width: 100%;" required>
                                                <?php foreach ($fornecedor as $data) {  ?>
                                                    <option value="<?php echo $data['id_fornecedor'] ?>"><?php echo $data['nome']  ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Observações</label>
                                            <textarea class="form-control" rows="5" name="observacao"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top: 25px">
                                        <p><b>Obs:</b> Vai gerar um documento a pagar para o fornecedor selecionado!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Aplica a máscara ao campo de saldo
        $('#valor input[name="valor"]').inputmask('currency', {
            radixPoint: ',',
            groupSeparator: '.',
            allowMinus: false, // Descomente esta linha se quiser permitir números negativos
            prefix: '',
            autoUnmask: true
        });
    });
</script>