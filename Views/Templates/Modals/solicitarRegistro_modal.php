<div class="modal fade" id="ModalFormSolicitarRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                      <label>Cedula / Pasaporte</label>
                      <input class="form-control" type="text" name="InputCedulaPasaporte" id="InputCedulaPasaporte">
                    </div>
                    <div class="col-md-4">
                      <label>Nombres Completos</label>
                      <input class="form-control" type="text" name="InputNombres" id="InputNombres">
                    </div>
                </div><br>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label>Apellido Paterno</label>
                      <input class="form-control" type="text" name="InputApellidoP" id="InputApellidoP">
                    </div>
                    <div class="col-md-4">
                      <label>Apellido Materno</label>
                      <input class="form-control" type="text" name="InputApellidoM" id="InputApellidoM">
                    </div>
                    <div class="col-md-4">
                      <label>Email</label>
                      <input class="form-control" type="email" name="InputEmail" id="InputEmail">
                    </div>
                </div><br>

                <div class="row mb-4">
                    <div class="col-md-4">
                      <label>telefono</label>
                      <input class="form-control" type="text" name="InputTelefono" id="InputTelefono">
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Nacimiento</label>
                        <input class="form-control" type="date" name="InputfechaNaci" id="InputfechaNaci">
                    </div>
                    <div class="col-md-4">
                        <label>Sexo</label>
                        <select class="form-control" name="InputSexo" id="InputSexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
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