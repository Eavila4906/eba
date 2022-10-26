<?php
  header_view($data);
?>

<div id="ContentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fas fa-book"></i> <?= $data['name_page']; ?></h1>
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
      <button class="btn btn-success mb-3" type="button" onclick="openModalCourse();"><i class="fa fa-plus-circle fa-lg"></i> Nuevo Curso</button><br>
    </div>
    <?php } ?>



</main>

<?php
  footer_view($data);
?>