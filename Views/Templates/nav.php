<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= MEDIA(); ?>images/image-perfil/author-image1.jpg">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['dataUser']['username']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['dataUser']['nombreRol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?= BASE_URL(); ?>dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item" href=""><i class="app-menu__icon fas fa-globe-americas"></i><span class="app-menu__label">Sitio publico</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="users"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
            <li><a class="treeview-item" href="roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
            <li><a class="treeview-item" href=""><i class="icon fa fa-circle-o"></i> Permisos</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href=""><i class="app-menu__icon fas fa-book-open"></i><span class="app-menu__label">Cursos</span></a></li>
        
      </ul>
    </aside>