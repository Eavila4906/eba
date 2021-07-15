<!-- Modal -->
<div class="modal fade" id="ModalFormSocialMedia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header modal-SocialMedia header-register">
        <h5 class="modal-title" id="title-modal-SocialMedia">Nuevo contenido - Acerca de</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formSocialMedia" name="formSocialMedia">
                <input type="hidden" id="id_socialMedia" name="id_socialMedia" value="">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label">Nombre <span class="required">*</span></label>
                        <input class="form-control" name="InputNombreRS" id="InputNombreRS" type="text" placeholder="Ingresar el nombre de la red social" required="">
                        </div>
                        <div class="form-group">
                        <label class="control-label">Link <span class="required">*</span></label>
                        <input class="form-control" name="InputLinkRS" id="InputLinkRS" type="text" placeholder="Ingresar el link de la red social" required="">                        
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Icono <span class="required">*</span></label>
                          <select class="form-control selectpicker fab" data-live-search="true" name="InputIconoRS" id="InputIconoRS" required>  
                          </select>
                        </div> 

                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" name="InputEstadoRS" id="InputEstadoRS" required="">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                        </div>  
                    </div>
                </div>
              
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-SocialMedia">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn-SocialMedia">Guardar</samp> 
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