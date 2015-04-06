<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <? $this->Html->meta('icon', 'favicon.ico'); ?>
    <title>TIMECrisis</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/formvalidation/formValidation.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/bootstrap-notify/animate.css" rel="stylesheet" type="text/css" />

    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    
    <!-- START OF GOOGLE MAPS API -->

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;signed_in=true"></script>
    <script src="script/maps.js"></script>
</head>
  
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
        	<img src="dist/img/logo.png" width="40px" height="40px" style="margin-bottom:5px; margin-right:5px;" /><b>TIME</b>Crisis
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
               <!-- VISIT SITE LINK-->
              <li class="#">
                <a href="/report">
                  <span class="hidden-xs">Report an incident</span>
                </a>
              </li>

              <li class="#">
                <a href="http://www.facebook.com/" target="_blank">
                  <span class="hidden-xs">Facebook</span>
                </a>
              </li>
	      
	             <li class="#">
                <a href="http://www.twitter.com/" target="_black">
                  <span class="hidden-xs">Twitter</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- ..............................................................NAVIGATION................................................... -->
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php if ($page == "dashboard"){ ?>  <li class= "active treeview"> <?php }else{ ?> <li class= "treeview"> <?php }?>
              <a href="/">
                <i class="fa fa-dashboard"></i> <span>Home</span> </i>
              </a>
            </li>
	    
      	    <?php if ($page == 'about') { ?> <li class="active treeview"> <?php } else { ?> <li class="treeview"> <?php } ?>
      	      <a href="about">
      		        <i class="fa fa-laptop"></i> <span>About</span>
      	      </a>
      	    </li>

            <!-- MANAGE INCIDENTS-->
            <?php if ($page == "report_incidents" || $page == "incidents" || $page == "incident_category"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Incidents</span>
		              <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if ($page == "report_incidents"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
                    <a href="report"><i class="fa fa-circle-o"></i>Report An Incident</a>
                </li>
                <?php if ($page == "incidents"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
                    <a href="incident"><i class="fa fa-circle-o"></i>Incidents</a>
                </li>
              </ul>
            </li>
            
            <!-- MANAGE EVENTS-->
            <?php if ($page == "haze" || $page == "dengue"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
              <a href="#">
                <i class="fa fa-share"></i>
                <span>Events</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if ($page == "dengue"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
                  <a href="dengue"><i class="fa fa-circle-o"></i>Dengue</a>
                </li>
                <?php if ($page == "haze"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
                  <a href="haze"><i class="fa fa-circle-o"></i>Haze</a>
                </li>
              </ul>
            </li>

            <!-- MANAGE CONTACTS -->
            <?php if ($page == "contact"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
              <a href="contact">
                <i class="fa fa-envelope"></i>
                <span>Contact</span>
              </a>
            </li>
	    
	         <!-- MANAGE SUBSCRIBE -->
            <?php if ($page == "subscribe"){ ?>  <li class= "active"> <?php }else{ ?> <li> <?php }?>
              <a href="subscribe">
                <i class="fa fa-edit"></i>
                <span>Subscribe</span>
              </a>
            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- .............................................END OF NAVIGATION............................................. -->


      <!-- ...................................... MAIN CONTENT ................................................. -->
      <!-- DASHBOARD -->
      <!-- Content Wrapper. Contains page content -->

      <!-- ...................................... END OF MAIN CONTENT................................................. -->
      <?= $this->fetch('content') ?>

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          Admin Panel
        </div>
        <strong>Copyright &copy; 2015 <a href="#">TIMECrisis</a>.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->
      
    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>

    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

    <!-- formvalidation -->
    <script src="../plugins/formvalidation/formValidation.min.js"></script>
    <script src="../plugins/formvalidation/bootstrap.min.js"></script>

    <!-- bootstrap-notify -->
    <script src="../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>

    <?php
      switch ($page) {
        case 'report_incidents':
          ?>
          <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
          <script src="dist/js/jquery.geocomplete.min.js"></script>
          <script src="script/public/incidents.js"></script><?php
          break;
        case 'subscribe':
          ?>
          <script src="script/public/subscribe.js"></script><?php
          break;
        default:
          break;
      }
    ?>
    
    <?= $this->Flash->render(); ?>

  </body>
</html>

