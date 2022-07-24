<!-- Modal -->
<div class="modal fade" id="ModalFormCategory" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register" id="modal-header-category">
        <h5 class="modal-title" id="title-modal-category">Nuevo Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formCategory" name="formCategory">
                <input type="hidden" id="id_category" name="id_category" value="">
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p>
                
                <div class="form-group">
                  <label id="labelNombreRol" class="labelForm">Nombre Categoria <span class="required">*</span></label>
                  <input class="form-control inputForm" name="InputCategory" id="InputCategory" type="text" placeholder="Ingresar Nombre de la Categoria">
                  <p class="leyenda none-block text-danger" id="leyenda-nombreCategory">
                    <small> 
                      El nombre del rol debe tener 1 o 20 caracteres, solo letras!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label id="labelDescripcionRol" class="labelForm">Descripción <span class="required">*</span></label>
                  <textarea class="form-control inputForm" name="InputDescription" id="InputDescription" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                  <p class="leyenda none-block text-danger" id="leyenda-nombreCategory">
                    <small> 
                      La descripcion del rol debe tener 1 o 80 caracteres!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label class="control-label">Estado <span class="required">*</span></label>
                  <select class="form-control" name="InputStatus" id="InputStatus">
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