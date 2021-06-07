<?php
  header_view($data);
  getModal('roles_modal', $data);
?>

<div id="ContentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-tags"></i> <?= $data['page_name']; ?></h1>
          <p><?= NAME_PROJECT ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active"><a href="roles"><?= $data['page_name']; ?></a></li>
        </ul>
    </div>

    <div>
        <button class="btn btn-success mb-3" type="button" onclick="openModal();"><i class="fa fa-plus-circle fa-lg"></i> Nuevo rol</button><br>
    </div>
    
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableRoles">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Rol</th>
                        <th>Descripción</th>
                        <th>Estado</th>
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