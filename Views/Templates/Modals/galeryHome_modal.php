<!-- Modal -->
<div class="modal fade" id="ModalFormHomeGalery" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header header-register">
        <h5 class="modal-title" id="title-modal">Nuevo contenido - Galeria de inicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formHomeGalery" name="formHomeGalery" class="form-horizontal">
                <input type="hidden" id="id_cont" name="id_cont" value="">
                <input type="hidden" id="image_actual" name="image_actual" value="">
                <input type="hidden" id="image_remove" name="image_remove" value="0">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label id="labelTituloHG" class="labelForm">Titulo <span class="required">*</span></label>
                          <input class="form-control inputForm" name="InputTitulo" id="InputTitulo" type="text" placeholder="Titulo para la imagen" required="">
                          <p class="leyenda none-block text-danger" id="leyenda-titulo-hg">
                            <small> 
                              El titulo del contenido debe tener 1 o 60 caracteres, solo letras y sígnos de admiración e interrogación.
                            </small>
                          </p>
                        </div>

                        <div class="form-group">
                          <label id="labelDescripcionHG" class="labelForm">Descripción <span class="required">*</span></label>
                          <textarea class="form-control inputForm" name="InputDescripcion" id="InputDescripcion" rows="2" placeholder="Descripción para la imagen" required=""></textarea>
                          <p class="leyenda none-block text-danger" id="leyenda-descripcion-hg">
                            <small> 
                              La descripción del contenido debe tener 1 caracterer como minimo, solo letras, espacios, números y sígnos de admiración.
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
                    <div class="col-md-6">
                        <div class="photo">
                            <label for="image">Dimención de imagen (1920x1280)</label>
                            <div class="prevPhoto" title="Subir imagen">
                                <span class="delPhoto notBlock" title="Eliminar imagen">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                                <label for="image"></label>
                                <div>
                                  <img id="img" src="">
                                </div>
                                </div>
                                <div class="upimg">
                                <input type="file" name="image" id="image">
                            </div>
                            <br>
                            <div id="form_alert"></div>
                            <div id="name_photo"></div>
                        </div>
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

