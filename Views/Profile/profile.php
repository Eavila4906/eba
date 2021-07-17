<?php 
  header_view($data);
  getModal('subirFoto_modal', $data);
?>
<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info">
              <a href="javascript:;" type="Button" onclick="editPhotoProfile(<?=$_SESSION['dataUser']['id_usuario'];?>);">
              <img class="user-img" id="photo-profile" src=""></a>
              <h4><?= $_SESSION['dataUser']['nombres']." ".$_SESSION['dataUser']['apellidoP']." ".$_SESSION['dataUser']['apellidoM']?></h4>
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
                <div class="post-media"> 
                  <div class="content">
                    <h5 class="text-primary">Datos personales</h5> 
                  </div>
                </div>

                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td style="width: 150px">Cedula / Pasaporte</td>
                      <td id="DNI"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Nombres</td>
                      <td id="nombres"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Apellidos</td>
                      <td id="apellidos"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Sexo</td>
                      <td id="sexo"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Fecha de nacimiento</td>
                      <td id="fechaNacimiento"></td>
                    </tr>
                  </tbody>
                </table>

                <div class="post-media"> 
                  <div class="content">
                    <h5 class="text-primary">Contactos</h5> 
                  </div>
                </div>

                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td style="width: 150px">Email</td>
                      <td id="email"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Telefono</td>
                      <td id="telefono"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Profile Update -->
            <div class="tab-pane fade" id="profile-update">
              <div class="tile user-settings">
                <h4 class="line-head text-primary">Actualizar perfil</h4>
                <form name="FormUpdateDataUser" id="FormUpdateDataUser">
                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Cedula / Pasaporte</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio no editable" style="color: #ff8000;" width="3" height="3"></i>
                      <input class="form-control" type="text" name="InputDNI" id="InputDNI" disabled title="No editable!">
                    </div>
                    <div class="col-md-4">
                      <label>Nombres Completos</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio no editable" style="color: #ff8000;" width="3" height="3"></i>
                      <input class="form-control" type="text" name="InputNombres" id="InputNombres" disabled title="No editable!">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Apellido Paterno</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio no editable" style="color: #ff8000;" width="3" height="3"></i>
                      <input class="form-control" type="text" name="InputApellidoP" id="InputApellidoP" disabled title="No editable!">
                    </div>
                    <div class="col-md-4">
                      <label>Apellido Materno</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio editable" style="color: green;" width="3" height="3"></i>
                      <input class="form-control" type="text"  name="InputApellidoM" id="InputApellidoM">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label id="labelEmail" class="">Email</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio editable" style="color: green;" width="3" height="3"></i>
                      <input class="form-control" type="text" name="InputEmail" id="InputEmail">
                      <p class="none-block text-danger" id="leyenda-email">
                        <small> 
                          Email incorrecto, solo puede contener letras, numeros, puntos, guiones y guion bajo!<br>ejemplo: ads@ads.com
                        </small>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <label id="labelTelefono" class="">telefono</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio editable" style="color: green;" width="3" height="3"></i>
                      <input class="form-control" type="text" name="InputTelefono" id="InputTelefono">
                      <p class="none-block text-danger" id="leyenda-telefono">
                        <small> 
                          El telefono solo puede contener numeros y el maximo son 10 dígitos!
                        </small>
                      </p>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Sexo</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio editable" style="color: green;" width="3" height="3"></i>
                      <select class="form-control" name="InputSexo" id="InputSexo"></select>
                    </div>
                    <div class="col-md-4">
                      <label>Fecha Nacimiento</label> <i class="fa-fw fas fa-info-circle " title="Campo obligatorio editable" style="color: green;" width="3" height="3"></i>
                      <input class="form-control" type="date" name="InputFechaNaci" id="InputFechaNaci">
                    </div>
                  </div>
                  
                  <div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Actualizar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Password Update -->
            <div class="tab-pane fade" id="password-update">
              <div class="tile user-settings">
                <h4 class="line-head text-primary">Cambiar contraseña</h4>
                <form name="FormUpdatePassword" id="FormUpdatePassword">
                    <div id="notificationPass"></div>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                          <label>Contraseña Actual</label>
                          <input class="form-control" type="password" name="InputCurrentPass" id="InputCurrentPass" required>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label id="labelNewPass" class="">Nueva Contraseña</label>
                            <input class="form-control NewPass" type="password" name="InputNewPass" id="InputNewPass" required>
                            <p class="none-block text-danger" id="leyenda-new-pass">
                              <small> 
                                La contraseñas debe de tener de 8 a 16 caracteres!
                              </small>
                            </p>
                          </div>
                        <div class="col-md-4">
                            <label id="labelConfirmPass" class="">Confirmar contraseña</label>
                            <input class="form-control ConfirmPass" type="password" name="InputConfirmPass" id="InputConfirmPass" required>
                            <p class="none-block text-danger" id="leyenda-confi-pass">
                              <small>
                                <i class="fas fa-exclamation-triangle text-danger"></i> 
                                Ambas contraseñas deben de ser iguales
                              </small>
                            </p>
                          </div>
                    </div>

                    <div class="row mb-10">
                        <div class="col-md-12">
                          <button class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i> Hecho
                          </button>
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