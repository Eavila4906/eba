<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" id="photo-profile-nav" src="">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['dataUser']['username']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['dataUser']['nombreRol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <!-- PERSONAL AREA MODULE -->
        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
        <li class="treeview" id="module-personalArea">
          <a class="app-menu__item" id="personalArea" href="<?= BASE_URL(); ?>my"><i class="app-menu__icon 
          <?php 
            if ($_SESSION['dataUser']['nombreRol'] == "Estudiante") {
              echo "fas fa-user-graduate";
            } else if ($_SESSION['dataUser']['nombreRol'] == "Super Administrador" || $_SESSION['dataUser']['nombreRol'] == "Docente Administrador" || $_SESSION['dataUser']['nombreRol'] == "Administrador") {
              echo "fas fa-user-tie";
            } else {
              echo "fas fa-chalkboard-teacher";
            }
          ?>"></i><span class="app-menu__label">Area personal</span></a>
        </li>
        <?php } ?>
        
        <!-- DASHBOARD MODULE -->
        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
        <li class="treeview" id="module-dashboard">
          <a class="app-menu__item" id="dashboard" href="<?= BASE_URL(); ?>dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
        </li>
        <?php } ?>

        <!-- PUBLIC SITE MANAGER MODULE -->
        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
        <li class="treeview" id="module-publicSite">
          <a class="app-menu__item" id="publicSite" href="<?= BASE_URL(); ?>publicSite"><i class="app-menu__icon fas fa-globe"></i><span class="app-menu__label">Sitio publico</span></a>
        </li>
        <?php } ?>
        
        <!-- USER AND ROLES MODULES -->
        <?php if (!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][5]['r'])) { ?>
        <li class="treeview" id="module-users"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>users"><i id="icon-users" class="icon fa fa-circle-o"></i> Usuarios</a></li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>roles"><i id="icon-roles" class="icon fa fa-circle-o"></i> Roles</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- COURSES AND CATEGORYS MODULES -->
        <?php if (!empty($_SESSION['permisos'][9]['r']) || !empty($_SESSION['permisos'][10]['r'])) { ?>
        <li class="treeview" id="module-courses"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book-open"></i><span class="app-menu__label">Cursos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php if (!empty($_SESSION['permisos'][10]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>courses"><i id="icon-courses" class="icon fa fa-circle-o"></i> Cursos</a></li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>course_category"><i id="icon-category" class="icon fa fa-circle-o"></i> Categorías</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- ACCOUNTING, PAYMENT AND REPORTS MODULES -->
        <?php if (!empty($_SESSION['permisos'][6]['r']) || !empty($_SESSION['permisos'][7]['r']) || !empty($_SESSION['permisos'][8]['r'])) { ?>
        <li class="treeview" id="module-accounting">
          <a class="app-menu__item" href="js:;" data-toggle="treeview"><i class="app-menu__icon fas fa-calculator"></i><span class="app-menu__label">Contabilidad</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>accounting"><i id="icon-contabilidad" class="icon fa fa-circle-o"></i> Contabilidad</a></li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
            <li><a class="treeview-item" href="<?= BASE_URL(); ?>payment_record"><i id="icon-resgistrar-pago" class="icon fa fa-circle-o"></i> Registrar Pago</a></li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
            <li><a class="treeview-item" href="payment"><i id="icon-reportes" class="icon fa fa-circle-o"></i> Reportes</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- BACKUP MODULE -->
        <?php if (!empty($_SESSION['permisos'][11]['r'])) { ?>
        <li class="treeview" id="module-backup">
          <a class="app-menu__item" id="backup" href="<?= BASE_URL(); ?>backup"><i class="app-menu__icon fas fa-shield-alt"></i><span class="app-menu__label">Backup</span></a>
        </li>
        <?php } ?>
      </ul>
    </aside>