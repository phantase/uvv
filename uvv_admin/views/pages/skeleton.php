<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Union Vovinam | <?php echo $title; ?></title>
    <base href="/uvv_admin/">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <?php echo $cssLibSkeleton; ?>
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins -->
    <link href="dist/css/skins/skin-green.min.css" rel="stylesheet" type="text/css" />
    <!-- Custo CSS -->
    <link href="dist/css/Custo.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
<?php if($printmode) { ?>
  <body onload="window.print();">
<?php } else { ?>
  <body class="skin-green sidebar-mini">
<?php } ?>
    <div class="wrapper">
<?php if(!$printmode){ ?>
    <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="home" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>U</b>VV</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Union</b> Vovinam</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"><?php echo _('Toggle navigation'); ?></span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
<?php 
	if( isLogged() ) {
		include_once('views/modules/header_invoices-menu.php');
		//include_once('views/modules/header_messages-menu.php');
		//include_once('views/modules/header_notifications-menu.php');
		//include_once('views/modules/header_tasks-menu.php');
		include_once('views/modules/header_user-account-menu.php');
	}
	
	//include_once('views/modules/header_control-sidebar-toggle-button.php');
	
?>
            </ul>
          </div>
        </nav>
      </header>
	  
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
<?php 
	if( isLogged() )
		include_once('views/modules/sidebar_user-panel.php');
	else
		include_once('views/modules/sidebar_login-link.php');
//	include_once('views/modules/sidebar_search-form.php');
	if( isLogged() )
		include_once('views/modules/sidebar_menu-connected.php');
	else
		include_once('views/modules/sidebar_menu-disconnected.php');
?>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
	  
<?php
    }
    include_once('views/pages-parts/'.$action.'.php');
    if( !$printmode ) {
?>
	  
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
<?php include_once('views/modules/footer.php'); ?>
      </footer>
      
<?php include_once('views/modules/control-sidebar.php'); ?>
    <?php } ?>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <?php echo $jsLibSkeleton; ?>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
	<!-- Script EventS (php generated) -->
	<script type="text/javascript">
		$(document).ready(function(){	
			<?php echo $jsSkeleton; ?>
		});
	</script>
  </body>
</html>