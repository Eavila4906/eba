<div class="modal fade" id="ModalFormMyNewContent" tabindex="-1" role="dialog" aria-hidden="true"
  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header modal-MNC header-register">
        <h5 class="modal-title" id="title-modal-MNC">Nuevo contenido - Area personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formMyNewContent" name="formMyNewContent">
                <input type="hidden" id="id_my_content" name="id_my_content" value="">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label id="labelNombre" class="labelForm">Nombre <span class="required">*</span></label>
                          <input class="form-control inputForm" name="InputNombre" id="InputNombre" type="text" placeholder="Ingresar el nombre" required="">
                          <p class="leyenda none-block text-danger" id="leyenda-nombre">
                            <small> 
                              El campo nombre debe tener almenos 1 caracter.
                            </small>
                          </p>
                        </div>
                        <div class="form-group">
                            <label id="labelDescripcion" class="labelForm">Descripción <span class="required">*</span></label>
                            <textarea class="form-control inputForm" name="InputDescripcion" id="InputDescripcion" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                            <p class="leyenda none-block text-danger" id="leyenda-descripcion">
                                <small> 
                                La descripcion del rol debe tener 1 o 80 caracteres!
                                </small>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label id="labelLink" class="labelForm">Link <span class="required">*</span></label>
                          <input class="form-control inputForm" name="InputLink" id="InputLink" type="text" placeholder="Ingresar el link" required="">                        
                          <p class="leyenda none-block text-danger" id="leyenda-link">
                            <small> 
                              El campo link debe tener un valor valido a una URL<br>example: http://www.example.com/....
                            </small>
                          </p>
                        </div> 

                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" name="InputEstado" id="InputEstado" required="">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                        </div>  
                    </div>
                </div>
              
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-MNC">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn-MNC">Guardar</samp> 
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