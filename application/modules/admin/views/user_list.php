<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
       <!--  <li class="active"><a href="<?php echo site_url('admin/users');?>">Users</a></li> -->
        <li class="<?php echo ($parent=="users") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=user'); ?>">Users</a></li>
            <li class="<?php echo ($parent=="vendor") ? "active" : "" ?>"><a href="<?php echo site_url('admin/users/?userType=vendor'); ?>">Vendors</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
                <?php if (!empty($userList)):  ?>
              <table id="user_list" class="table table-bordered table-striped" data-user-type="<?php echo $user_type; ?>">
                <thead>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <?php if($parent=="vendor"){?>
                <th>Category</th>
                <?php } ?>
                <th>Status</th>
                <th>Avatar</th>
                <th style="width: 12%">Action</th>
                </thead>
                <tbody>
                    
                </tbody>
               
                </tfoot>
              </table>
                <?php 
                else:
                    echo '<h3>No record found</h3>';
                endif; ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
   <div id="form-modal-box"></div>
<script>
  
</script>