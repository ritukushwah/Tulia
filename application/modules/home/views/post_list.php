<?php $i = 2; foreach($post_detail as $rows){  ?>
<a href="<?php echo site_url(); ?>home/posts/postDetail/<?php echo encoding($rows['id']); ?>">
    <div class="row mrgn-pst-btm">
                <!--first post-->
            <?php if($i%2 == 1){ ?>
            <div class="cal bck-clr col-lg-8 col-lg-offset-2 col-md-12 col-xs-12 mdl">
            <?php }else {?>
            <div class="cal bck-clr col-lg-8 col-lg-offset-2 col-md-12 col-xs-12">
             <?php   } ?>
                <?php if($i%2 == 1){ ?>
                    
                    <!--detail my post sectn-->
                     <div class="cal col-xs-12 col-sm-3">
                        <div class="frame padding-left">
                            <img src="<?php echo $rows['cat_image']; ?>" />
                        </div><!--/frame padding-left-->
                    </div>  
                 <?php   } ?>
        
            <div class="cal col-xs-12 col-sm-9">
                <div class="my-post-detail fir-evn">
                    <div class="dte-tme">
                        <?php echo $rows['event_date']; ?>
                    </div><!--/dte-tme-->
                    <div class="my-pst-hd">
                         <?php echo $rows['category_name']; ?><span>- <?php echo $rows['event_name']; ?></span>
                    </div><!--/my-pst-hd-->           
                    <div class="post-decrtn">
                        <?php echo substr($rows['address'],0,20); ?>
                    </div><!--/post-decrtn-->  
                    <div class="intstd-vndr">
                        <h6>Interested Vendor:<span><?php echo $rows['interested_count']; ?></span></h6>
                    </div><!--/intstd-vndr-->          
                </div><!--/my-post-detail-->
            </div>
            <!--image sectn post-->
           <?php if($i%2 == 0){ ?>
            <div class="cal pad-rgt col-xs-12 col-sm-3">
                <div class="frame">
                    <img src="<?php echo $rows['cat_image']; ?>" />
                </div><!--/frame-->
            </div>
            <?php   } ?>
        </div>
    </div>
</a>
<?php $i++; } ?>

<!--pagination-->
<div class="row">
    <div class="col-lg-8 col-md-12 col-lg-offset-2 col-sm-12">
        <div class="vendor-pagination">
            <div class="vendor-page pagi-brdr">
                <?php echo $pagination; ?>
            </div><!--/vendor-page-->
        </div><!--/vendor-pagination-->
    </div>
</div>
<!--/pagination-->



