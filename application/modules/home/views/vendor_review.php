 
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="prfle-review">
      <ul>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <!--write review btn-->
                <div class="write-review-btn">
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal3">
                      <button type="button" class="m-btn">Write Your review</button>
                  </a>
                </div><!--/write-review-btn-->
            </div>
          </div>
          <?php $frontend_assets =  base_url().'frontend_asset/';
          if(!empty($user_reviews)){
           foreach ($user_reviews as $value) { ?>
        <li>
          <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
              <div class="prfle-rev-img">
                <img src="<?php echo $value->user_image; ?>" alt="Image" />
              </div><!--/prfle-rev-img-->
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10">
              <div class="prfl-review-detail">
                <div class="head-rate">
                    <div class="prfle-vendr-name">
                      <?php echo $value->fullName; ?>
                    </div><!--/prfle-vendr-name-->
                    <div class="rating prfle-vendor">


                    <?php 
                        $total_rating = intval($value->rating); 
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
                  </div><!--/head-rate-->
                <!--time of review-->
                <div class="time-review">
                  <?php echo date('d'.' '.'M'.' '.'Y', strtotime($value->created_on)); //$value->time_elapsed;   ?>
                  
                </div><!--/time-review-->
                <div class="review-para">
                  <?php echo $value->review_description; ?>
                </div><!--/review-para-->
              </div><!--/prfl-review-detail-->
            </div>
          </div>
        </li>
        <?php } }else{ ?>
        <div class="no-media-sec">
    <div class="no-media-icn">
        <img src="<?php echo $frontend_assets ?>img/no-revw.png" alt="Image" width="80px" />
    </div><!--/no-media-icn-->
    <div class="no-mdia-text">
        No Review Available
    </div><!--/no-mdia-text-->
</div><!--/no-media-sec-->
          <?php  } ?>
      </ul>  
    </div><!--/prfle-review-->
                 
  </div>
</div>

<!--pagination-->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="vendor-pagination">
                <div class="vendor-page pagi-brdr">
                    <?php echo $pagination; ?>
                </div><!--/vendor-page-->
            </div><!--/vendor-pagination-->
        </div>
    </div>
    <!--/pagination-->

