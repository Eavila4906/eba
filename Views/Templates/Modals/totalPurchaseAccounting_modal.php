<div class="modal fade" id="ModalFormTotalPurchaseAccounting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register bg-info">
        <h5 class="modal-title" id="title-modal">Compra total</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formTotalPurchaseAccounting" name="formTotalPurchaseAccounting">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="id_student-TP" class="id_student-TP" name="id_student-TP" value="">

                <div class="row mb-1">
                  <div class="col-md-6">
                    <label for="exampleSelect1">Tipo de pago <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputTypePayment" id="InputTypePayment" required="">
                      <option value="Deposito">Deposito</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Transferencia">Transferencia</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label id="labelValor-TP" class="labelForm">Valor <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputValorTP" id="InputValorTP" type="text" placeholder="Ingresar valor de la compra" required>
                    <p class="leyenda none-block text-danger" id="leyenda-Valor-TP">
                      <small> 
                        Ingresar un valor numerico valido.
                      </small>
                    </p>
                  </div>
                </div><br>

                <div class="row mb-1">
                  <div class="col-md-6">
                    <label id="labelNewPass" class="">Fecha Inicio <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaInicio" id="InputFechaInicio" required>
                    </div>
                  <div class="col-md-6">
                    <label id="labelConfirmPass" class="">Fecha final <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaFinal" id="InputFechaFinal" required>
                  </div>
                </div><br>

                <div class="form-group">
                  <label id="labelDescripcion" class="labelForm">Descripción</label>
                  <textarea class="form-control inputForm" name="InputDescripcion" id="InputDescripcion" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-info" type="submit" id="btn-action-form-icons">
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
