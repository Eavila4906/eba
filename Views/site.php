<!DOCTYPE html>
<html lang="en">
<head>

     <title><?= NAME_PROJECT; ?></title>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="icon" href="<?= MEDIA(); ?>images/icons/icon.ico">
     <link rel="stylesheet" href="<?= ASSETS_KN(); ?>css/bootstrap.min.css">
     
     <link rel="stylesheet" href="<?= ASSETS_KN(); ?>css/owl.carousel.css">
     <link rel="stylesheet" href="<?= ASSETS_KN(); ?>css/owl.theme.default.min.css">
     <!--<link rel="stylesheet" href="css/owl.theme.default.min.css">-->

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="<?= ASSETS_KN(); ?>css/templatemo-style.css">
     <link rel="stylesheet" href="<?= ASSETS_KN(); ?>css/style-retoques.css">
     <link rel="stylesheet" href="<?= MEDIA(); ?>css/style-form.css">

</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
     <div id="divLoading" >
          <div>
               <img src="<?= MEDIA(); ?>/images/loading.svg" alt="Loading">
          </div>
     </div>
     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">
               <span class="spinner-rotate"></span>
          </div>
     </section>
     <?php
          getModal('login_modal', $data);
          getModal('solicitarRegistro_modal', $data);
     ?>

     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="" class="navbar-brand">
                         <img src="<?= MEDIA(); ?>images/icons/icon-complet.ico">
                    </a>
               </div>
               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li><a href="#top" class="smoothScroll">Home</a></li>
                         <li><a href="#about" class="smoothScroll">About</a></li>
                         <li><a href="#team" class="smoothScroll">teachers</a></li>  
                         <!--<li><a href="#courses" class="smoothScroll">Courses</a></li>-->   
                         <li><a href="#contact" class="smoothScroll">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-nav-first navbar-right">
                         <li>
                              <a href="javascript:;" type="Button" onclick="OpenLoginForm();">
                                   <i class="fa fa-sign-in-alt"></i>Log in
                              </a>
                         </li>
                         <li>
                              <a href="javascript:;" type="Button" onclick="OpenSolicitarRegistroForm();">
                                   <i class="fa fa-user-plus"></i>Registrarse
                              </a>
                         </li>
                    </ul>
                    
               </div>

          </div>
     </section>

     <?php
          $Site =new Site();
          $ContentsHome = $Site->getAllContentsHome();
          $ContentsAbout = $Site->getAllContentsAbout();
          $ContentsHeadquarter = $Site->getAllContentsHeadquarter();
          $ContentsContacts = $Site->getAllContentsContacts();
          $ContentsSocialMedia = $Site->getAllContentsSocialMedia();
          $ContentsTeachers = $Site->getAllTeachers();
     ?>

     <!-- HOME -->
     <section id="home">
          <div id="containerHome">
               <div class="row">
                    <div class="owl-carousel owl-theme home-slider">
                         <?php
                         if (!empty($ContentsHome)) {
                              for ($i=0; $i < count($ContentsHome); $i++) {
                         ?>
                         <div class="item">
                              <img id="image" src="<?= MEDIA().'images/image-public-site/carousel-image-home/'.$ContentsHome[$i]['image']?>" alt="">  
                              <div class="text-carousel">
                                   <div class="col-md-9 col-sm-12">
                                        <h1 id="titulo"><?= $ContentsHome[$i]['titulo']; ?></h1>
                                        <h3 id="descripcion"><?= $ContentsHome[$i]['descripcion']; ?></h3>
                                   </div>
                              </div>
                         </div>
                         <?php
                              }
                         } else {
                         ?>
                              <h3 class="col-md-6 col-sm-12 csms text-muted">¡No existen datos para mostrar!</h3>
                         <?php
                         }
                         ?> 
                    </div>
               </div>
          </div>
     </section> 

     <!-- ABOUT -->
     <section id="about">
          <div class="container">
               <div class="row">
                    <div class="col-md-6 col-sm-12">
                         <div class="about-info">
                              <h2>About <?= NAME_PROJECT; ?></h2>
                              <?php
                              if (!empty($ContentsAbout)) {
                                   for ($i=0; $i < count($ContentsAbout); $i++) {
                                        if (strlen($ContentsAbout[$i]['descripcion']) > 100) {
                                             $id = $ContentsAbout[$i]['id_cont'];
                                             $descripcion = $ContentsAbout[$i]['descripcion'];
                                             $idlmas = "leermas".$id;
                                             $idlmenos = "leermenos".$id;
                                             $t1 = "text1".$id;
                                             $t2 = "text2".$id;
                                             $text1 = substr($descripcion,0,100).'...<a id="leermas'.$id.'" onclick="leerMas('.$idlmas.','.$t1.','.$t2.');" href="javascript:;">Leer mas</a>';
                                             $text2 = $descripcion.'...<a id="leermenos'.$id.'" onclick="leerMenos('.$idlmenos.','.$t1.','.$t2.');" href="javascript:;">Leer menos</a>';
                                        }
                              ?>
                              <figure>
                                   <span><i class="fas fa-<?= $ContentsAbout[$i]['icono']?>"></i></span>
                                   <figcaption>
                                        <h3><?= $ContentsAbout[$i]['titulo']?></h3>
                                        <p id="text1<?=$id;?>"><?= $text1; ?></p><p id="text2<?=$id;?>" style="display: none;"><?= $text2; ?></p>
                                   </figcaption>
                              </figure>
                              <?php
                                   }
                              } else {
                              ?>
                                   <h3 class="col-md-6 col-sm-12 csms text-muted">¡No existen datos para mostrar!</h3>
                              <?php
                              }
                              ?>
                         </div>
                    </div>

                    

               </div>
          </div>
     </section>


     <!-- TEAM -->
     <section id="team">
          <div class="container">
               <div class="row">

                    <div class="col-md-12 col-sm-12">
                         <div class="section-title">
                              <h2>Our teachers <small>Our main professors within the institution</small></h2>
                         </div>
                    </div>

                    <?php
                    if (!empty($ContentsTeachers)) {
                         for ($i=0; $i < count($ContentsTeachers); $i++) { 
                    ?>
                    <div class="col-md-3 col-sm-6">
                         <div class="team-thumb">
                              <div class="team-image">
                                   <img src="<?= MEDIA().'images/image-profiles/'.$ContentsTeachers[$i]['photo']?>" class="img-responsive" alt="">
                              </div>
                              <div class="team-info">
                                   <h3><?=$ContentsTeachers[$i]['nombres']?></h3>
                                   <!--<span>I love Teaching</span>-->
                              </div>
                              <!--<ul class="social-icon">
                                   <li><a href="#" class="fa fa-facebook-square" attr="facebook icon"></a></li>
                                   <li><a href="#" class="fa fa-twitter"></a></li>
                                   <li><a href="#" class="fa fa-instagram"></a></li>
                              </ul>-->
                         </div>
                    </div>
                    <?php
                         }
                    } else {
                    ?>
                         <h3 class="col-md-6 col-sm-12 csms text-muted">¡No existen datos para mostrar!</h3>
                    <?php   
                    }
                    ?>

               </div>
          </div>
     </section>

     <!-- COURSES -->
     <!--
     <section id="courses">
          <div class="container">
               <div class="row">
                    <div class="col-md-12 col-sm-12">
                         <div class="section-title">
                              <h2>Our Courses <small>our courses with their respective teachers</small></h2>
                         </div>

                         <div class="owl-carousel owl-theme owl-courses">
                              <div class="col-md-4 col-sm-4">
                              <div class="item">
                                   <div class="courses-thumb">
                                        <div class="courses-top">
                                             <div class="courses-image">
                                                  <img src="<?= ASSETS_KN(); ?>images/courses-image1.jpg" class="img-responsive" alt="">
                                             </div>
                                             <div class="courses-date">
                                                  <span><i class="fa fa-calendar"></i> 12 / 7 / 2018</span>
                                                  <span><i class="fa fa-clock-o"></i> 7 Hours</span>
                                             </div>
                                        </div>

                                        <div class="courses-detail">
                                             <h3><a href="#">Social Media Management</a></h3>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>

                                        <div class="courses-info">
                                             <div class="courses-author">
                                                  <img src="<?= ASSETS_KN(); ?>images/author-image1.jpg" class="img-responsive" alt="">
                                                  <span>Mark Wilson</span>
                                             </div>
                                             <div class="courses-price">
                                                  <a href="#"><span>USD 25</span></a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-4 col-sm-4">
                              <div class="item">
                                   <div class="courses-thumb">
                                        <div class="courses-top">
                                             <div class="courses-image">
                                                  <img src="<?= ASSETS_KN(); ?>images/courses-image2.jpg" class="img-responsive" alt="">
                                             </div>
                                             <div class="courses-date">
                                                  <span><i class="fa fa-calendar"></i> 20 / 7 / 2018</span>
                                                  <span><i class="fa fa-clock-o"></i> 4.5 Hours</span>
                                             </div>
                                        </div>

                                        <div class="courses-detail">
                                             <h3><a href="#">Graphic & Web Design</a></h3>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>

                                        <div class="courses-info">
                                             <div class="courses-author">
                                                  <img src="<?= ASSETS_KN(); ?>images/author-image2.jpg" class="img-responsive" alt="">
                                                  <span>Jessica</span>
                                             </div>
                                             <div class="courses-price">
                                                  <a href="#"><span>USD 80</span></a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-4 col-sm-4">
                              <div class="item">
                                   <div class="courses-thumb">
                                        <div class="courses-top">
                                             <div class="courses-image">
                                                  <img src="<?= ASSETS_KN(); ?>images/courses-image3.jpg" class="img-responsive" alt="">
                                             </div>
                                             <div class="courses-date">
                                                  <span><i class="fa fa-calendar"></i> 15 / 8 / 2018</span>
                                                  <span><i class="fa fa-clock-o"></i> 6 Hours</span>
                                             </div>
                                        </div>

                                        <div class="courses-detail">
                                             <h3><a href="#">Marketing Communication</a></h3>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>

                                        <div class="courses-info">
                                             <div class="courses-author">
                                                  <img src="<?= ASSETS_KN(); ?>images/author-image3.jpg" class="img-responsive" alt="">
                                                  <span>Catherine</span>
                                             </div>
                                             <div class="courses-price free">
                                                  <a href="#"><span>Free</span></a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-4 col-sm-4">
                              <div class="item">
                                   <div class="courses-thumb">
                                        <div class="courses-top">
                                             <div class="courses-image">
                                                  <img src="<?= ASSETS_KN(); ?>images/courses-image4.jpg" class="img-responsive" alt="">
                                             </div>
                                             <div class="courses-date">
                                                  <span><i class="fa fa-calendar"></i> 10 / 8 / 2018</span>
                                                  <span><i class="fa fa-clock-o"></i> 8 Hours</span>
                                             </div>
                                        </div>

                                        <div class="courses-detail">
                                             <h3><a href="#">Summer Kids</a></h3>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>

                                      <div class="courses-info">
                                             <div class="courses-author">
                                                  <img src="<?= ASSETS_KN(); ?>images/author-image1.jpg" class="img-responsive" alt="">
                                                  <span>Mark Wilson</span>
                                             </div>
                                             <div class="courses-price">
                                                  <a href="#"><span>USD 45</span></a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-4 col-sm-4">
                              <div class="item">
                                   <div class="courses-thumb">
                                        <div class="courses-top">
                                             <div class="courses-image">
                                                  <img src="<?= ASSETS_KN(); ?>images/courses-image5.jpg" class="img-responsive" alt="">
                                             </div>
                                             <div class="courses-date">
                                                  <span><i class="fa fa-calendar"></i> 5 / 10 / 2018</span>
                                                  <span><i class="fa fa-clock-o"></i> 10 Hours</span>
                                             </div>
                                        </div>

                                        <div class="courses-detail">
                                             <h3><a href="#">Business &amp; Management</a></h3>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>

                                        <div class="courses-info">
                                             <div class="courses-author">
                                                  <img src="<?= ASSETS_KN(); ?>images/author-image2.jpg" class="img-responsive" alt="">
                                                  <span>Jessica</span>
                                             </div>
                                             <div class="courses-price free">
                                                  <a href="#"><span>Free</span></a>
                                             </div>
                                        </div>
                                   </div>
                              </div> 
                         </div>
                    </div>
               </div>
          </div>
     </section>
     -->

     <!-- CONTACT -->
     <section id="contact">
          <div class="container">
               <div class="row">
                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form">
                              <div class="section-title">
                                   <h2>Contact us <small>Send an email to know your situation</small></h2>
                              </div>
                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" id="InputFullNameC" name="InputFullNameC" placeholder="Enter full name" required="">
                                   <div class="row mb-6">
                                        <div class="col-md-6">
                                             <input type="email" class="form-control inputForm" id="InputEmailC" name="InputEmailC" placeholder="Enter email address" required="">
                                             <p class="leyenda none-block text-danger" id="leyenda-emailC">
                                                  <small> 
                                                       Email incorrecto! <br>ejemplo: ads@ads.com
                                                  </small>
                                             </p>
                                        </div>
                                        <div class="col-md-6">
                                             <input type="text" class="form-control inputForm" id="InputTelefonoC" name="InputTelefonoC" placeholder="Enter full cell phone number" required="">
                                             <p class="leyenda none-block text-danger" id="leyenda-telefonoC">
                                                  <small> 
                                                       El telefono solo puede contener numeros y el maximo son 10 dígitos!
                                                  </small>
                                             </p>
                                        </div>
                                   </div>
                                   <textarea class="form-control" id="InputMessageC" name="InputMessageC" rows="6" placeholder="Tell us about your message" required=""></textarea>
                                   <div id="AlertContactForm"></div>
                              </div>
                              <div class="col-md-4 col-sm-12">
                                   <input type="submit" class="form-control" name="send message" value="Send Message">
                              </div>
                         </form>
                    </div>

                    <div class="col-md-6 col-sm-12">
                         <div class="contact-image">
                              <img src="<?= MEDIA(); ?>images/image-public-site/email.png" class="img-responsive" alt="Smiling Two Girls">
                         </div>
                    </div>

               </div>
          </div>
     </section>       


     <!-- FOOTER -->
     <footer id="footer">
          <div class="container">
               <div class="row">
                    <div class="col-md-4 col-sm-6">
                         <div class="footer-info">
                              <div class="section-title">
                                   <h2>Headquarter</h2>
                              </div>
                              <?php
                              if (!empty($ContentsHeadquarter)) {
                                   for ($i=0; $i < count($ContentsHeadquarter); $i++) {
                              ?>
                              <address>
                                   <p><?=$ContentsHeadquarter[$i]['ubicacion'];?><br> Longitud: <?=$ContentsHeadquarter[$i]['longitud'];?> Latitud: <?=$ContentsHeadquarter[$i]['latitud'];?></p>
                              </address>
                              <?php
                                   }
                              } else {
                              ?>
                                   <p class="text-muted">No existen datos para mostrar!</p>
                              <?php
                              }
                              ?> 
                              
                              <div class="copyright-text"> 
                                   <p>Copyright &copy; 2021 <?= NAME_PROJECT; ?></p>
                                   
                                   <p>Design by: TemplateMo</p>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                         <div class="footer-info">
                              <div class="section-title">
                                   <h2>Contact Info</h2>
                              </div>
                              <?php
                              if (!empty($ContentsContacts)) {
                                   for ($i=0; $i < count($ContentsContacts); $i++) {
                              ?>
                              <address>
                                   <p><?=$ContentsContacts[$i]['telefono'];?></p>
                                   <p><a href="javascript:;"><?=$ContentsContacts[$i]['email'];?></a></p>
                              </address>
                              <?php
                                   }
                              } else {
                              ?>
                                   <p class="text-muted">No existen datos para mostrar!</p>
                              <?php
                              }
                              ?> 

                              <div class="footer_menu">
                                   <h2>Social media</h2>
                                   <ul class="social-icon">
                                        <?php
                                        if (!empty($ContentsSocialMedia)) {
                                             for ($i=0; $i < count($ContentsSocialMedia); $i++) {
                                        ?>
                                        <li>
                                             <a href="<?=$ContentsSocialMedia[$i]['link'];?>" class="fab fa-<?=$ContentsSocialMedia[$i]['icono'];?>" target="_blank" title="<?=$ContentsSocialMedia[$i]['nombre'];?>"></a>
                                        </li>
                                        <?php
                                             }
                                        } else {
                                        ?>
                                             <p class="text-muted">No existen datos para mostrar!</p>
                                        <?php
                                        }
                                        ?> 
                                   </ul>

                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                         <div class="footer-info newsletter-form">
                              <div class="contact-image-footer">
                                   <img src="<?= MEDIA(); ?>images/icons/icon.ico" class="img-responsive" alt="Smiling Two Girls">
                              </div>  
                         </div>
                    </div>
                    
               </div>
          </div>
     </footer>


     <!-- SCRIPTS -->
     <script>
          const BASE_URL = "<?= BASE_URL(); ?>";
     </script>
     <script src="<?= ASSETS_KN(); ?>js/jquery.js"></script>
     <script src="<?= ASSETS_KN(); ?>js/bootstrap.min.js"></script>
     <script src="<?= ASSETS_KN(); ?>js/owl.carousel.min.js"></script>
     <script src="<?= ASSETS_KN(); ?>js/smoothscroll.js"></script>
     <script src="<?= ASSETS_KN(); ?>js/custom.js"></script>
     <script src="<?= MEDIA(); ?>js/functions_website.js"></script>
     <script src="<?= MEDIA();?>js/fontawesome/fontawesome.js"></script>
     
</body>
</html>