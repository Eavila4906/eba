<?php
  header_view($data);
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
  if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
  ?>

  
  <div class="row">
    <div class="col-md-7">
      <img src="<?= MEDIA();?>images/thumbnail.jpg" width="1059px" height="500px">
    </div>
  </div>
  
  <br>

  <h4>Conoce nuestros metodos de pago</h4>
  <br>
  <div class="row">
    <div class="col-md-5">
      <img src="<?= MEDIA();?>images/metodos-pago.jpg" width="400px" height="300px">
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fas fa-landmark fa-3x"></i>
        <div class="info">
          <h4>B. Pichincha</h4>
          <b>
            <p>2100232502</p>
          </b>
          <a href="#" class="small-box-footer">Ir</a>
        </div>
      </div>
      <div class="widget-small info coloured-icon"><i class="icon fab fa-cc-visa fa-3x"></i>
        <div class="info">
          <h4>Visa</h4>
          <b> 
            <p></p>
          </b>
          <a href="" class="small-box-footer">Ir</a>
        </div>
      </div>
      <div class="widget-small info coloured-icon"><i class="icon fab fa-cc-mastercard fa-3x"></i>
        <div class="info">
          <h4>MasterCard</h4>
          <b>
            <p></p><i class="">
          </b>
          <a href="" class="small-box-footer">Ir</i></a>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small green coloured-icon"><i class="icon fab fa-whatsapp fa-3x"></i>
        <div class="info">
          <h4>WhatsApp</h4>
          <b> 
            <p>0992541127</p>
          </b>
          <a href="" class="small-box-footer">Mas información</i></a>
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