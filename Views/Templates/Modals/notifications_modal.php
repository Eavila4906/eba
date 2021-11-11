<div class="modal fade" id="ModalNotificacions" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="modal-header">
        <h5 class="modal-title" id="title-modal"><span id="title"></span> - <span id="Mes"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!--Notifications payments-->
      <div class="modal-body" id="Notifications-paymets">
        <div class="row">
          <div class="col-md-7">
            <img src="<?= MEDIA();?>images/image-notifications/pago-satifactorio.jpg" width="400px" height="400px">
          </div>
          <div class="col-md-5">
            <h4 class="font-weight-bold">Información del pago</h4><br>
            <table class="default">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Periodo:</td>
                  <td id="periodo"></td>
                </tr>

                <tr>
                  <td style="width: 100px" class="font-weight-bold">Fecha:</td>
                  <td id="fechapago"></td>
                </tr>

                <tr>
                  <td style="width: 100px" class="font-weight-bold">Cantidad:</td>
                  <td id="cantidad"></td>
                </tr>

                <tr>
                  <td style="width: 100px" class="font-weight-bold">Tipo de pago:</td>
                  <td id="tipo-pago"></td>
                </tr>
              </tbody>
            </table>
            <br><br>
            <h4 class="font-weight-bold" id="nt-info-pp1">Información del proximo pago</h4><br>
            <table class="default" id="nt-info-pp2">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Periodo:</td>
                  <td id="periodo-pp"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Fecha:</td>
                  <td id="fecha-pp"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Cantidad:</td>
                  <td id="cantidad-pp"></td>
                </tr>
              </tbody>
            </table>
            <br><br>
            <h4 class="font-weight-bold" id="nt-info-ip1">Información de pagos</h4>
            <table class="default" id="nt-info-ip2">
                <tbody>
                  <tr>
                    <td style="width: 50px" class="font-weight-bold">Pagados:</td>
                    <td style="width: 50px" id="meses-pagados"></td>
                    <td style="width: 50px" class="font-weight-bold">Restantes:</td>
                    <td style="width: 50px" id="meses-por-pagar"></td>
                    <td style="width: 50px" class="font-weight-bold">Sobre:</td>
                    <td style="width: 50px" id="meses-contables"></td>
                  </tr>
                </tbody>
            </table>     
          </div>  
        </div>
        
      </div>
      <!--Payment reminder-->
      <div class="modal-body" id="Notifications-payment-reminder">
        <div class="row">
          <div class="col-md-7">
            <img src="<?= MEDIA();?>images/image-notifications/recordatorio-de-pago.jpg" width="400px" height="400px">
          </div>
          <div class="col-md-5">
            <h4 class="font-weight-bold">Nota:</h4>
            <p id="descripcion"></p> 
            <h4 class="font-weight-bold">Detalle del pago</h4><br>
            <table class="default">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Periodo:</td>
                  <td id="periodo-pp-rp"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Fecha:</td>
                  <td id="fecha-pp-rp"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Cantidad:</td>
                  <td id="cantidad-pp-rp"></td>
                </tr>
              </tbody>
            </table><br>
            <h4 class="font-weight-bold">Opciones de pago</h4><br>
            <table class="default">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight text-center">
                    <a href="https://www.pichincha.com/portal/inicio" target="_blank" title="Banco Pichincha">
                      <img src="<?= MEDIA();?>images/image-notifications/Banco-Pichincha.jpg" 
                      width="65px" height="65px" style="border-radius:100%;">
                    </a>
                  </td>
                  <td style="width: 100px" class="font-weight text-center">
                    <i class="icon fab fa-cc-visa fa-3x text-warning"></i>
                  </td>
                  <td style="width: 100px" class="font-weight text-center">
                    <i class="icon fab fa-cc-mastercard fa-3x text-warning"></i>
                  </td>
                </tr>
              </tbody>
            </table> 
            <p class="text-justify">
              Realizar el pago al número de cuenta <b>2100232502</b>, puedes realizar los pagos 
              por medio de depositos, transferencias, tarjetas de credito visa o mastercard.  
            </p> 
          </div>  
        </div>
      </div>
      <!--Payment Late Payment-->
      <div class="modal-body" id="Notifications-late-payment">
        <div class="row">
          <div class="col-md-7">
            <img src="<?= MEDIA();?>images/image-notifications/pago-atrasado.jpg" width="400px" height="400px">
          </div>
          <div class="col-md-5">
            <h4 class="font-weight-bold">Nota:</h4>
            <p class="text-justify" id="descripcion-pa"></p> 
            <h4 class="font-weight-bold">Detalle del pago</h4><br>
            <table class="default">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Periodo:</td>
                  <td id="periodo-pp-pa"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Fecha:</td>
                  <td id="fecha-pp-pa"></td>
                </tr>
                <tr>
                  <td style="width: 100px" class="font-weight-bold">Cantidad:</td>
                  <td id="cantidad-pp-pa"></td>
                </tr>
              </tbody>
            </table><br>
            <h4 class="font-weight-bold">Opciones de pago</h4><br>
            <table class="default">
              <tbody>
                <tr>
                  <td style="width: 100px" class="font-weight text-center">
                    <a href="https://www.pichincha.com/portal/inicio" target="_blank" title="Banco Pichincha">
                      <img src="<?= MEDIA();?>images/image-notifications/Banco-Pichincha.jpg" 
                      width="65px" height="65px" style="border-radius:100%;">
                    </a>
                  </td>
                  <td style="width: 100px" class="font-weight text-center">
                    <i class="icon fab fa-cc-visa fa-3x text-warning"></i>
                  </td>
                  <td style="width: 100px" class="font-weight text-center">
                    <i class="icon fab fa-cc-mastercard fa-3x text-warning"></i>
                  </td>
                </tr>
              </tbody>
            </table> 
            <p class="text-justify">
              Realizar el pago al número de cuenta <b>2100232502</b>, puedes realizar los pagos 
              por medio de depositos, transferencias, tarjetas de credito visa o mastercard.  
            </p>
          </div>  
        </div>
      </div>
    </div>
  </div>
</div>