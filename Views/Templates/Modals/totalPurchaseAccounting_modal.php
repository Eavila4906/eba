<div class="modal fade" id="ModalFormTotalPurchaseAccounting" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
                    <label id="labelValor-TP" class="labelForm">Valor del curso <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputValorTP" id="InputValorTP" type="text" placeholder="Ingresar valor del curso" required>
                    <p class="leyenda none-block text-danger" id="leyenda-Valor-TP">
                      <small> 
                        Ingresar un valor numerico valido.
                      </small>
                    </p>
                  </div>
                </div><br>

                <div class="row mb-1">
                  <div class="col-md-6">
                    <label id="labelNewPass" class="">Fecha Inicio curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaInicio" id="InputFechaInicio" required>
                    </div>
                  <div class="col-md-6">
                    <label id="labelConfirmPass" class="">Fecha final curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaFinal" id="InputFechaFinal" required>
                  </div>
                </div><br>

                <div class="row mb-1">
                  <div class="col-md-6" style="right: -22px;">
                    <label class="form-check-label" >
                      <input class="form-check-input" type="checkbox" name="InputAD" id="InputAD">Aplicar descuento
                    </label>
                  </div>
                  <div class="col-md-6" id="campoDescuento">
                    <label for="exampleSelect1">Descuento <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputDescuento" id="InputDescuento" required="">
                      <option value="0">0%</option>
                      <option value="5">5%</option>
                      <option value="10">10%</option>
                      <option value="15">15%</option>
                      <option value="20">20%</option>
                      <option value="25">25%</option>
                      <option value="30">30%</option>
                      <option value="35">35%</option>
                      <option value="40">40%</option>
                      <option value="45">45%</option>
                      <option value="50">50%</option>
                      <option value="55">55%</option>
                      <option value="60">60%</option>
                      <option value="65">65%</option>
                      <option value="70">70%</option>
                      <option value="75">75%</option>
                      <option value="80">80%</option>
                      <option value="85">85%</option>
                      <option value="90">90%</option>
                      <option value="95">95%</option>
                    </select>
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
