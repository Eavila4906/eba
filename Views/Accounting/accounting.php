<?php 
  header_view($data);
  getModal('startsAccounting_modal', $data);
  getModal('totalPurchaseAccounting_modal', $data);
  getModal('stopAccounting_modal', $data);
  getModal('seeDetailsAccounting_modal', $data);
  getModal('seeIIA_modal', $data);
  getModal('seeDIIA_modal', $data);
?>    
<main class="app-content">
    <div class="app-title">
      <div>
          <h1><i class="fas fa-calculator"></i> Contabilidad</h1>
          <p><?=NAME_PROJECT;?></p>
      </div>
      <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active"><a href="<?=BASE_URL();?>accounting">Contabilidad</a></li>
      </ul>
    </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary">Iniciar contabilidad</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableIC">
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
            <h3 class="text-primary">Contabilidad activa</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableCA">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Cedula</th>
                      <th>Estudiante</th>
                      <th>Periodo</th>
                      <th>Ultimo pago</th>
                      <th>Proximo pago</th>
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
            <h3 class="text-primary">Contabilidad inactiva</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableCI">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Cedula</th>
                      <th>Estudiante</th>
                      <th>Periodos</th>
                      <th>Acción</th>
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