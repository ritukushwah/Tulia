<style type="text/css">
    .detail{
            padding-left: 15px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if($userDetail->userType == 'vendor'){ ?>
            Vendor Profile
        <?php   }else{ ?>
        User Profile <?php } ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="<?php echo ($parent=="users") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=user'); ?>">Users</a></li>
            <li class="<?php echo ($parent=="vendors") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=vendor'); ?>"> Vendors</a></li>
        <!-- <li class="active">User profile</li> -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php  echo $userDetail->thumbImage ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $userDetail->fullName ?></h3>

              <p class="text-muted text-center"><?php echo ucfirst($userDetail->userType) ?></p>
              <p class="text-muted text-center">

              <?php 
                if($userDetail->userType == 'vendor'){
                //$total_rating = round($userDetail->rating,1);
                $total_rating = intval($userDetail->rating);  
                $left_rating = 5 - $total_rating;  

                for($i=1; $i<= $total_rating; $i++){ ?>
                    <font color="orange"><i class="fa fa-star" aria-hidden="true"></i></font>
                   
                <?php } 
                for($i=1; $i<= $left_rating; $i++ ){ ?>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                <?php } ?></p>
                <?php } ?>
              <!-- <p class="text-muted text-center"><?php echo ucfirst($userDetail->rating) ?></p> -->
     
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
              <?php if(!empty($userDetail->email)) {?>
              <strong><i class="fa fa-envelope" aria-hidden="true"></i> Email</strong>

              <p class="text-muted detail">
                <?php echo display_placeholder_text($userDetail->email); ?>
              </p>

              <hr>
              <?php } ?>
              <strong><i class="fa fa-phone" aria-hidden="true"></i> Contact Number</strong>

              <p class="text-muted detail">
                <?php echo display_placeholder_text($userDetail->contactNumber); ?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted detail" >
              <?php echo display_placeholder_text($userDetail->address); ?></p>
              
              <?php if($userDetail->userType=='vendor'){ ?>
              <hr>
              
              <strong><i class="fa fa-usd margin-r-5"></i> Price</strong>

               <p class="text-muted detail">
                   <?php echo display_placeholder_text($userDetail->price); ?>
              </p>

              <hr>

              <strong><i class="fa fa-file-text margin-r-5"></i> Description</strong>

              <p class="detail"><?php echo display_placeholder_text($userDetail->description); ?></p>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col --> 
        <div class="col-md-9">
          <div class="nav-tabs-custom" id="user_post_nav" data-user-id="<?php echo $userDetail->id; ?>" >
            <ul class="nav nav-tabs">
              <?php if($userDetail->userType == 'vendor'){ ?>
              <li class="active"><a href="#activity" data-toggle="tab">My Events</a></li>
              <?php }else{ ?>
              <li class="active"><a href="#activity" data-toggle="tab">My Posts</a></li>
              <?php } ?>
              <!-- <?php if($userDetail->userType == 'vendor'){ ?>
              <li><a href="#timeline" data-toggle="tab">Posts</a></li> 
              <?php } ?> -->
<!--              <li><a href="#settings" data-toggle="tab">Settings</a></li>-->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                
                <table id="my_post_list" class="table table-bordered table-striped">
                <thead>
                <th>S.No.</th>
                <th>Event</th>
                <th>Category</th>
                <th>Date</th>
                <th style="width: 12%">Action</th>
                </thead>
                <tbody>
                    
                </tbody>
                
              </table>
                 
              </div>
              <!-- /.tab-pane -->
              <?php if($userDetail->userType == 'vendor'){ ?>
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <table id="post_list_data" class="table table-bordered table-striped">
                <thead>
                <th>S.No.</th>
                <th>Event</th>
                <th>Category</th>
                <th>Date</th>
                <th style="width: 12%">Action</th>
                </thead>
                <tbody>
                    
                </tbody>
                
              </table>
              </div>
              <?php } ?>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
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

