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
      <img src="<?= MEDIA();?>images/thumbnail.jpg" width="1059px" height="470px">
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