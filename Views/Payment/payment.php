<?php 
  header_view($data);
  getModal('seePayments_modal', $data);
?>    
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fas fa-clipboard"></i> Pagos</h1>
        <p><?=NAME_PROJECT;?></p>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active"><a href="<?=BASE_URL();?>payment">Pagos</a></li>
    </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary">Pagos registrados</h3>
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
    </div>
</main>
<?php 
  footer_view($data);
?>