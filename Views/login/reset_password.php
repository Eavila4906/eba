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
        <h1>
          <?=NAME_PROJECT;?>
        </h1>
      </div>
      <div class="login-box flipped">
        <div id="divLoading" >
          <div>
            <img src="<?= MEDIA(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <form id="formResetPass" name="formResetPass" class="forget-form" action="">
          <h5 class="login-head text-primary"><i class="fas fa-fw fa-lock"></i>¿Olvidaste la contraseña?</h5>
          <div class="form-group">
            <label class="" id="labelEmailRP">Email de recuperación de contraseña</label>
            <input id="InputEmailRP" name="InputEmailRP" class="form-control" type="email" placeholder="Introduce email">
            <p class="none-block text-danger" id="leyenda-emailRP">
              <small> 
              Email incorrecto!<br>ejemplo: ads@ads.com
              </small>
            </p>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-unlock fa-lg fa-fw"></i>Restablecer</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0">
              <a href="<?=BASE_URL();?>" data-toggle="flip">
                <i class="fas fa-angle-left fa-fw"></i> Principal
              </a>
            </p>
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