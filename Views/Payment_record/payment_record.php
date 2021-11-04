<?php 
  header_view($data);
  getModal('payment_modal', $data);
  getModal('paymentDay_modal', $data);
?>    
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fas fa-cash-register"></i> Registrar pago</h1>
        <p><?=NAME_PROJECT;?></p>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active"><a href="<?=BASE_URL();?>payment_record">Registrar pago</a></li>
    </ul>
    </div>

    <?php if ($_SESSION['permisosModulo']['u']) { ?>
    <div>
      <button class="btn btn-success mb-3" type="button" onclick="openModalPaymentDay()"><i class="fa fa-calendar fa-lg"></i> Día de pago</button><br>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary">Registrar pago</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableRP">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cedula</th>
                        <th>Estudiante</th>
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
    </div>
</main>
<?php 
  footer_view($data);
?>