	  <script>
      const BASE_URL = "<?= BASE_URL(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= ASSETS_VALI();?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/popper.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/bootstrap.min.js"></script>
    <script src="<?= ASSETS_VALI();?>js/main.js"></script>
    <script src="<?= $data['functions_js'];?>"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= ASSETS_VALI();?>js/plugins/pace.min.js"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="<?= ASSETS_VALI();?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= ASSETS_VALI();?>js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= MEDIA();?>js/functions_system.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?= ASSETS_VALI();?>js/plugins/sweetalert.min.js"></script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>
    <!-- Our project just needs Font Awesome Solid + Brands -->
    
    <script src="<?= MEDIA();?>js/fontawesome/fontawesome.js"></script>
    
  </body>
</html>