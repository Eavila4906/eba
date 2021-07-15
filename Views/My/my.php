<?php
  header_view($data);
  //getModal('notificacion_modal', $data);
?> 
<main class="app-content">
  <div class="app-title">
    
    <div>
      <h1><i class="
      <?php 
        if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
          echo "fas fa-user-graduate";
        } else if ($_SESSION['dataUser']['nombreRol'] == "Super Administrador" || $_SESSION['dataUser']['nombreRol'] == "Docente Administrador" || $_SESSION['dataUser']['nombreRol'] == "Administrador") {
          echo "fas fa-user-tie";
        } else {
          echo "fas fa-chalkboard-teacher";
        }
      ?> 
      "></i> <?= $data['name_page']; ?> - <?= $_SESSION['dataUser']['nombres']." ".$_SESSION['dataUser']['apellidoP']." ".$_SESSION['dataUser']['apellidoM']?></h1>
      <p><?= NAME_PROJECT?></p>
    </div>

    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= BASE_URL(); ?>my">Area personal</a></li>
    </ul>

  </div>
</main>
<?php
  footer_view($data);
?>