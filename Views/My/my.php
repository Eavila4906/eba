<?php
  header_view($data);
  getModal('my_new_content_modal', $data);
  getModal('manage_students_course_modal', $data);
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


  <?php
    $MyContent =new My();
    $MyContent_teacher = $MyContent->getAllMyContentTeacher();
    $MyContent_student = $MyContent->getAllMyContentStudent();
  ?>

  <?php
    if ($_SESSION['dataUser']['nombreRol'] == "Docente") {
  ?>
      <h4 class="text-justify">Mis contenidos</h4>
  <?php
    } else if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
        for ($i=0; $i < count($MyContent_student); $i++) {
          if ($MyContent_student[$i]['status'] == 1) {
            if ($MyContent_student[$i]['proceso_contable'] == 1 || $MyContent_student[$i]['apc'] == true) {
  ?>
      <h4 class="text-justify">Mis contenidos</h4>
  <?php
            }
          }
        }
    }
  ?>

  <div class="album py-5 bg-light">
    <div class="container">
      <?php if ($_SESSION['permisosModulo']['w'] && $_SESSION['dataUser']['nombreRol'] == "Docente") { ?>
      <div>
        <button class="btn btn-success mb-3" type="button" onclick="OpenModalMyNewContent();"><i class="fa fa-plus fa-lg"></i> Nuevo contenido</button><br>
      </div>
      <?php } ?>
      <div id="MyContent">
        <div class="row">
          <?php
            if ($_SESSION['dataUser']['nombreRol'] == "Docente") {
              if (!empty($MyContent_teacher)) {
                for ($i=0; $i < count($MyContent_teacher); $i++) {
                  $myContent = "'".$MyContent_teacher[$i]['name_content']."'";
          ?>
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <a href="<?= $MyContent_teacher[$i]['link']?>" target="_blank" style="text-decoration: none; color: rgb(0, 0, 0);">
                <img class="bd-placeholder-img card-img-top" src="<?= MEDIA();?>images/courses.jpg" width="100%" height="225">
              </a>
              <div class="card-body">
                <a href="<?= $MyContent_teacher[$i]['link']?>" target="_blank" style="text-decoration: none; color: rgb(0, 0, 0);">
                  <h6 class="text-seccoundary"><?= $MyContent_teacher[$i]['name_content']?></h6>
                  <p class="card-text"><?= $MyContent_teacher[$i]['description']?></p>
                </a>
                <br>
                <div class="d-flex justify-content-between align-items-center">
                  <?php if ($_SESSION['permisosModulo']['u'] || $_SESSION['permisosModulo']['d']) { ?>
                  <div class="col-md-8">
                    <?php if ($_SESSION['permisosModulo']['w'] || $_SESSION['permisosModulo']['u']) { ?>
                    <button type="button" class="btn btn-sm btn-success" title="Administrar alumnos" onclick="OpenModalMsc(<?= $MyContent_teacher[$i]['id_my_content']?>, <?= $myContent?>);"><i class="fas fa-user-cog fa-lg"></i></button>
                    <?php } ?> 
                    <?php if ($_SESSION['permisosModulo']['u']) { ?>
                    <button type="button" class="btn btn-sm btn-info" title="Editar contenido" onclick="FctBtnEditarMyContent(<?= $MyContent_teacher[$i]['id_my_content']?>);"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) { ?>
                    <button type="button" class="btn btn-sm btn-danger" title="Eliminar contenido" onclick="FctBtnEliminarMNC(<?= $MyContent_teacher[$i]['id_my_content']?>);"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php 
                        if ($MyContent_teacher[$i]['status'] == 1) {
                    ?>
                          <small><i class="col-md-2 fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="col-md-2 fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                  <?php } ?>
                  <small class="text-muted">Por: <?= $MyContent_teacher[$i]['nombres']." ".$MyContent_teacher[$i]['apellidoP']." ".$MyContent_teacher[$i]['apellidoM']?></small>
                </div>
              </div>
            </div> 
          </div>
          <?php
                }
              } 
            } else if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
              for ($i=0; $i < count($MyContent_student); $i++) {
                if ($MyContent_student[$i]['status'] == 1) {
                  if ($MyContent_student[$i]['proceso_contable'] == 1 || $MyContent_student[$i]['apc'] == true) {
          ?>
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <a href="<?= $MyContent_student[$i]['link']?>" target="_blank" style="text-decoration: none; color: rgb(0, 0, 0);">
                <img class="bd-placeholder-img card-img-top" src="<?= MEDIA();?>images/courses.jpg" width="100%" height="225">
              </a>
              <div class="card-body">
                <a href="<?= $MyContent_student[$i]['link']?>" target="_blank" style="text-decoration: none; color: rgb(0, 0, 0);">
                  <h6 class="text-seccoundary"><?= $MyContent_student[$i]['name_content']?></h6>
                  <p class="card-text"><?= $MyContent_student[$i]['description']?></p>
                </a>
                <br>
                <div class="d-flex justify-content-between align-items-center">
                  <?php
                    for ($j=0; $j < count($MyContent_student[$i]['teacher']); $j++) {
                  ?>
                  <small class="text-muted">Por: <?= $MyContent_student[$i]['teacher'][$j]['teacher']?></small>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div> 
          </div>
          <?php
                  }
                }
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <?php
  if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
  ?>
  <br>
  <h4>Conoce nuestros metodos de pago</h4>
  <br>
  <div class="row">
    <div class="col-md-5">
      <img src="<?= MEDIA();?>images/metodos-pago.jpg" width="400px" height="300px">
    </div>
    
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fas fa-landmark fa-3x"></i>
        <div class="info">
          <h4>B. Pichincha</h4>
          <b>
            <p>2100232502</p>
          </b>
          <a href="https://inicio.pichincha.com/portal/inicio" class="small-box-footer" target="_blank">Ir</a>
        </div>
      </div>

      <div class="widget-small green coloured-icon"><i class="icon fab fa-whatsapp fa-3x"></i>
        <div class="info">
          <h4>WhatsApp</h4>
          <b> 
            <p>0992541127</p>
          </b>
        </div>
      </div>
      
      <div class="col-md-0 col-lg-12 text-center">
        <i class="icon fas fa-university fa-2x"></i>  
        <i class="icon fas fa-coins fa-2x"></i> 
        <i class="icon fab fa-cc-visa fa-2x"></i>
        <i class="icon fab fa-cc-mastercard fa-2x"></i>
      </div><br>


    </div>
    <div class="col-md-6 col-lg-4">
      <div class="">
        <div class="widget-small green coloured-icon">
          <div class="info">
            <p>
              <b>Nota:</b>
              <br>
              <ul class="text-justify">
                <li>Realizar el pago el día que el sistema le notifique.</li>
                <li>Realizar el pago al número de cuenta que aparece a tu izquierda.</li>
                <li>Puedes realizar los pagos por medio de depositos, transferencias, tarjetas de credito visa o mastercard.</li>
                <li>Cada vez que se realice un pago, deberas enviar un sms al número de WhatsApp con el comprobante de pago.</li>
              </ul>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  }
  ?>
</main>
<?php
  footer_view($data);
?>