<!-- Modal -->
<div class="modal fade" id="ModalFormHeadquarter" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header modal-Headquarter header-register">
        <h5 class="modal-title" id="title-modal-Headquarter">Nueva sede</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formHeadquarter" name="formHeadquarter">
                <input type="hidden" id="id_headquarter" name="id_headquarter" value="">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label">Ubicación <span class="required">*</span></label>
                        <input class="form-control" name="InputUbicacion" id="InputUbicacion" type="text" placeholder="Ubicación" required="">
                        </div>
                        <div class="form-group">
                        <label class="control-label">Longitud <span class="required">*</span></label>
                        <input class="form-control" name="InputLongitud" id="InputLongitud" type="text" placeholder="Longitud" required="">
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Latitud <span class="required">*</span></label>
                            <input class="form-control" name="InputLatitud" id="InputLatitud" type="text" placeholder="Latitud" required="">
                        </div> 

                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" name="InputEstadoH" id="InputEstadoH" required="">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                        </div>  
                    </div>
                </div>
              
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-Headquarter">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn-Headquarter">Guardar</samp> 
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