<div class="modal fade " id="ModalSeePayments" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><span id="titleName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <h3 class="text-primary"></h3>
              <div class="tile-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered" id="DataTableSeePayment" class="display" cellspacing="0" cellpadding="3" width="100%">
                    <thead>
                      <tr>
                        <th>Periodo</th>
                        <th>Cantidad de pagos</th>
                        <th>Valor unitario</th>
                        <th>Total a pagar</th>
                        <th>Total</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center">
          <a class="btn btn-success" href="#" data-dismiss="modal">
            <i class="fa fa-fw fa-lg fas fa-arrow-alt-circle-left"></i>
            Listo
          </a>
        </div>
      </div>
    </div>
  </div>
</div>