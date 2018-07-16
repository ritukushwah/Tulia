
<?php
        $frontend_assets =  base_url().'frontend_asset/';

?>
<!--section-->
<section id="nt-found" class="sectn-pad2">
	<div class="container">
		<div class="nt-fnd-sec">
			<div class="nt-fnd-icn">
				<img src="<?php echo $frontend_assets ?>img/404-icn.png" />
			</div><!--/nt-fnd-icn-->
			<div class="pge-nt-fnd">
				Page Not Found!
			</div><!--/pge-nt-fnd-->
			<div class="pge-nt-fnd-para">
			<p>Oops The page You were looking for doesn't exist</p>
			<p class="pgr-pr">You may have mistyped the address or the page may have moved</p>			
			</div>
			<div class="pgr-num-tet">
				404
			</div><!--/pgr-num-tet-->
			<div class="btn-nt-fnd">
				<div class="btn-fn"><a href="javascript:void(0)"><button type="button" onclick="goBack()" class="m-btn sbmt-btn no-pst-btn">Go Back</button></a></div><!--/btn-fn-->
			</div>
		</div><!--/nt-fnd-sec-->
	</div>
</section>

<script type="text/javascript">
	function goBack() {
        window.history.back();
    }
</script>