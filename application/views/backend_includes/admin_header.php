<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_TITLE.' | Admin' ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
        $backend_assets =  base_url().'backend_asset/';
    ?>
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo $backend_assets ?>custom/images/tulia_logo_20x20.png" />
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>dist/css/AdminLTE.css">
  
  <!-- Material Design -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>dist/css/bootstrap-material-design.css">
  <link rel="stylesheet" href="<?php echo $backend_assets ?>dist/css/ripples.min.css">
  <link rel="stylesheet" href="<?php echo $backend_assets ?>dist/css/MaterialAdminLTE.css">
  <!-- MaterialAdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>dist/css/skins/skin-red.css">
  
  
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $backend_assets ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link href="<?php echo base_url(); ?>backend_asset/plugins/toastr/toastr.min.css" rel="stylesheet"> <!-- toastr popup -->
  <link href="<?php echo base_url(); ?>backend_asset/custom/css/admin_custom.css" rel="stylesheet">
    <?php  if(!empty($admin_styles)) load_admin_css($admin_styles);  //load required page styles  ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-red sidebar-mini" id="tl_admin_main_body" data-base-url="<?php echo base_url(); ?>">
<div class="wrapper">
<?php 
$fname = $this->session->userdata('fullName');
$image = $this->session->userdata('image');
$admin_img = base_url().ADMIN_IMAGE_PATH. $image;
$default_user_img = base_url().USER_DEFAULT_AVATAR;
?>
  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">T<b>U</b>L</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Tulia</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url().ADMIN_IMAGE_PATH. $image; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $fname ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url().ADMIN_IMAGE_PATH. $image; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $fname ?> <br> <small>Tulia Admin</small>
                  <small>Member since Nov. 2017</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url()?>admin/Profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="javascript:;" class="btn btn-default btn-flat" onclick="logout()">Log out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
          <div class="image" style="text-align:center">
          <img src="<?php echo base_url() ?>backend_asset/custom/images/tulia_logo_40x40.png" class="img-circle" alt="User Image">
        </div>
        
      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
          
        <li class="<?php echo (strtolower($this->router->fetch_class()) == "admin") && (strtolower($this->router->fetch_method()) != "about_us" ) ? "active" : "" ?>" >
          <a href="<?php echo site_url('admin'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        
        <li class="treeview <?php echo (strtolower($this->router->fetch_class()) == "users" || strpos($parent , "UA") !== false || strpos($parent , "UH") !== false) ? "active" : "" ?>" >
          <a href="#">
            <i class="fa fa-user"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li class="<?php echo ($parent=="all_users") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users'); ?>"><i class="fa fa-users"></i> All users</a></li> -->
            <li class="<?php echo ($parent=="users") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=user'); ?>"><i class="fa fa-user"></i> Users</a></li>
            <li class="<?php echo ($parent=="vendor") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=vendor'); ?>"><i class="fa fa-briefcase"></i> Vendors</a></li>
          </ul>
        </li>
        
        <li class="<?php echo (strtolower($this->router->fetch_class()) == "category") ? "active" : "" ?>" >
          <a href="<?php echo site_url('admin/category'); ?>">
            <i class="fa fa-share-alt"></i> <span>Categories</span>
          </a>
        </li>
        
        <li class="<?php echo (strtolower($this->router->fetch_class()) == "posts") ? "active" : "" ?>" >
          <a href="<?php echo site_url('admin/posts'); ?>">
            <i class="fa fa-file-text"></i> <span>Posts</span>
          </a>
        </li>
       
       <li class="<?php echo (strtolower($this->router->fetch_class()) == "events") ? "active" : "" ; ?>" >
          <a href="<?php echo site_url('admin/events'); ?>">
            <i class="fa fa-birthday-cake"></i> <span>Event category</span>
          </a>
        </li>

        <li class="<?php echo (strtolower($this->router->fetch_method()) == "about_us") ? "active" : "" ; ?>" >
          <a href="<?php echo site_url('admin/about_us'); ?>">
            <i class="fa fa-list-alt"></i> <span>About Us</span>
          </a>
        </li>

        <li class="<?php echo (strtolower($this->router->fetch_class()) == "feedback") ? "active" : "" ; ?>" >
          <a href="<?php echo site_url('admin/feedback'); ?>">
            <i class="fa fa-comments"></i> <span>Feedback</span>
          </a>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>