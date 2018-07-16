
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Vendor Categories
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo site_url('admin/category');?>">Category</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->
        <div class="box-header">
            <div class="row">
                <div class="col-xs-2" style="float:right">
                    <button type="button" class="btn btn-primary btn-raised btn-block" onclick="open_modal('admin/category')">Add Category 
                    </button>
                </div>
                <!-- <div class="pull-left div-select col-md-3 ">
                    <select name="id" class="form-control" id="status"> 
                        <option value ="">---Select Category---</option>            
                        <?php foreach($catList as $val){?>
                        <option value="<?php echo $val->id;?>"><?php echo $val->name;?></option>
                        <?php } ?>                              
                    </select>
                </div> -->
            </div>
            <div class="box" id="ajaxdata">    
            <!-- /.box-header -->
            </div>
            <!-- /.box -->
        </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<div id="form-modal-box"></div>
<script language="JavaScript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<script type="text/javascript">
    ajax_func('<?php echo base_url()."admin/category/singleCategory"; ?>');
    function ajax_func(url)
    {   
        $.ajax({
            url: url,
            type: "POST",
            data:{page: url},              
            cache: false,   
            beforeSend: function() {
                $("#hb_admin_loader").show(); 
            },                          
            success: function(data){ 
                $("#hb_admin_loader").hide(); 
                $("#ajaxdata").html(data);
            }
        });

    }

</script>