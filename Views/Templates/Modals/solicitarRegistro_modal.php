<div class="modal fade" id="ModalFormSolicitarRegistro" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Solicitar Registro - <?= NAME_PROJECT; ?></h5>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formSolicitarRegistro" name="formSolicitarRegistro" class="form-horizontal">
                <div id="notificationSolicitarRegistro"></div>
                <p class="text-green">
                  Todos los campos son obligatorios*
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
                    
                    <div class="col-md-4">
                      <label id="labelNombres" class="labelForm">Nombres Completos <span class="required">*</span></label>
                      <input class="form-control inputForm" type="text" name="InputNombres" id="InputNombres" required>
                      <p class="leyenda none-block text-danger" id="leyenda-nombres">
                        <small> 
                          El campo nombre tiene un maximo de 45 caracteres!
                        </small>
                      </p>
                    </div>
                </div><br>

                <div class="row mb-4">
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

                    <div class="col-md-4">
                      <label id="labelEmail" class="labelForm">Email <span class="required">*</span></label>
                      <input class="form-control inputForm" type="email" name="InputEmail" id="InputEmail" required>
                      <p class="leyenda none-block text-danger" id="leyenda-email">
                        <small> 
                          El email es incorrecto, solo puede contener letras, numeros, puntos, guiones y guion bajo!<br>ejemplo: ads@ads.com
                        </small>
                      </p>
                    </div>
                </div><br>

                <div class="row mb-4">
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

                    <div class="col-md-4">
                        <label>Sexo <span class="required">*</span></label>
                        <select class="form-control" name="InputSexo" id="InputSexo" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </div><br>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-green">Solicitar registro</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
              </form>
            </div>
            
          </div>
        </div>
    </div>
  </div>
</div>