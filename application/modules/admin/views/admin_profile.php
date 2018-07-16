<style type="text/css">
    .detail{
        padding-left: 18px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    
        Admin Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Admin profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
        <?php //pr($admin); ?>
        <!-- Profile Image -->
          <div class="box box-primary"> 
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().ADMIN_IMAGE_PATH. $admin['image']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo ucfirst($admin['fullName']); ?></h3>

              <!-- <p class="text-muted text-center">Software Engineer</p> -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>

              <p class="text-muted detail"><?php echo $admin['email']; ?></p>

              <hr>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <!-- <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
              <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
              <li class="active"><a href="#settings" data-toggle="tab">Profile</a></li>
              <li><a href="#changePassword" data-toggle="tab">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="POST" action="<?php echo base_url('admin/updateProfile') ?>">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="fullName" id="inputName" placeholder="Name" value="<?php echo $admin['fullName']; ?>" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" value="<?php echo $admin['email']; ?>" readonly >
                    </div>
                  </div>
                 <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Image</label>

                    <div class="col-sm-10">
                      <input class="form-control" type="text" placeholder="Browse..." readonly="">
                      <input type="file" accept="image/*" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" name="image" id="inputSkills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-danger update_admin_profile">Update</button>
                    </div>
                  </div>
                </form>
              </div>

                
              <!-- /.tab-pane -->

                <div class="tab-pane" id="changePassword">
                <form class="form-horizontal" method="POST" action="<?php echo base_url('admin/changePassword') ?>">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Current Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="password" id="inputName" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="npassword" id="inputEmail" >
                    </div>
                  </div>
                   <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Retype New Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="rnpassword" id="inputEmail" >
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-danger change_password">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->



            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>