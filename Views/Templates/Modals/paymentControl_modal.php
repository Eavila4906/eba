<div class="modal fade" id="ModalFormPaymentControl" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success" id="modal-header-PR">
        <h5 class="modal-title" id="title-modal-PR">Registrar control de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formPaymentControl" name="formPaymentControl">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="action" name="action" value="">
                <input type="hidden" id="id_student" name="id_student" value="">

                <div class="form-group">
                    <label for="exampleSelect1">Fecha del pago <span class="required">*</span></label>
                    <input type="date" class="form-control inputForm" id="InputDate_LP" name="InputDate_LP" required>
                </div>

                <div class="form-group">
                  <label id="labelDescripcion" class="labelForm">Descripción </label>
                  <textarea class="form-control inputForm" name="InputDescripcion" id="InputDescripcion" cols="30" rows="2"></textarea>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-PR">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Registrar</samp> 
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
