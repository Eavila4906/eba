<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Restaurar contraseña - <?=NAME_PROJECT;?></title>
        <link rel="icon" href="<?= MEDIA(); ?>images/icons/icon.ico">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="<?= ASSETS_VALI();?>css/main.css">
        <link rel="stylesheet" type="text/css" href="<?= MEDIA();?>css/style-admin.css">
        <link rel="stylesheet" type="text/css" href="<?= MEDIA();?>css/style-form.css">
    </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <center><img src="<?= MEDIA(); ?>images/icons/icon.ico" style="width: 60px; height: 60px;"> </center>
        <h2 style="font-family: Segoe UI;">
          <?=NAME_PROJECT;?>
        </h2>
      </div>
      <div class="login-box flipped">
        <div id="divLoading" >
          <div>
            <img src="<?= MEDIA(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <form id="formRestablecerPass" name="formRestablecerPass" class="forget-form" action="">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$data['id_usuario']?>">
          <input type="hidden" name="email" id="email" value="<?=$data['email']?>">
          <input type="hidden" name="token" id="token" value="<?=$data['token']?>">
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
          <div class="form-group">
            <input id="InputPassword" name="InputPassword" class="form-control" type="password" placeholder="Ingresar nueva contraseña" required >
            <p class="none-block text-danger" id="leyenda-password">
              <small> 
                La contraseñas debe de tener de 8 a 16 caracteres!
              </small>
            </p>
          </div>
          <div class="form-group">
            <input id="InputConfirmPass" name="InputConfirmPass" class="form-control" type="password" placeholder="Confirmar contraseña" required >
            <p class="none-block text-danger" id="leyenda-confi-pass">
              <small>
                <i class="fas fa-exclamation-triangle text-danger"></i> 
                Ambas contraseñas deben de ser iguales
              </small>
            </p>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Restablecer</button>
          </div>
        </form>
      </div>
    </section>
    <script>
      const BASE_URL = "<?= BASE_URL(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= ASSETS_VALI();?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/popper.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/bootstrap.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/main.js"></script>
    <script src="<?= $data['functions_js'];?>"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= ASSETS_VALI();?>js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?= ASSETS_VALI();?>js/plugins/sweetalert.min.js"></script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>
    <!-- Our project just needs Font Awesome Solid + Brands -->
    <script src="<?= MEDIA();?>js/fontawesome/fontawesome.js"></script>
    
  </body>
</html>