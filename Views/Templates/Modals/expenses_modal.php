<div class="modal fade" id="ModalFormExpenses" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger" id="modal-header-DC">
        <h5 class="modal-title" id="title-modal-DC">Registrar egreso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formStopExpenses" name="formStopExpenses">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="id_accounting-sa" name="id_accounting-sa" value="">
                <input type="hidden" id="id_student-sa" name="id_student-sa" value="">
                <input type="hidden" id="periodo-sa" name="periodo-sa" value="">

                <div class="row mb-1">
                  <div class="col-md-6">
                    <label for="exampleSelect1">Tipo de egreso <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputTypePayment-sa" id="InputTypePayment-sa" required="">
                      <option value="Deposito">Deposito</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Transferencia">Transferencia</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label id="labelValor" class="labelForm">Valor <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputValor" id="InputValor" type="text" placeholder="Ingresar valor del curso" required>
                    <p class="leyenda none-block text-danger" id="leyenda-Valor">
                      <small> 
                        Ingresar un valor numerico valido.
                      </small>
                    </p>
                  </div>
                </div><br>

                <div class="form-group">
                  <label id="labelJustificacion" class="labelForm">Descripción <span class="required">*</span></label>
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