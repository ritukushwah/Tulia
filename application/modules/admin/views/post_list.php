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
            <div class="pull-right col-md-3 noMargin">              
                    <input type="text" name="event_date" placeholder="Pick date" class="form-control" id="datepicker" data-date-format='yyyy-mm-dd'>
               </div>
                <div class="pull-right div-select col-md-3 noMargin">
                    <select name="id" class="form-control" id="cat_status"> 
                        <option value ="">---Select Category---</option>            
                        <?php foreach($catList as $val){ ;?>
                        <option value="<?php echo $val->id;?>"><?php echo $val->name;?></option>
                        <?php } ?>                              
                    </select>
                </div>
            <!-- /.box-header -->
            <div class="box-body">
               

              <table id="post_list" class="table table-bordered table-striped">
                <thead>
                <th>S.No.</th>
                <th>Event Name</th>
                <th>Category</th>
                <th>Date</th>
                <th>No. of guests</th>
                <th>Budget</th>
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
 