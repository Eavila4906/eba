<!-- Modal -->
<div class="modal fade" id="ModalFormContacts" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header modal-Contacts header-register">
        <h5 class="modal-title" id="title-modal-Contacts">Nuevo contacto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formContacts" name="formContacts">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                <input type="hidden" id="id_contacts" name="id_contacts" value="">
                <div class="form-group">
                  <label id="labelTelefono" class="labelForm">Telefono <span class="required">*</span></label>
                  <input class="form-control inputForm" name="InputTelefono" id="InputTelefono" type="text" placeholder="Ingresar telefono" required>
                  <p class="leyenda none-block text-danger" id="leyenda-telefono">
                    <small> 
                      El campo telefono debe tener un valor valido a un telefono<br>ejemplo: +593 987 879 143.
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label id="labelEmail" class="labelForm">Email <span class="required">*</span></label>
                  <input class="form-control inputForm" name="InputEmail" id="InputEmail" type="text" placeholder="Ingresar email" required>
                  <p class="leyenda none-block text-danger" id="leyenda-email">
                    <small> 
                      El campo email debe tener un valor valido a un email<br>ejemplo: asd@example.com.
                    </small>
                  </p>
                </div>

                <div class="form-group">
                    <label for="exampleSelect1">Estado <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="InputEstadoC" id="InputEstadoC" required="">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form-Contacts">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn-Contacts">Guardar</samp> 
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