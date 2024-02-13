<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visualizar conta do fluxo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-primary btn-group" style="margin-right: 15px;" href="/contaFluxo"><i class="fas fa-share"></i></a>
                        <li class="breadcrumb-item"><a href="/inicio">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/contaFluxo">contaFluxo</a></li>
                        <li class="breadcrumb-item active">visualizar</li>
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
                            <h3 class="card-title">registro abaixo</h3>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body">                               
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" disabled name="nome" value="<?php echo $contaFluxo[0]['nome']; ?>" name="nome" placeholder="Digite a nome da conta do fluxo" required>
                                </div>                               
                            </div>
                            
                            <div class="card-body">                               
                                <div class="form-group">
                                    <label>Dre</label>
                                    <input type="text" class="form-control" disabled name="nome" value="<?php echo $contaFluxo[0]['nomedre']; ?>" name="nome" placeholder="Digite a nome da conta do fluxo" required>
                                </div>                               
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->