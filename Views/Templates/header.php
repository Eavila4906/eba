<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= NAME_PROJECT ?> - Administración</title>
    <link rel="icon" href="<?= MEDIA(); ?>images/icons/icon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= ASSETS_VALI();?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= MEDIA();?>css/style-admin.css">
    <link rel="stylesheet" type="text/css" href="<?= MEDIA();?>css/style-form.css">
    <!-- Font-icon css
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    -->
    
  </head>
  <?php
    getModal('notifications_modal', $data);
  ?>
  <body class="app sidebar-mini">
    <div id="divLoading" >
      <div>
        <img src="<?= MEDIA(); ?>/images/loading.svg" alt="Loading">
      </div>
    </div>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= BASE_URL(); ?><?php if ($_SESSION['dataUser']['nombreRol'] == "Super Administrador") {
      echo "dashboard";
    } else {
      echo "my";
    }?>"><img src="<?= MEDIA(); ?>images/icons/icon.ico" width="40" style="margin-top: 0;"> EBA</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        
        <!--Notification Menu-->
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications">
            <i class="fa fa-bell-o fa-lg"></i>
            <span class="badge badge-pill badge-danger" style="float:right;margin-bottom:-10px;" id="countNotifications"></span>
          </a>
          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">
              <b id="title-notifications"></b>
            </li>
            <div class="app-notification__content">
              <div id="Notifications"></div>
            </div>
          </ul>
        </li>

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user-circle fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="profile"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><button class="dropdown-item" onclick="logout();"><i class="fa fa-sign-out fa-lg"></i> Cerrar sesión</a></button></li>
          </ul>
        </li>
      </ul>
    </header>
    <?php
      require_once("Views/Templates/nav.php");
    ?>