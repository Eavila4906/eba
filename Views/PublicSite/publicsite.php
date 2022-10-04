<?php
  header_view($data);
  getModal('galeryHome_modal', $data);
  getModal('about_modal', $data);
  getModal('icons_modal', $data);
  getModal('headquarter_modal', $data);
  getModal('contacts_modal', $data);
  getModal('socialMedia_modal', $data);
  getModal('teachers_modal', $data);
?> 
<main class="app-content">
  <div class="app-title">
    
    <div>
      <h1>
        <i class="fas fa-globe"></i> Administración del <?= $data['name_page']; ?> 
      </h1> 
      <p><?= NAME_PROJECT?></p>
    </div>

    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= BASE_URL(); ?>publicSite">Administración del <?= $data['name_page']; ?></a></li>
    </ul>

  </div>
  <?php
    $PublicSite =new PublicSite();
    $dataHomeGalery = $PublicSite->getAllContentGaleryHome();
    $dataAbout = $PublicSite->getAllContentAbout();
    $dataHeadquarter = $PublicSite->getAllHeadquarter();
    $dataContacts = $PublicSite->getAllContacts();
    $dataSocialMedia = $PublicSite->getAllSocialMedia();
    $dataTeachers = $PublicSite->getAllTeachers();
  ?>
  <!--Home-->
  <div id="home">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-home"><i class="fas fa-home"></i> Inicio
                <?php if ($_SESSION['permisosModulo']['w']) { ?>
                <button class="btn btn-success" id="btn-add-home" onclick="OpenModalAddContentsHomeGalery();"><i class="fas fa-plus fa-fw"></i>Agregar contenido</button>
                <?php } ?>
                </h4>
              </div>
              <div class="col-md-1">
                <a id="hideHome" href="javascript:;" title="Ocultar" onclick="fctHide('.body-home', '#hideHome', '#showHome', '#spaceHome', '#btn-add-home', '#title-home');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showHome" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-home', '#hideHome', '#showHome', '#spaceHome', '#btn-add-home', '#title-home');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceHome">
          <div class="body-home"> 
            <div class="row">
              <?php
                if (!empty($dataHomeGalery)) {
                  for ($i=0; $i < count($dataHomeGalery); $i++) {
              ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <img src="<?= MEDIA(); ?>images/image-public-site/carousel-image-home/<?= $dataHomeGalery[$i]['image']; ?>" width="100%" height="200%">
                  <div class="card-body">
                    <h6>Titulo: </h6> <p><?= $dataHomeGalery[$i]['titulo']; ?></p>
                    <h6>Descripcion: </h6><p><?= $dataHomeGalery[$i]['descripcion']; ?></p>
                    <?php if ($_SESSION['permisosModulo']['u']) { ?>
                    <button type="button" class="btn btn-sm btn-primary btnEditarConteHome" onclick="FctBtnEditarConteHome(<?= $dataHomeGalery[$i]['id_cont']; ?>)" title="Editar"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) { ?>
                    <button type="button" class="btn btn-sm btn-danger btnEliminarConteHome" onclick="FctBtnEliminarConteHome(<?= $dataHomeGalery[$i]['id_cont']; ?>, '<?= $dataHomeGalery[$i]['image']; ?>')" title="Eliminar"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <small class="col-md-11 text-muted">  <?= strftime("%A, %d de %B de %Y", strtotime($dataHomeGalery[$i]['fechaIU']));?></small>
                    <?php 
                        if ($dataHomeGalery[$i]['estado'] == 1) {
                    ?>
                          <small><i class="fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                </div>
              </div>  
              <?php
                  }
                } else {
              ?>
                <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
              <?php
                }
              ?>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--About-->
  <div id="about">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-about"><i class="fas fa-users"></i> Acerca de 
                <?php if ($_SESSION['permisosModulo']['w']) { ?>
                <button class="btn btn-success" id="btn-add-about" onclick="OpenModalAddContentsAbout();"><i class="fas fa-plus fa-fw"></i>Agregar contenido</button>
                <?php } ?>
              </h4>
              </div>
              <div class="col-md-1">
                <a id="hideAbout" href="javascript:;" title="Ocultar" onclick="fctHide('.body-About', '#hideAbout', '#showAbout', '#spaceAbout', '#btn-add-about', '#title-about');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showAbout" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-About', '#hideAbout', '#showAbout', '#spaceAbout', '#btn-add-about', '#title-about');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceAbout">
          <div class="body-About"> 
            <div class="row">
            <?php
              if (!empty($dataAbout)) {
                for ($i=0; $i < count($dataAbout); $i++) {
                  if (strlen($dataAbout[$i]['descripcion']) > 100) {
                    $id = $dataAbout[$i]['id_cont'];
                    $descripcion = $dataAbout[$i]['descripcion'];
                    $idlmas = "leermas".$id;
                    $idlmenos = "leermenos".$id;
                    $t1 = "text1".$id;
                    $t2 = "text2".$id;
                    $text1 = substr($descripcion,0,100).'...<a id="leermas'.$id.'" onclick="leerMas('.$idlmas.','.$t1.','.$t2.');" href="javascript:;">Leer mas</a>';
                    $text2 = $descripcion.'...<a id="leermenos'.$id.'" onclick="leerMenos('.$idlmenos.','.$t1.','.$t2.');" href="javascript:;">Leer menos</a>';
                    $des=1;
                  } else {
                      $descripcion =$dataAbout[$i]['descripcion'];
                      $des=2;
                  }   
            ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="card-body">
                    <h6>Titulo: </h6> <p><?= $dataAbout[$i]['titulo']; ?></p>
                    <?php 
                      if ($des == 1) { 
                    ?>
                        <h6>Descripcion: </h6> <p id="text1<?=$id;?>"><?= $text1; ?></p><p id="text2<?=$id;?>" style="display: none;"><?= $text2; ?></p>
                    <?php  
                      } else {
                    ?>  
                        <p><?=$descripcion;?> </p>      
                    <?php 
                      }
                    ?>
                    <?php if ($_SESSION['permisosModulo']['u']) {?>
                    <button type="button" class="btn btn-sm btn-primary btnEditarConteAbout" onclick="FctBtnEditarConteAbout(<?= $dataAbout[$i]['id_cont']; ?>)" title="Editar"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) {?>
                    <button type="button" class="btn btn-sm btn-danger btnEliminarConteAbout" onclick="FctBtnEliminarConteAbout(<?= $dataAbout[$i]['id_cont']; ?>)" title="Eliminar"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <small class="col-md-11 text-muted">  <?= strftime("%A, %d de %B de %Y", strtotime($dataAbout[$i]['fechaC']));?></small>
                    <?php 
                        if ($dataAbout[$i]['estado'] == 1) {
                    ?>
                          <small><i class="fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                </div>
              </div>
            <?php
                }
              } else {
            ?>
                <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
            <?php
              }
            ?>
            </div>
            <div>
              <?php if ($_SESSION['permisosModulo']['w']) {?>
              <button class="btn text-success" onclick="OpenModalAddIcons();"><i class="fas fa-plus fa-fw"></i>Agregar icono</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Teacher-->
  <div id="teacher">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-teachers"><i class="fas fa-chalkboard-teacher"></i> Teachers
                <?php if ($_SESSION['permisosModulo']['w']) { ?>
                <button class="btn btn-success" id="btn-add-teachers" onclick="OpenModalAddContentsTeachers();"><i class="fas fa-plus fa-fw"></i>Agregar contenido</button>
                <?php } ?>
              </h4>
              </div>
              <div class="col-md-1">
                <a id="hideTeachers" href="javascript:;" title="Ocultar" onclick="fctHide('.body-Teachers', '#hideTeachers', '#showTeachers', '#spaceTeachers', '#btn-add-teachers', '#title-teachers');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showTeachers" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-Teachers', '#hideTeachers', '#showTeachers', '#spaceTeachers', '#btn-add-teachers', '#title-teachers');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceTeachers">
          <div class="body-Teachers"> 
            <div class="row">
            <?php
              if (!empty($dataTeachers)) {
                for ($i=0; $i < count($dataTeachers); $i++) {
            ?>
              <div class="col-md-3">
                <div class="card mb-3">
                  <img src="<?= MEDIA().'images/image-profiles/'.$dataTeachers[$i]['photo']?>" class="img-responsive" width="100%" height="200%">
                  <div class="card-body">
                    <h3><?=$dataTeachers[$i]['nombres']?></h3>
                    <?php if ($_SESSION['permisosModulo']['u']) { ?>
                    <button type="button" class="btn btn-sm btn-danger btnEditarConteHome" onclick="FctBtnOnOrOffTeacher(<?= $dataTeachers[$i]['id_teacher']; ?>, 0)" title="Quitar de la portada"><i class="fas fa-power-off fa-lg"></i></button>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php
                }
              } else {
            ?>
                <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
            <?php
              }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Footer
  <h3>Pie de pagina</h3>-->
  <!--headquarter-->
  <div id="headquarter">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-headquarter"><i class="fas fa-map-marker-alt"></i> Sedes
                <?php if ($_SESSION['permisosModulo']['w']) {?>
                <button class="btn btn-success" id="btn-add-Headquarter" onclick="OpenModalAddHeadquarter();"><i class="fas fa-plus fa-fw"></i>Agregar sede</button>
                <?php } ?>
              </h4>
              </div>
              <div class="col-md-1">
                <a id="hideHeadquarter" href="javascript:;" title="Ocultar" onclick="fctHide('.body-Headquarter', '#hideHeadquarter', '#showHeadquarter', '#spaceHeadquarter', '#btn-add-Headquarter', '#title-headquarter');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showHeadquarter" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-Headquarter', '#hideHeadquarter', '#showHeadquarter', '#spaceHeadquarter', '#btn-add-Headquarter', '#title-headquarter');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceHeadquarter">
          <div class="body-Headquarter">
            <div class="row">
            <?php 
              if (!empty($dataHeadquarter)) {
                for ($i=0; $i < count($dataHeadquarter); $i++) {
            ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="card-body">
                    <h6>Sede: </h6> <p><?=$dataHeadquarter[$i]['ubicacion'];?></p>
                    <h6><center>Coordenadas geograficas</center></h6>
                    <h6>Longitud: </h6><p><?=$dataHeadquarter[$i]['longitud'];?></p>
                    <h6>Latitud: </h6><p><?=$dataHeadquarter[$i]['latitud'];?></p>
                    <?php if ($_SESSION['permisosModulo']['u']) {?>
                    <button type="button" class="btn btn-sm btn-primary" onclick="FctBtnEditarHeadquarter(<?= $dataHeadquarter[$i]['id_headquarter']; ?>)" title="Editar"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) {?>
                    <button type="button" class="btn btn-sm btn-danger" onclick="FctBtnEliminarHeadquarter(<?= $dataHeadquarter[$i]['id_headquarter']; ?>)" title="Eliminar"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <small class="col-md-11 text-muted">  <?= strftime("%A, %d de %B de %Y", strtotime($dataHeadquarter[$i]['fechaC']));?></small>
                    <?php 
                        if ($dataHeadquarter[$i]['estado'] == 1) {
                    ?>
                          <small><i class="fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                </div>
              </div>
            <?php
                }
              } else {
            ?>
                <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
            <?php  
              }
            ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--contacts-->
  <div id="contacts">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-contacts"><i class="fas fa-inbox"></i> Contactos
                <?php if ($_SESSION['permisosModulo']['w']) {?>
                <button class="btn btn-success" id="btn-add-Contacts" onclick="OpenModalAddContacts();"><i class="fas fa-plus fa-fw"></i>Agregar contacto</button>
                <?php } ?>
              </h4>
              </div>
              <div class="col-md-1">
                <a id="hideContacts" href="javascript:;" title="Ocultar" onclick="fctHide('.body-Contacts', '#hideContacts', '#showContacts', '#spaceContacts', '#btn-add-Contacts', '#title-contacts');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showContacts" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-Contacts', '#hideContacts', '#showContacts', '#spaceContacts', '#btn-add-Contacts', '#title-contacts');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceContacts">
          <div class="body-Contacts">
            <div class="row">
            <?php 
              if (!empty($dataContacts)) {
                for ($i=0; $i < count($dataContacts); $i++) {
            ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="card-body">
                    <h6>Telefono: </h6> <p><?=$dataContacts[$i]['telefono'];?></p>
                    <h6>email: </h6><p><?=$dataContacts[$i]['email'];?></p>
                    <?php if ($_SESSION['permisosModulo']['u']) {?>
                    <button type="button" class="btn btn-sm btn-primary" onclick="FctBtnEditarContacts(<?= $dataContacts[$i]['id_contacts']; ?>)" title="Editar"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) {?>
                    <button type="button" class="btn btn-sm btn-danger" onclick="FctBtnEliminarContacts(<?= $dataContacts[$i]['id_contacts']; ?>)" title="Eliminar"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <small class="col-md-11 text-muted">  <?= strftime("%A, %d de %B de %Y", strtotime($dataContacts[$i]['fechaC']));?></small>
                    <?php 
                        if ($dataContacts[$i]['estado'] == 1) {
                    ?>
                          <small><i class="fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                </div>
              </div>
            <?php
                }
              } else {
            ?>
                <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
            <?php  
              }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--social media-->
  <div id="social_media">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-11">
                <h4 class="text-secondary" id="title-social_media"><i class="fas fa-users"></i> Redes sociales
                <?php if ($_SESSION['permisosModulo']['w']) {?>
                <button class="btn btn-success" id="btn-add-SocialMedia" onclick="OpenModalAddSocialMedia();"><i class="fas fa-plus fa-fw"></i>Agregar red social</button>
                <?php } ?>
              </h4>
              </div>
              <div class="col-md-1">
                <a id="hideSocialMedia" href="javascript:;" title="Ocultar" onclick="fctHide('.body-SocialMedia', '#hideSocialMedia', '#showSocialMedia', '#spaceSocialMedia', '#btn-add-SocialMedia', '#title-social_media');"><i class="fas fa-angle-up fa-lg text-secondary"></i></a>
                <a id="showSocialMedia" href="javascript:;" style="display: none;" title="Mostrar" onclick="fctShow('.body-SocialMedia', '#hideSocialMedia', '#showSocialMedia', '#spaceSocialMedia', '#btn-add-SocialMedia', '#title-social_media');"><i class="fas fa-angle-down fa-lg text-secondary"></i></a>
              </div>
            </div>
          </div>
          <br id="spaceSocialMedia">
          <div class="body-SocialMedia">
            <div class="row">
              <?php 
                if (!empty($dataSocialMedia)) {
                  for ($i=0; $i < count($dataSocialMedia); $i++) {
              ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="card-body">
                    <h6>Red social: </h6> <p><?=$dataSocialMedia[$i]['nombre'];?></p>
                    <h6>link: </h6><p><a href="<?=$dataSocialMedia[$i]['link'];?>" target="_blank"><?=$dataSocialMedia[$i]['link'];?></a></p>
                    <?php if ($_SESSION['permisosModulo']['u']) {?>
                    <button type="button" class="btn btn-sm btn-primary" onclick="FctBtnEditarSocialMedia(<?= $dataSocialMedia[$i]['id_socialMedia']; ?>)" title="Editar"><i class="fas fa-pencil-alt fa-lg"></i></button>
                    <?php } ?>
                    <?php if ($_SESSION['permisosModulo']['d']) {?>
                    <button type="button" class="btn btn-sm btn-danger" onclick="FctBtnEliminarSocialMedia(<?= $dataSocialMedia[$i]['id_socialMedia']; ?>)" title="Eliminar"><i class="fas fa-trash-alt fa-lg"></i></button>
                    <?php } ?>
                    <small class="col-md-11 text-muted">  <?= strftime("%A, %d de %B de %Y", strtotime($dataSocialMedia[$i]['fechaC']));?></small>
                    <?php 
                        if ($dataSocialMedia[$i]['estado'] == 1) {
                    ?>
                          <small><i class="fas fa-circle text-success" title="Activo"></i></small>
                    <?php
                        } else {
                    ?>
                          <small><i class="fas fa-circle text-danger" title="Inactivo"></i></small>
                    <?php
                        } 
                    ?>
                  </div>
                </div>
              </div>
              <?php
                  }
                } else {
              ?>
                  <h3 class="text-muted" style="margin-left: 370px;">No existen datos para mostrar!</h3>
              <?php  
                }
              ?>
            </div>
            <div>
              <?php if ($_SESSION['permisosModulo']['w']) {?>
              <button class="btn text-success" onclick="OpenModalAddIcons();"><i class="fas fa-plus fa-fw"></i>Agregar icono</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</main>
<?php
  footer_view($data);
?>