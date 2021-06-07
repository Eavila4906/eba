<?php 
    header_view($data);
?>

<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info"><img class="user-img" src="<?= MEDIA(); ?>images/image-perfil/author-image1.jpg">
              <h4><?= $_SESSION['dataUser']['username']; ?></h4>
              <p><?= $_SESSION['dataUser']['nombreRol']; ?></p>
            </div>
            <div class="cover-image"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Perfil</a></li>
              <li class="nav-item"><a class="nav-link" href="#profile-update" data-toggle="tab">Actualizar perfil</a></li>
              <li class="nav-item"><a class="nav-link" href="#password-update" data-toggle="tab">Cambiar contraseña</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <!-- Profile -->
            <div class="tab-pane active" id="profile">
              <div class="timeline-post">
                <div class="post-media"><a href="#"><img src="<?= MEDIA(); ?>images/image-perfil/author-image1.jpg"></a>
                  <div class="content">
                    <h5><a href="profile"><?= $_SESSION['dataUser']['username']; ?></a></h5>
                    <p class="text-muted"><small>2 January at 9:30</small></p>
                  </div>
                </div>
                <div class="post-content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <ul class="post-utility">
                  <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                  <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                  <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                </ul>
              </div>
              <div class="timeline-post">
                <div class="post-media"><a href="#"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"></a>
                  <div class="content">
                    <h5><a href="#">John Doe</a></h5>
                    <p class="text-muted"><small>2 January at 9:30</small></p>
                  </div>
                </div>
                <div class="post-content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <ul class="post-utility">
                  <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                  <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                  <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                </ul>
              </div>
            </div>

            <!-- Profile Update -->
            <div class="tab-pane fade" id="profile-update">
              <div class="tile user-settings">
                <h4 class="line-head text-primary">Actualizar perfil</h4>
                <form>
                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Cedula / Pasaporte</label>
                      <input class="form-control" type="text">
                    </div>
                    <div class="col-md-4">
                      <label>Nombres Completos</label>
                      <input class="form-control" type="text">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Apellido Paterno</label>
                      <input class="form-control" type="text">
                    </div>
                    <div class="col-md-4">
                      <label>Apellido Materno</label>
                      <input class="form-control" type="text">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Email</label>
                      <input class="form-control" type="text">
                    </div>
                    <div class="col-md-4">
                      <label>telefono</label>
                      <input class="form-control" type="text">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Sexo</label>
                      <select class="form-control" name="" id="">Sexo</select>
                    </div>
                    <div class="col-md-4">
                      <label>Fecha Nacimiento</label>
                      <input class="form-control" type="date">
                    </div>
                  </div>
                  
                  <div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Password Update -->
            <div class="tab-pane fade" id="password-update">
              <div class="tile user-settings">
                <h4 class="line-head text-primary">Cambiar contraseña</h4>
                <form>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                        <label>Contraseña Actual</label>
                        <input class="form-control" type="password">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label>Nueva Contraseña</label>
                            <input class="form-control" type="password">
                        </div>
                        <div class="col-md-4">
                            <label>Confirmar contraseña</label>
                            <input class="form-control" type="password">
                        </div>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-12">
                        <button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>

          </div>
        </div>
    </div>
</main>
<?php 
    footer_view($data);
?>