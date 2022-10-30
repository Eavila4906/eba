<?php
  header_view($data);
?>

<div id="ContentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fas fa-shield-alt"></i> <?= $data['name_page']; ?></h1>
          <p><?= NAME_PROJECT ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active"><a href="backup"><?= $data['name_page'] ?></a></li>
        </ul>
    </div>

    <?php if ($_SESSION['permisosModulo']['w']) { ?>
    <div>
      <button class="btn btn-success mb-3" type="button" onclick="FctBackup();"><i class="fa fa-download fa-lg"></i> New Backup</button><br>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="text-primary">Historial de respaldos</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableBackup">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Creado por</th>
                        <th>Rol del creador</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
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