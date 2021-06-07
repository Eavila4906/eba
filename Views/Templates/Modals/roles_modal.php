<!-- Modal -->
<div class="modal fade" id="ModalFormRoles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register">
        <h5 class="modal-title" id="title-modal">Nuevo rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formRoles" name="formRoles">
                <input type="hidden" id="id_rol" name="id_rol" value="">

                <p class="text-success text-msg-co-register text-msg-co-update" id="text-msg-co">
                  Todos los campos son obligatorios*
                </p>
                
                <div class="form-group">
                  <label class="control-label">Nombre rol</label>
                  <input class="form-control" name="TextNombreRol" id="TextNombreRol" type="text" placeholder="Ingresar Nombre rol">
                </div>

                <div class="form-group">
                  <label class="control-label">Descripción</label>
                  <textarea class="form-control" name="TextDescripcionRol" id="TextDescripcionRol" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                </div>

                <div class="form-group">
                  <label class="control-label">Estado</label>
                  <select class="form-control" name="ListaEstadoRol" id="ListaEstadoRol">
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                  </select>
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

