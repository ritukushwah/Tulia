<style type="text/css">
    span.destext {
    display: block;
    margin-top: 5px;
}
.detail{
            padding-left: 18px;
    }

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo site_url('admin/posts');?>">Posts</a></li>
        <li class="active">Post details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php  echo $this_post->user_image ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this_post->fullName ?></h3>

              <p class="text-muted text-center"><?php echo ucfirst($this_post->userType) ?></p>
              

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
              <strong><i class="fa fa-envelope" aria-hidden="true"></i></i> Email</strong>
              <p class="text-muted detail">
              <?php echo display_placeholder_text($this_post->email); ?></p>

              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
              <p class="text-muted detail">
              <?php echo display_placeholder_text($this_post->user_address); ?></p>
              
              <hr>
              <strong><i class="fa fa-phone" aria-hidden="true"></i></i> Contact Number</strong>
              <p class="text-muted detail">
              <?php echo display_placeholder_text($this_post->user_contact_number); ?></p>
              
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom" id="post_details_nav" data-post-id="<?php echo $current_post_id; ?>">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab">Post Details</a></li>
                <li><a href="#interested" data-toggle="tab">Interested Vendors</a></li>
<!--              <li><a href="#settings" data-toggle="tab">Settings</a></li>-->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                  
                 
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <div class="widget-user-image">
                <img class="img-circle" width="80" height="80" src="<?php echo $this_post->cat_image ?>" alt="<?php echo $this_post->category_name ?>">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $this_post->event_name ?></h3>
              <h5 class="widget-user-desc"><?php echo $this_post->category_name ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#"><b>Event Date </b><span class="pull-right  "><?php echo date("d M Y", strtotime($this_post->event_date)); ?></span></a></li>
                <li><a href="#"><b>Time </b><span class="pull-right  "><?php echo date("h:i a", strtotime($this_post->event_time)); ?></span></a></li>
                <?php if(!empty($this_post->budget_to)){?>
                <li><a href="#"><b>Budget </b><span class="pull-right  "><?php echo $this_post->currency_symbol.' '.$this_post->budget_from.' - '.$this_post->budget_to; ?></span></a></li> <?php }else{ ?>
                 <li><a href="#"><b>Budget </b><span class="pull-right  "><?php echo $this_post->currency_symbol.' '.$this_post->budget_from; ?></span></a></li>
                <?php    } ?>
                <li><a href="#"><b>Number of Guests </b><span class="pull-right  "><?php echo $this_post->guest_number ?></span></a></li>
                 
                 <li><a href="#"><b>Venue </b><span class="pull-right  "><?php echo $this_post->address ?></span></a></li>
                 <li><a href="#"><b>Description </b><span class="destext"><?php echo $this_post->description ?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
       
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="interested">
                <!-- The timeline -->
                <table id="doing_users_list" class="table table-bordered table-striped">
                <thead>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th style="width: 12%">Action</th>
                </thead>
                <tbody>
                    
                </tbody>
               
              </table>
              </div>
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

