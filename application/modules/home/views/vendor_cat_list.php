<?php
        $frontend_assets =  base_url().'frontend_asset/';
        
  if(!empty($vendor_list)){
    foreach($vendor_list as $ven){ ?>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <li class="product-category product first">
            <a href="<?php echo site_url(); ?>home/users/vendorProfile/<?php echo encoding($ven->id); ?>">
                <img src="<?php echo $ven->user_image; ?>" />
                <div class="detail-cat">
                    <h2 class="woocommerce-loop-category__title">
                    <?php echo $ven->fullName; ?>
                    </h2><!--/woocommerce-loop-category__title-->
                    <p class="vendor-para-mrgn"><?php echo display_placeholder_text(substr($ven->address,0,20)); ?></p>
                    <div class="rate-chat rat_ven">
                        <div class="row"> 
                            <!--rate-->
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <div class="rating">
                                    <!-- show vendor ratings here--> 
                                         <?php
                                        $total_rating = intval($ven->rating); 
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
                            </div>
                            <!--chat-->
                            <div class="col-lg-5 col-md-5 col-sm-5 c-ic-level">
                                <a href="<?php echo site_url(); ?>home/users/chat/<?php echo encoding($ven->id);  ?>">
                                    <div class="chat-option">
                                        <img class="cht-sze" src="<?php echo $frontend_assets ?>img/chat1.png">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div><!--/rate-chat-->
                </div><!--/detail-cat-->
            </a>
        </li><!--/product-category product first-->
    </div>
<?php } }else{ ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="no-vndr-fnd">No vendor found</div>  
</div>

<?php  } ?>

<!--pagination-->
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="vendor-pagination">
            <div class="vendor-page">
                <?php echo $pagination; ?>
            </div><!--/vendor-page-->
        </div><!--/vendor-pagination-->
    </div>
</div>
<!--/pagination-->