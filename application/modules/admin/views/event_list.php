<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo site_url('admin/events');?>">Events</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->
        <div class="box-header">
            <div class="col-xs-2" style="float:right">
                <button type="button" class="btn btn-primary btn-raised btn-block" onclick="open_modal('admin/events')">Add Event
                </button>
            </div>
        </div>


          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
               <!-- <input type="text" name="event_date" placeholder="Pick date" class="form-control" id="datepicker" data-date-format='yyyy-mm-dd'> -->
              <table id="event_list" class="table table-bordered table-striped">
                <thead>
                <th style="width: 15%">S.No.</th>
                <th>Event Name</th>
                <th style="width: 25%">Action</th>
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
<script>
  
</script>