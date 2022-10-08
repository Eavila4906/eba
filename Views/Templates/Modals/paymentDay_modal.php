<div class="modal fade" id="ModalFormPaymentDay" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="title-modal-rol">Día de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formPaymentDay" name="formPaymentDay">
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p><br>
                <p class="">
                    <b>Requisitos:</b> <br>
                    <span class="required">*</span> Solo podra poner un valor dentro del rango de 1 a 28. <br>
                    <span class="required">*</span> Solo solo se aceptara valores enteros.
                </p>

                <div class="form-group">
                    <label class="control-label labelForm" id="labelPaymentDay">Día de pago <span class="required">*</span></label>
                    <input type="text" class="form-control inputForm" name="InputPaymentDay" id="InputPaymentDay" required>
                    <p class="leyenda none-block text-danger" id="leyenda-PaymentDay">
                        <small> 
                            No cumple con los requisitos!
                        </small>
                    </p>
                </div>

                <p class="">
                    <b>Día actual de pagos:</b> todos los <span id="current-day"></span> de cada mes.
                </p>

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
  </div>
</div>