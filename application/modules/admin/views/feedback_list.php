<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo site_url('admin/posts');?>">Posts</a></li>
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
               

              <table id="feedback_list" class="table table-bordered table-striped">
                <thead>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th style="width: 12%">Action</th>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
                
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
 