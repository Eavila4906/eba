<div class="modal fade" id="ModalFormStopAccounting" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger" id="modal-header-DC">
        <h5 class="modal-title" id="title-modal-DC">Detener contabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formStopAccounting" name="formStopAccounting">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="id_accounting-sa" name="id_accounting-sa" value="">
                <input type="hidden" id="id_student-sa" name="id_student-sa" value="">
                <input type="hidden" id="periodo-sa" name="periodo-sa" value="">

                <div class="form-group">
                  <label id="labelJustificacion" class="labelForm">Justificación <span class="required">*</span></label>
                  <textarea class="form-control inputForm" name="InputJustificacion" id="InputJustificacion" cols="30" rows="2" required></textarea>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-danger" type="submit" id="btn-action-form-PR">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Hecho</samp> 
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