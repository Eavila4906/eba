<!-- Modal -->
<div class="modal fade" id="ModalFormAbout" tabindex="-1" role="dialog" aria-hidden="true"
  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header modal-about header-register">
        <h5 class="modal-title" id="title-modal-about">Nuevo contenido - Acerca de</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formAbout" name="formAbout">
                <input type="hidden" id="id_contAbout" name="id_contAbout" value="">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label id="labelTituloAB" class="labelForm">Titulo <span class="required">*</span></label>
                          <input class="form-control inputForm" name="InputTituloAbout" id="InputTituloAbout" type="text" placeholder="Titulo del contenido" required="">
                          <p class="leyenda none-block text-danger" id="leyenda-titulo-ab">
                            <small> 
                              El titulo del contenido debe tener 1 o 60 caracteres, solo letras y sígnos de admiración e interrogación.
                            </small>
                          </p>
                        </div>
                        <div class="form-group">
                          <label id="labelDescripcionAB" class="labelForm">Descripción <span class="required">*</span></label>
                          <textarea class="form-control inputForm" name="InputDescripcionAbout" id="InputDescripcionAbout" rows="8" placeholder="Descripción del contenido" required=""></textarea>
                          <p class="leyenda none-block text-danger" id="leyenda-descripcion-ab">
                            <small> 
                              La descripción del contenido debe tener 1 caracterer como minimo, solo letras, espacios, números y sígnos de admiración.
                            </small>
                          </p>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Icono <span class="required">*</span></label>
                          <select class="form-control selectpicker fas" data-live-search="true" name="InputIconoAbout" id="InputIconoAbout" required>  
                          </select>
                        </div> 

                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" name="InputEstadoAbout" id="InputEstadoAbout" required="">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                        </div>  
                    </div>
                </div>
              
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-about">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn-about">Guardar</samp> 
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