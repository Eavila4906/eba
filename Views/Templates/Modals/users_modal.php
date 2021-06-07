<div class="modal fade" id="ModalFormUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-register">
        <h5 class="modal-title" id="title-modal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formUsers" name="formUsers" class="form-horizontal">
                <input type="hidden" id="id_usuario" name="id_usuario" value="">
                
                <p class="text-success text-msg-co-register text-msg-co-update" id="text-msg-co">
                  Todos los campos son obligatorios*
                </p>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Cedula / Pasaporte</label>
                      <input class="form-control" type="text" name="InputCedulaPasaporte" id="InputCedulaPasaporte">
                    </div>
                    
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Nombres Completos</label>
                      <input class="form-control" type="text" name="InputNombres" id="InputNombres">
                    </div>
                    <div class="col-md-4">
                      <label>Apellido Paterno</label>
                      <input class="form-control" type="text" name="InputApellidoP" id="InputApellidoP">
                    </div>
                    <div class="col-md-4">
                      <label>Apellido Materno</label>
                      <input class="form-control" type="text" name="InputApellidoM" id="InputApellidoM">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Email</label>
                      <input class="form-control" type="email" name="InputEmail" id="InputEmail">
                    </div>
                    <div class="col-md-4">
                      <label>telefono</label>
                      <input class="form-control" type="text" name="InputTelefono" id="InputTelefono">
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Nacimiento</label>
                        <input class="form-control" type="date" name="InputfechaNaci" id="InputfechaNaci">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Sexo</label>
                        <select class="form-control" name="InputSexo" id="InputSexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                      <label>Tipo rol</label>
                      <select class="form-control rol-register rol-update" name="InputTipoRol" id="InputTipoRol">
                      </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Estado</label>
                        <select class="form-control" name="InputEstado" id="InputEstado">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4 pass-register pass-update" id="cajaPassword">
                    <div class="col-md-4">
                        <label>Contraseña</label>
                        <input class="form-control" type="password" name="InputPassword" id="InputPassword"><br>
                        <input  type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"/>
                        &nbsp;&nbsp;Mostrar Contraseña
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