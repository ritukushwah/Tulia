
<?php $frontend_assets =  base_url().'frontend_asset/'; ?>
<section id="my-evnts" class="sectn-pad2">
   <input type="hidden" id="totalCount" value="<?php echo $total; ?>">
  <div class="container">
    <!--start of my event listing-->
    <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12">
     <div id="apndDAta"></div>
      
    </div>
  </div>
</section><!--/my-evnts-->



<script type="text/javascript">

var url = base_url +"/home/Vendorpost/event";
pagination(url)
function pagination(url){
	var totalCount = $('#totalCount').val();
	$.ajax({
		url: url,
		type: "get",
		data: {totalCount:totalCount},
		cache: false,
		success: function(result) {
			$('#apndDAta').html(result)
		}
	});
}
</script>