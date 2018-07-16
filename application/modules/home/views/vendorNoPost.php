<?php
        $frontend_assets =  base_url().'frontend_asset/';
?> 
<!--no postsection-->
<section id="no-post" class="sec-pad">
  <div class="container">
    <div class="row mrgn-btm">
      <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
        <div class="row mrgn-btm">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="no-post-text">
            <div class="post-img">
              <img src="<?php echo $frontend_assets ?>img/no-post-icn.png" alt="Image" />
            </div><!--/post-img-->
            <div class="currently">
              <p><?php echo $title; ?></p>
            </div><!--/currently-->
            <div class="no-post-para">
              <p><?php echo $description; ?></p>
            </div><!--/no-post-para-->            
          </div><!--/no-post-text-->
        </div>
      </div>
      </div>      
    </div>
      
  </div>
</section>
