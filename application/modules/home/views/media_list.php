<?php  foreach($album_list as $rows){ ?>

<input type="hidden" id="mediaId<?php echo $rows->id?>" value='<?php echo json_encode($rows); ?>'>
<!-- <div onclick="showPopData('mediaId'+<?php echo $rows->id?>)" class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> -->
<div onclick="showPopData(<?php echo $rows->id?>)" class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
   <div class="media-blck">
      <!--design of blocks media-->        
      <div class="media-blck-img">
         <!--/media-ovr-img-->
         <!--/media-blck-img-->
         <div class="media-caro owl-carousel owl-theme">
            <?php foreach($rows->album_attachments as $img){ ?>
            <div class="item"><img class="media-ovr-img" src="<?php echo $img->album_image; ?>" /></div>
            <?php } ?>
         </div>
      </div>
      <!--blck-content-detl-->
      <a href="javascript:void(0)">
         <div class="media-cont">
            <div class="cont-head-date">
               <div class="cont-head">
               <?php 
                $string = strip_tags($rows->album_title);
                /*if (strlen($string) > 15) {
                    $stringCut = substr($string, 0, 15);
                    $endPoint = strrpos($stringCut, ' ');
                    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                    
                }*/
              ?>
                  <h6><?php echo  substr($string,0,15); ?></h6>
               </div>
               <!--/cont-head-->
               <div class="cont-date">
                  <p><?php echo $rows->time_elapsed?></p>
               </div>
               <!--/cont-date-->
            </div>
            <!--/cont-head-date-->
            <div class="media-descptn">


              <?php 
                $string1 = strip_tags($rows->album_description);
                /*if (strlen($string1) > 100) {
                    $stringCut1 = substr($string1, 0, 100);
                    $endPoint1 = strrpos($stringCut1, ' ');
                    $string1 = $endPoint1? substr($stringCut1, 0, $endPoint1):substr($stringCut1, 0);
                    
                }*/
              ?>

               <p><?php echo substr($string1,0,70); ?></p>
            </div>
            <!--/media-descptn-->
         </div>
         <!--/media-cont-->
      </a>
      <!--/media-blck-->
      <!--/end design of blocks media-->
   </div>
</div>
</div> 
<?php } ?>     
<!--pagination-->
<div class="row">
   <div class="col-lg-8 col-md-12 col-sm-12">
      <div class="vendor-pagination">
         <div class="vendor-page">
            <?php echo $pagination; ?>
         </div>
         <!--/vendor-page-->
      </div>
      <!--/vendor-pagination-->
   </div>
</div>
<!--/pagination-->
<script type="text/javascript">
      $('.media-caro').owlCarousel({
    autoplay:true,
    autoplayHoverPause:true,
    smartSpeed:3000,
    loop:true,
    margin:10,
    nav:true,
    dots:true,
    mouseDrag:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>