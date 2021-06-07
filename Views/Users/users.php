<?php
  header_view($data);
  getModal('users_modal', $data);
  getModal('infoUsers_modal', $data);
?>

<main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> <?= $data['page_name']; ?></h1>
          <p><?= NAME_PROJECT ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active"><a href="users"><?= $data['page_name']; ?></a></li>
        </ul>
    </div>

    <div>
        <button class="btn btn-success mb-3" type="button" onclick="openModal();"><i class="fa fa-user-plus fa-lg"></i> Nuevo usuario</button><br>
    </div>
    
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableUsuarios">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>N. Cedula</th>
                        <th>Nombres</th>
                        <th>Username</th>
                        <th>Rol</th>
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