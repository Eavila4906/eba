<!-- Modal -->
<div class="modal fade" id="ModalFormStartsAccounting" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register">
        <h5 class="modal-title" id="title-modal">Iniciar contabilidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formStartsAccounting" name="formStartsAccounting">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="id_student" class="id_student" name="id_student" value="">

                <div class="form-group">
                  <label for="exampleSelect1">Cuota <span class="required">*</span></label>
                  <select class="form-control selectpicker" name="InputShare" id="InputShare" required="">
                    <option value="Mensual">Mensual</option>
                  </select>
                </div>
                
                <div class="row mb-1">
                  <div class="col-md-6">
                    <label for="exampleSelect1">Tipo de pago <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputFullValue" id="InputFullValue" required="">
                      <option value="Deposito">Deposito</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Transferencia">Transferencia</option>
                      <option value="Tarjeta de credito">Tarjeta de credito</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Curso <span class="required">*</span></label>
                    <select class="form-control category-register category-update" name="InputCourse" id="InputCourse" required>
                    </select>
                  </div>
                </div><br>

                <div class="row mb-1">
                  <div class="col-md-6">
                    <label for="exampleSelect1">Fecha inicio Contabilidad <span class="required">*</span></label>
                    <input type="date" class="form-control inputForm" id="InputFechaIC" name="InputFechaIC" required>
                  </div>
                  <div class="col-md-6">
                    <label for="exampleSelect1">Fecha final Contabilidad <span class="required">*</span></label>
                    <input type="date" class="form-control inputForm" id="InputFechaFC" name="InputFechaFC" required>
                  </div>
                </div><br>

                <div class="row mb-1">
                  <div class="col-md-6" style="right: -22px;">
                    <label class="form-check-label" >
                      <input class="form-check-input" type="checkbox" name="InputADIC" id="InputADIC" value="0">Aplicar descuento
                    </label>
                  </div>
                  <div class="col-md-6" id="campoDescuentoIC">
                    <label for="exampleSelect1">Descuento <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputDescuentoIC" id="InputDescuentoIC" required="">
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
                  <textarea class="form-control inputForm" name="description" id="description" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-icons">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Iniciar</samp> 
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
