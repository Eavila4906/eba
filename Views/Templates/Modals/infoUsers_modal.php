<div class="modal fade" id="ModalInfoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-infoUser">
        <h5 class="modal-title" id="title-modal"><i class="fa fa-user col-1"></i> <b id="title"></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
          <div class="tile-body">
            <input type="hidden" id="id_usuario" name="id_usuario" value="">
            <div class="container-fluid">
              <div class="row">

                <div class="col-3">
                  <div class="row mb-4">
                    <div class="col-md-4" id="getFoto"></div>
                  </div>
                </div>
                        
                <div class="col-9">

                  <div class="row mb-4 p-3 mb-2 bg-light">
                    <div class="col-md-4 ">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-user-circle col-1"></i> usuario</label>
                      <p class="card-body" id="getUsername"></p>
                    </div>       
                    <div class="col-md-4">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-tag col-1"></i> Rol</label>
                      <p class="card-body" id="getTipoRol"></p>
                    </div>
                    <div class="col-md-4">
                      <label  class="card-header text-primary font-weight-bold"><i class="fa fa-circle col-1"></i> Estado</label>
                      <p class="card-body" id="getEstado"></p>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4 ">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-id-card-o"></i> Identificación</label>
                      <p class="card-body" id="getCedula-Pasaporte"></p>
                    </div>  
                    <div class="col-md-5 ">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-user "></i> Nombres y Apellidos</label>
                      <p class="card-body" id="getNombres"></p>
                    </div>        
                    <div class="col-md-3">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-venus-mars"></i> Sexo</label>
                      <p class="card-body" id="getSexo"></p>
                    </div>
                  </div>

                  

                  <div class="row mb-4 ">
                    <div class="col-md-4">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-envelope col-1"></i> Email</label>
                      <p class="card-body" id="getEmail"></p>
                    </div>
                    <div class="col-md-4">
                          <label class="card-header text-primary font-weight-bold"><i class="fa fa-phone col-1"></i> telefono</label>
                          <p class="card-body" id="getTelefono"></p>
                    </div>
                    <div class="col-md-4">
                      <label class="card-header text-primary font-weight-bold"><i class="fa fa-calendar col-1"></i> Fecha N</label>
                      <p class="card-body" id="getFechaNaci"></p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>