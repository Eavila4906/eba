<!-- Modal -->
<div class="modal fade" id="ModalFormRoles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register" id="modal-header-rol">
        <h5 class="modal-title" id="title-modal-rol">Nuevo rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formRoles" name="formRoles">
                <input type="hidden" id="id_rol" name="id_rol" value="">
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p>
                
                <div class="form-group">
                  <label id="labelNombreRol" class="labelForm">Nombre rol <span class="required">*</span></label>
                  <input class="form-control inputForm" name="TextNombreRol" id="TextNombreRol" type="text" placeholder="Ingresar Nombre rol">
                  <p class="leyenda none-block text-danger" id="leyenda-nombreRol">
                    <small> 
                      El nombre del rol debe tener 1 o 20 caracteres, solo letras!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label id="labelDescripcionRol" class="labelForm">Descripción <span class="required">*</span></label>
                  <textarea class="form-control inputForm" name="TextDescripcionRol" id="TextDescripcionRol" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                  <p class="leyenda none-block text-danger" id="leyenda-descripcionRol">
                    <small> 
                      La descripcion del rol debe tener 1 o 80 caracteres!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label class="control-label">Estado <span class="required">*</span></label>
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

