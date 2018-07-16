<?php
  
        $frontend_assets =  base_url().'frontend_asset/';
?>
<!--my post detail page-->
<section id="mypst-dtl" class="sectn-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <!--left side-->
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                            <!--date sec-->
                            <div class="gdlr-standard-style">
                                <div class="blog-date-wrapper gdlr-title-font">
                                    <i class="fa fa-calendar"></i>
                                    
                                    <div class="blog-date-day"><?php echo date('d', strtotime($post_detail->event_date)); ?></div>
                                    <div class="blog-date-month"><?php echo date('M', strtotime($post_detail->event_date)); ?></div>
                                    <div class="blog-date-year"><?php echo date('Y', strtotime($post_detail->event_date)); ?></div>
                                </div><!--/blog-date-wrapper gdlr-title-font-->
                                <!--img section-->
                                <div class="blog-content-wrapper">
                                    <div class="gdlr-blog-thumbnail">
                                        <img src="<?php echo $post_detail->cat_image; ?>" />
                                    </div><!--/gdlr-blog-thumbnail-->
                                    <!--heading-->
                                    <div class="blog-content-inner-wrapper">
                                        <header class="post-header">
                                            <h3 class="gdlr-blog-title">
                                               <?php echo $post_detail->category_name; ?><span>- <?php echo $post_detail->event_name; ?></span>
                                            </h3>
                                        <div class="edit-dlte-mypst-dtl edit-dlte-mypst-dtl-mble">
                                                <a href="<?php echo site_url(); ?>home/posts/editPost/<?php echo encoding($post_detail->id); ?>"><span class="fa fa-edit"></span></a>
                                                <a href="#"  data-toggle="modal" data-target="#delete_modal"><span class="fa fa-trash"></span></a>
                                            </div><!--/edit-dlte-mypst-dtl-->
                                            <!--other info-->
                                            <div class="detl-info">
                                               <span><i class="fa fa-clock-o"></i><?php echo date('h:i A', strtotime($post_detail->event_time)); ?></span>
                                                <span>/</span>
                                                <span><i class="fa fa-user"></i><b>No.of Guest :</b><?php echo $post_detail->guest_number; ?></span>
                                                <span>/</span>
                                                <span class="pdng-spn"><b>Budget :</b><?php echo $post_detail->budget_from.' - '.$post_detail->budget_to.'  '.$post_detail->currency_symbol; ?></span>
                                                <span>/</span>
                                                <span class="pdng-spn"><i class="fa fa-phone"></i><?php echo $post_detail->contact_number; ?></span>
                                                <span>/</span>
                                                <span class="pdng-spn"><i class="fa fa-map-marker"></i><?php echo $post_detail->address; ?></span>
                                            </div><!--/detl-info-->
                                            <!-- <div class="detl-info">
                                                
                                            </div> --><!--/detl-info-->                    
                                        </header><!--/post-header-->
                                        <!--detail description-->
                                        <div class="dtail-dscrptn">
                                            <p><?php echo $post_detail->description; ?></p>
                                        </div><!--/dtail-dscrptn-->
                                    </div><!--/blog-content-inner-wrapper-->
                                </div><!--/blog-content-wrapper-->
                            </div><!--/gdlr-standard-style-->
                        </div>
                        <!--info detail head-->        
                    </div>
                    <!--right side-->

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="intrs-vndr-lst-pst">
                            <div class="intr-head">
                                Interested Vendor
                            </div><!--/intr-head-->
                            <div class="bck-wht-clr">
                                <?php 
                                if(!empty($doing_users)){

                                    foreach ($doing_users as $user) { ?>
                                    
                                        <!--vendor list item start-->
                                        <a href="<?php echo site_url(); ?>home/users/vendorProfile/<?php echo encoding($user->id); ?>">
                                            <div class="vndr-img-hd">
                                            <?php $img = (!empty($user->image))? (filter_var($user->image, FILTER_VALIDATE_URL))? $user->image : base_url().USER_AVATAR_PATH.$user->image: base_url().USER_DEFAULT_AVATAR;
                                                        ?>
                                                <div class="vndr-img-sec">
                                                    <img src="<?php echo $img; ?>" />
                                                </div><!--/vndr-img-sec-->
                                                <div class="vndr-lst-name-add">
                                                    <h6><?php echo $user->fullName; ?></h6>
                                                    <p><?php if(!empty($user->address)) {echo substr($user->address,0,20); } ?></p>
                                                </div><!--/vndr-lst-name-add-->
                                                <a href="<?php echo site_url(); ?>home/users/chat/<?php echo encoding($user->id);  ?>">
                                                    <div class="vndr-cmnt">
                                                        <img class="cht-sze" src="<?php echo $frontend_assets ?>img/chat1.png">
                                                    </div>
                                                </a><!--/vndr-cmnt-->
                                            </div><!--/vndr-img-hd-->
                                        </a>
                                        <!--vendor list item end-->
                                   
                                <?php } }else{ ?>
                                <div class="no-vnrd">
                                    <p>No vendor interested now</p>
                                </div>
                                <?php  } ?>
                             </div><!--/bck-wht-clr-->
                        </div><!--/intrs-vndr-lst-pst-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</section><!--/mypst-dtl-->
<!--/end of my post detail page-->


<!--delete pop up-->
 <!-- Modal -->
      <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog frgt-pswd" role="document">
          <div class="modal-content">
            <div class="modal-header bg-img">
              <div class="frgt-head">
                Delete
              </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
              <div class="container">
                <div class="dlte-cnfrmtn">
                  Are you sure you want to delete this post ?
                </div>
              </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
              <div class="modal-footer brdr-top">
              <button type="button" onclick="deleteFunc('<?php echo$post_detail->id; ?>','home/posts/','deletePost')" class="btn btn-primary del_btn">Yes</button>
               
              </div>                                                                      
            </div>
            <div class="bck-arrow-clr">
                  <div class="arrow-bck close float" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Back</span>
                  </div>
            </div><!--/bck-arrow-clr-->         
          </div>
        </div>
      </div>
<!--end of delete pop up-->

