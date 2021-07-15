
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="<?= MEDIA(); ?>images/icons/icon.ico">
    <title><?= NAME_PROJECT; ?> - Administración</title>

    
    <link rel="stylesheet" type="text/css" href="<?= ASSETS_VALI();?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= MEDIA();?>css/style-form.css">

</head>
<body>
    <div class="form-signin">
        <form action="" id="formLoginAdmin" name="formLoginAdmin">
            <div class="mb-4"></div>
            <div class="text-center mb-4">
                <center>
                    <img class="mb-4" src="<?= MEDIA(); ?>images/icons/icon.ico" alt="" width="72" height="72">
                    <h1 class="h2 font-weight-normal text-primary">Administración</h1>
                </center>
            </div>

            <div class="form-label-group mb-4">
                <input type="text" id="textUsername-email" name="textUsername-email" class="form-control login" placeholder="Username / email" >
            </div>

            <div class="form-label-group mb-6">
                <input type="password" id="textPassword" name="textPassword" class="form-control login" placeholder="Password" >
            </div><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesión</button><br>
            <center><a class="text-primary" href="">¿Olvidaste tu contraseña?</a></center>
            <p class="mt-3 mb-5 text-muted text-center">&copy; <?= NAME_PROJECT ?> - 2021</p>
        </form>
    </div>
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
    
</body>
</html>