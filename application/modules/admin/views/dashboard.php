
<style type="text/css">
    .info-box-icon i{
        padding-top: 20px;
    }
</style>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Welcome Admin
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
       
        <!-- /.col -->
        
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
              
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
              <a href="<?php echo site_url('admin/users/?userType=user');?>">
            <span class="info-box-icon bg-yellow"><i class="ion ion-android-person"></i></span>

            <div class="info-box-content">
                
              <span class="info-box-text">Total Users</span>
              <span class="info-box-number"><?php echo $this->common_model->get_total_count(USERS,array('userType'=>'user')); ?></span>
               
            </div>
            <!-- /.info-box-content -->
             </a>

          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

         <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
              <a href="<?php echo site_url('admin/users/?userType=vendor');?>">
            <span class="info-box-icon bg-orange"><i class="ion ion-ios-briefcase"></i></span>

            <div class="info-box-content">
                
              <span class="info-box-text">Total Vendor</span>
              <span class="info-box-number"><?php echo $this->common_model->get_total_count(USERS,array('userType'=>'vendor')); ?></span>
               
            </div>
            <!-- /.info-box-content -->
             </a>
             
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

         <div class="col-md-3 col-sm-6 col-xs-12">
         
          <div class="info-box">
              <a href="<?php echo site_url('admin/Category'); ?>">
            <span class="info-box-icon bg-blue"><i class="ion ion-android-share-alt"></i></span>

            <div class="info-box-content">
                
              <span class="info-box-text">Total Category</span>
              <span class="info-box-number"><?php echo $this->common_model->get_total_count(CATEGORIES) ?></span>
               
            </div>
            <!-- /.info-box-content -->
             </a>
          </div>
          <!-- /.info-box -->

        </div>

        
        <div class="col-md-3 col-sm-6 col-xs-12">
         
          <div class="info-box">
              <a href="<?php echo site_url('admin/posts'); ?>">
            <span class="info-box-icon bg-red"><i class="ion ion-document-text"></i></span>

            <div class="info-box-content">
                
              <span class="info-box-text">Total Post</span>
              <span class="info-box-number"><?php echo $this->common_model->get_total_count(POSTS) ?></span>
               
            </div>
            <!-- /.info-box-content -->
             </a>
          </div>
          <!-- /.info-box -->

        </div>

        



      </div>
      <!-- /.row -->

      
      <!-- /.row -->

      <!-- Main row -->
      
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper