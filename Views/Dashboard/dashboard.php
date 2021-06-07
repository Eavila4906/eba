<?php
  header_view($data);
  getModal('notificacion_modal', $data);
?>
    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p><?= NAME_PROJECT?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= BASE_URL(); ?>dashboard">Dashboard</a></li>
        </ul>
      </div>
      
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fas fa-users fa-3x"></i>
            <div class="info">
              <h4>Usuarios</h4>
              <b>
                <p id="CountUsers"></p>
              </b>
              <a href="users" class="small-box-footer">Mas información</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fas fa-book-open fa-3x"></i>
            <div class="info">
              <h4>Cursos</h4>
              <b>
                <p id="CountCourses"></p>
              </b>
              <a href="" class="small-box-footer">Mas información</i></a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fas fa-user-graduate fa-3x"></i>
            <div class="info">
              <h4>Estudiantes</h4>
              <b> 
                <p id="CountStudens"></p>
              </b>
              <a href="" class="small-box-footer">Mas información</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small green coloured-icon"><i class="icon fas fa-chalkboard-teacher fa-3x"></i>
            <div class="info">
              <h4>Docentes</h4>
              <b> 
                <p id="CountTeachers"></p>
              </b>
              <a href="" class="small-box-footer">Mas información</i></a>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php
  footer_view($data);
?>