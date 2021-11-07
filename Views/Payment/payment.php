<?php 
  header_view($data);
  getModal('seePayments_modal', $data);
  /*getModal('expenses_modal', $data); funcionalidad para actualizacion */
?>    
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fas fa-clipboard"></i> Reportes</h1>
        <p><?=NAME_PROJECT;?></p>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active"><a href="<?=BASE_URL();?>payment">Reportes</a></li>
    </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary"><i class="fas fa-receipt"></i> Reporte de pagos</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableP">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cedula</th>
                        <th>Estudiante</th>
                        <th>Acción</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary"><i class="fas fa-coins"></i> Reporte financiero</h3> 
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableFinancialReport"
                  class="display" cellspacing="0" cellpadding="8" width="100%">
                  <!--<button class="btn btn-success mb-3" type="button" onclick="openModalPaymentDay()"><i class="fa fa-calendar fa-lg"></i> Registrar Egreso</button> funcionalidad para actualizacion -->
                  <thead>
                    <tr>
                      <th>Ingresos</th>
                      <th>Egresos</th>
                      <th>Saldo neto</th>
                      <!-- <th>Acción</th> funcionalidad para actualizacion -->
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
</main>
<?php 
  footer_view($data);
?>