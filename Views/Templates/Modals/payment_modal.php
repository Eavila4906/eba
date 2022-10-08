<div class="modal fade" id="ModalFormPayment" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success" id="modal-header-PR">
        <h5 class="modal-title" id="title-modal-PR">Pago mensual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formPayment" name="formPayment">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="DNI" name="DNI" value="">
                <input type="hidden" id="id_accounting" name="id_accounting" value="">
                <input type="hidden" id="fecha_UP" name="fecha_UP" value="">
                <input type="hidden" id="nombres" name="nombres" value="">
                
                
                <div class="form-group" id="cap-tp">
                  <label for="exampleSelect1">Tipo de pago <span class="required">*</span></label>
                  <select class="form-control selectpicker" name="InputTypePayment" id="InputTypePayment" required="">
                    <option value="Deposito">Deposito</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Tarjeta de credito">Tarjeta de credito</option>
                  </select>
                </div>

                <div class="form-group">
                  <label id="labelDescripcion" class="labelForm">Descripción </label>
                  <textarea class="form-control inputForm" name="InputDescripcion" id="InputDescripcion" cols="30" rows="2"></textarea>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-PR">
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
