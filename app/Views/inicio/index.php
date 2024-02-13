<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h5 class="mb-2">Bem vindo </h5>
      <div class="container-fluid">
        <div class="card no-print">
          <div class="card-body">
            <form action="/inicio" method="get">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Data Inicio</label>
                    <input type="date" class="form-control" name="data_inicio" value="<?php echo $data['data_inicio'] ?>">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="">Data Final</label>
                    <input type="date" class="form-control" name="data_final" value="<?php echo $data['data_final'] ?>">
                  </div>
                </div>
                <div class="col-lg-4">
                  <button type="submit" class="btn btn-info" style="margin-top: 30px">Gerar Relatório</button>
                </div>
              </div>
            </form>
          </div>
          <?php
          $data_inicio_ptbr = date('d/m/Y', strtotime($data['data_inicio']));
          $data_final_ptbr = date('d/m/Y', strtotime($data['data_final']));
          ?>
          <h6 style="text-align: center;" class="mb-2">Dados baseado entre a data <?php echo $data_inicio_ptbr ?> até <?php echo $data_final_ptbr ?></h6>
          <div class="row">

            <div class="col-lg-2 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$: <?php echo number_format($contas_a_receber, 2, ',', '.') ?></h3>
                  <p>Contas a receber</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$; <?php echo number_format($contas_a_pagar, 2, ',', '.') ?></h3>
                  <p>Contas a pagar</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$: <?php echo number_format($total_receita, 2, ',', '.') ?></h3>
                  <p>Total de receita</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-olive">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$: <?php echo number_format($total_despesa, 2, ',', '.') ?></h3>
                  <p>Total de despesas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$: <?php echo number_format($contas_recebido, 2, ',', '.') ?></h3>
                  <p>Total Recebido</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3 style="font-size: 30px;">R$: <?php echo number_format($contas_pago, 2, ',', '.') ?></h3>
                  <p>Contas Paga</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>







            <div class="col-lg-12">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Total de despesas lançado por dia</h3>
                    <a href="javascript:void(0);">View Report</a>
                  </div>
                </div>
                <div class="card-body">                 

                  <div class="position-relative mb-4">
                    <canvas id="visitors-chart1" height="200"></canvas>
                  </div>
                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Valores
                    </span>
                    <span>
                      <i class="fas fa-square text-gray"></i> Dias
                    </span>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Contas a receber</h3>
                    <a href="javascript:void(0);">Graficos</a>
                  </div>
                </div>
                <div class="card-body">

                  <div class="position-relative mb-4">
                    <div id="graficoReceberDespesaPieChart" style="width: 100%; height: 270px"></div>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Ultimos lançamentos</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Fluxo financeiro</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($dadosReceitaLancamento as $data) { ?>
                        <tr>
                          <td>
                            <?php echo $data['nome'] ?>
                          </td>
                          <td> R$: <?php echo $data['valor'] ?></td>
                          <td>
                            <small class="text-primary mr-1">
                              <i class="fas fa-arrow-up"></i>
                              Receita
                            </small>
                          </td>
                          <td>
                            <a href="#" class="text-muted">
                              <?php echo date('d/m/Y', strtotime($data['data_pagamento'])); ?>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>

                      <?php foreach ($dadosDespesaLancamento as $data) { ?>
                        <tr>
                          <td>
                            <?php echo $data['nome'] ?>
                          </td>
                          <td> R$: <?php echo $data['valor'] ?></td>
                          <td>
                            <small class="text-danger mr-1">
                              <i class="fas fa-arrow-down"></i>
                              Receita
                            </small>
                          </td>
                          <td>
                            <a href="#" class="text-muted">
                              <?php echo date('d/m/Y', strtotime($data['data_pagamento'])); ?>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>


                    </tbody>
                  </table>
                </div>
              </div>

            </div>




            <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Contas a pagar</h3>
                    <a href="javascript:void(0);">Grafico</a>
                  </div>
                </div>
                <div class="card-body">

                  <div class="position-relative mb-4">
                    <div id="graficoPagarDespesaPieChart" style="width: 100%; height: 270px"></div>
                  </div>
                </div>
              </div>




              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Contas a receber e pagar mais proximos</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Vencimento</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($dadosReceber as $data) { ?>
                        <tr>
                          <td>
                            <?php echo $data['nome'] ?>
                          </td>
                          <td> R$: <?php echo $data['valor'] ?></td>
                          <td>
                            <small class="text-primary mr-1">
                              <i class="fas fa-arrow-up"></i>
                              Contas a receber
                            </small>
                          </td>
                          <td>
                            <a href="#" class="text-muted">
                              <?php echo date('d/m/Y', strtotime($data['vencimento'])); ?>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>

                      <?php foreach ($dadosContasPagar as $data) { ?>
                        <tr>
                          <td>
                            <?php echo $data['nome'] ?>
                          </td>
                          <td> R$: <?php echo $data['valor'] ?></td>
                          <td>
                            <small class="text-danger mr-1">
                              <i class="fas fa-arrow-down"></i>
                              Contas a pagar
                            </small>
                          </td>
                          <td>
                            <a href="#" class="text-muted">
                              <?php echo date('d/m/Y', strtotime($data['vencimento'])); ?>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php

  $graficoPagarDespesa = [['Status', 'Valor']];
  foreach ($graficoPagarPago as $value) {
    $graficoPagarDespesa[] = [$value['status'], floatval($value['total_pago'])];
  }
  $dados_json = json_encode($graficoPagarDespesa);
  ?>

  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var dados_do_backend = <?php echo $dados_json; ?>;
      var data = google.visualization.arrayToDataTable(dados_do_backend);
      var options = {
        title: ''
      };
      var chart = new google.visualization.PieChart(document.getElementById('graficoPagarDespesaPieChart'));
      chart.draw(data, options);
    }
  </script>





  <?php

  $graficoReceberDespesa = [['Status', 'Valor']];
  foreach ($graficoReceberPago as $value) {
    $graficoReceberDespesa[] = [$value['status'], floatval($value['total_receber'])];
  }
  $dados_json = json_encode($graficoReceberDespesa);
  ?>

  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var dados_do_backend = <?php echo $dados_json; ?>;
      var data = google.visualization.arrayToDataTable(dados_do_backend);
      var options = {
        title: ''
      };
      var chart = new google.visualization.PieChart(document.getElementById('graficoReceberDespesaPieChart'));
      chart.draw(data, options);
    }
  </script>



  <?php
  $datas = [];
  $valores = [];

  foreach ($graficodias as $row) {
    // Adiciona o valor da chave 'dia' ao array $datas
    $datas[] = $row['dia'];
    // Adiciona o valor da chave 'total' ao array $valores
    $valores[] = $row['total'];
  }

  // Resultado esperado:
  // $datas = ['2024-02-01', '2024-02-02', '2024-02-03']
  // $valores = ['10.00', '30.00', '40.00'] 

 // print_r(json_encode($datas)); exit
  ?>

  <script>
    $(function() {
      'use strict'

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var mode = 'index'
      var intersect = true

      var $visitorsChart = $('#visitors-chart1')
      // eslint-disable-next-line no-unused-vars
      var visitorsChart = new Chart($visitorsChart, {
        data: {
          labels: <?php echo json_encode($datas) ?>,
          datasets: [{
              type: 'line',
              data: <?php echo json_encode($valores) ?>,
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false
              // pointHoverBackgroundColor: '#007bff',
              // pointHoverBorderColor    : '#007bff'
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                suggestedMax: 200
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    })

    // lgtm [js/unused-local-variable]
  </script>