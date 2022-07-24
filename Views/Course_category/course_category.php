<?php
  header_view($data);
  getModal('course_category_modal', $data);
?>

<div id="ContentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-tags"></i> <?= $data['name_page']; ?></h1>
          <p><?= NAME_PROJECT ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active"><a href="course_category"><?= $data['name_page'] ?></a></li>
        </ul>
    </div>

    <?php if ($_SESSION['permisosModulo']['w']) { ?>
    <div>
      <button class="btn btn-success mb-3" type="button" onclick="openModalCategory();"><i class="fa fa-plus-circle fa-lg"></i> Nueva Categoria</button><br>
    </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="DataTableCategory">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Categoria</th>
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