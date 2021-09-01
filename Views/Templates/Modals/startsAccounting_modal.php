<!-- Modal -->
<div class="modal fade" id="ModalFormStartsAccounting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <select class="form-control selectpicker" name="InputCuota" id="InputCuota" required="">
                    <option value="Mensual">Mensual</option>
                    <option value="Bimestral">Bimestral</option>
                    <option value="Trimestral">Trimestral</option>
                  </select>
                </div> 

                <div class="form-group">
                  <label id="labelValor" class="labelForm">Valor <span class="required">*</span></label>
                  <input class="form-control inputForm" name="InputValor" id="InputValor" type="text" placeholder="Ingresar valor de la cuota" required>
                  <p class="leyenda none-block text-danger" id="leyenda-Valor">
                    <small> 
                      Ingresar un valor numerico valido.
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label for="exampleSelect1">Fecha final contabilidad <span class="required">*</span></label>
                  <input type="date" class="form-control inputForm" id="InputFechaFC" name="InputFechaFC" required>
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
