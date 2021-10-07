<div class="modal fade" id="ModalFormUsers" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-register" id="modal-header-user">
        <h5 class="modal-title" id="title-modal-user">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formUsers" name="formUsers" class="form-horizontal">
                <input type="hidden" id="id_usuario" name="id_usuario" value="">
                
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label id="labelCedula" class="labelForm">Cedula <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputCedulaPasaporte" id="InputCedulaPasaporte" required> 
                      <p class="leyenda none-block text-danger" id="leyenda-cedula">
                        <small> 
                          La cedula debe de tener de 10 caracteres numericos!
                        </small>
                      </p>
                    </div>
                    
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label id="labelNombres" class="labelForm">Nombres Completos <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputNombres" id="InputNombres" required>
                      <p class="leyenda none-block text-danger" id="leyenda-nombres">
                        <small> 
                          El campo nombre tiene un maximo de 45 caracteres!
                        </small>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <label id="labelApellidoP" class="labelForm">Apellido Paterno <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputApellidoP" id="InputApellidoP" required>
                      <p class="leyenda none-block text-danger" id="leyenda-apellidoP">
                        <small> 
                          El campo apellido paterno tiene un maximo de 35 caracteres!
                        </small>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <label id="labelApellidoM" class="labelForm">Apellido Materno <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputApellidoM" id="InputApellidoM" required>
                      <p class="leyenda none-block text-danger" id="leyenda-apellidoM">
                        <small> 
                          El campo apellido materno tiene un maximo de 35 caracteres!
                        </small>
                      </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label id="labelEmail" class="labelForm">Email <span class="required">*</span></label>
                      <input class="form-control inputForm" type="email" name="InputEmail" id="InputEmail" required>
                      <p class="leyenda none-block text-danger" id="leyenda-email">
                        <small> 
                          El email es incorrecto, solo puede contener letras, numeros, puntos, guiones y guion bajo!<br>ejemplo: ads@ads.com
                        </small>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <label id="labelTelefono" class="labelForm">telefono <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputTelefono" id="InputTelefono" required>
                      <p class="leyenda none-block text-danger" id="leyenda-telefono">
                        <small> 
                          El telefono solo puede contener numeros y el maximo son 10 dígitos!
                        </small>
                      </p>
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Nacimiento <span class="required">*</span></label>
                        <input class="form-control" type="date" name="InputfechaNaci" id="InputfechaNaci" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Sexo <span class="required">*</span></label>
                        <select class="form-control" name="InputSexo" id="InputSexo" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                      <label>Tipo rol <span class="required">*</span></label>
                      <select class="form-control rol-register rol-update" name="InputTipoRol" id="InputTipoRol" required>
                      </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Estado <span class="required">*</span></label>
                        <select class="form-control" name="InputEstado" id="InputEstado">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4 pass-register pass-update" id="cajaPassword">
                    <div class="col-md-4">
                        <label id="labelPassword">Contraseña</label>
                        <input class="form-control" type="password" name="InputPassword" id="InputPassword"><br>
                        <input  type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"/>
                        &nbsp;&nbsp;Mostrar Contraseña
                        <p class="none-block text-danger" id="leyenda-password">
                          <small> 
                            La contraseñas debe de tener de 8 a 16 caracteres!
                          </small>
                        </p>
                    </div>
                    
                </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Guardar</samp> 
                  </button>&nbsp;&nbsp;&nbsp;

                  <a class="btn btn-secondary" href="#" data-dismiss="modal">
                    <i class="fa fa-fw fa-lg fa-times-circle"></i>
                    Cancelar
                  </a>
                </div>
              </form>
            </div>
            
          </div>
        </div>
    </div>
  </div>
</div>