<!-- Modal -->
<div class="modal fade" id="ModalFormIcons" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register">
        <h5 class="modal-title" id="title-modal">Nuevo icono Font Awesome</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formIcons" name="formIcons">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="form-group">
                  <label class="control-label">Codigo <span class="required">*</span></label>
                  <input class="form-control" name="InputCodigo" id="InputCodigo" type="text" placeholder="Ingresar codigo del icono">
                </div>

                <div class="form-group">
                  <label class="control-label">Nombre <span class="required">*</span></label>
                  <input class="form-control" name="InputNombre" id="InputNombre" type="text" placeholder="Ingresar nombre del icono">
                </div>

                <div class="form-group">
                  <label for="exampleSelect1">Utilidad <span class="required">*</span></label>
                  <select class="form-control selectpicker" name="InputUtilidad" id="InputUtilidad" required="">
                    <option value="1">Acerca de</option>
                    <option value="2">Redes sociales</option>
                  </select>
                </div> 

                <br>
                <a href="https://fontawesome.com/" target="_blank">Galeria de iconos</a>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-icons">
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
