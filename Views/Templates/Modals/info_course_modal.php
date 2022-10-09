<div class="modal fade" id="ModalInfoCourse" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-infoCourse">
        <h5 class="modal-title" id="title-modal"></i> <b id="title"></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <!-- info course -->
      <div class="tab-pane active" >
      <input type="hidden" id="id_Course" name="id_Course" value="">
      <!-- <input type="hidden" id="getIdCourse" name="getIdCourse" value=""> -->
              <div class="timeline-post">
                <div class="post-media"> 
                  <div class="content">
                    <h5 class="text-primary">Info del curso</h5> 
                  </div>
                </div>

                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td style="width: 150px">Curso</td>
                      <td id="getCourse"></td>
                    </tr>
                    <tr>
                      <td style="width: 150px">Categoria</td>
                      <td id="getCategory"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Fecha de inicio</td>
                      <td id="getDateStart"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Fecha final</td>
                      <td id="getDateFinal"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Valor del curso</td>
                      <td id="getValueCourse"></td>
                    </tr>

                    <tr>
                      <td style="width: 150px">Descripción</td>
                      <td id="getDescription"></td>
                    </tr>
                    <tr>
                      <td style="width: 150px">Estado</td>
                      <td id="getStatus"></td>
                    </tr>

                  </tbody>
                </table>



                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>