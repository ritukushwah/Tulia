
<?php $frontend_assets =  base_url().'frontend_asset/';
     if(!empty($realated_vendor)){ ?>
     <div class="owl-carousel owl-theme" id="rel-vend-slider">
    <?php foreach ($realated_vendor as $rows) { ?>
    <div class="item">
<a href="<?php echo site_url(); ?>home/users/vendorProfile/<?php echo encoding($rows->id); ?>">
    <div class="related-vendors-sec sec-pad2">           
        <!--related vendors item-->
        <div class="related-item-1">
            <div class="related-item ven_img">
                <img src="<?php echo $rows->user_image; ?>" alt="Image" />
            </div><!--/related-item-->
            <!--related vendors info-->
            <div class="related-info">
                <?php echo  display_placeholder_text($rows->fullName); ?>         
            </div><!--/related-info-->
            <div class="profile-list rltd-vndr flot-add">
                <i class="fa fa-map-marker prfl-icn"></i>
                <span> <?php echo display_placeholder_text($rows->address); ?>      </span>
            </div><!--/profile-list-->
            <div class="rating prfle-vendor reltd-rate">
                <!-- show vendor's review here -->
                       <?php
                        $total_rating = intval($rows->rating); 
                        for($i=5; $i >= 1; $i--){
                    ?>   
                        <?php
                         if($total_rating < $i){
                        ?>
                        
                            <i class="fa fa-star rating_color" aria-hidden="true"></i>
                        <?php }else{  ?>
                            
                            <font color="orange"><i class="fa fa-star " aria-hidden="true" ></i></font>
                        <?php }  ?>
                    <?php 
                        } 
                    ?>
                    

            </div>
        </div><!--/related-item-1-->          
    </div>
</a><!--/related-vendors-sec-->
</div>
<?php } ?> </div>  <?php }else{ ?>

    <!--no related vendors-->
        <div class="related-vendors-sec sec-pad2">           
          <!--related vendors item-->
           <div class="related-item-1">
                <div class="related-item no-item">
                  <img src="<?php echo $frontend_assets ?>img/user-img2.png" alt="Image" />
                </div><!--/related-item-->
                <!--related vendors info-->
                <div class="related-info">
                    No Related Vendor Available            
                </div><!--/related-info-->
            </div><!--/related-item-1-->          
        </div><!--/related-vendors-sec-->
        <!--/no related vendors-->

 <?php } ?>


<script type="text/javascript">

    var owl = $('#rel-vend-slider');
    owl.owlCarousel({
        items:1,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:false
    });

</script>
