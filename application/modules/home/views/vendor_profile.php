
<!--vendor profile page-->
<section id="profile-vndr" class="sectn-pad">
    <div class="row">
        <div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
            <!--vendor profile sectn-->
            <div class="container">
                <div class="row vertical-align prfl-vndr-ver">
                    <!--left side portion vendor profile page-->
                    <div class="col-md-5 col-sm-12 col-xs-12" style="background-image: url(<?php echo $vendorData->cat_image; ?>);">
                        <!--vendor profile info-->
                        <div class="left-prfle-prt rounded-prt">
                            <div class="lft-img-prt">
                                <?php $img = (!empty($vendorData->image))? (filter_var($vendorData->image, FILTER_VALIDATE_URL))? $vendorData->image : base_url().USER_AVATAR_PATH.$vendorData->image: base_url().USER_DEFAULT_AVATAR;
                                ?>
                                <div class="prfle-imge">
                                    <img src="<?php echo $img; ?>" alt="Image" />
                                </div><!--/prfle-imge-->
                                <!--/img prt-->
                                <!--detail user part-->
                                <div class="usr-dtl-prt pdng-btm-vndr">
                                    <h5><?php echo display_placeholder_text($vendorData->fullName) ; ?></h5>
                                    <p><?php echo display_placeholder_text($vendorData->category_name); ?></p>
                                </div><!--/usr-dtl-prt-->
                                <div class="rate-eye">
                                    <?php if(!empty($vendorData->rating)){ ?>
                                        <div class="rating pdng-btm-vndr-rate vndr-prfle-rt">
                                    <?php }else{ ?>
                                        <div class="rating pdng-btm-vndr-rate vndr-prfle-eyeV">
                                        <?php } 
                                            $total_rating = intval($vendorData->rating); 
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
                                        </p> 
                                    </div>
                                    <?php if(!empty($vendorData->rating)){ ?>
                                     <a href="<?php echo site_url(); ?>home/users/vndrReview/<?php echo encoding($vendorData->id); ?>">
                                        <div class="eye-icn">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    </a>
                                    <?php } ?>
                                </div>

                            </div><!--/lft-img-prt-->
                        </div><!--/left-prfle-prt-->
                    </div>
                    <!--right side portion vendor profile page-->
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <!--vendor profie detail-->
                        <div class="user-prfl-">
                            <!--budget-->
                            <!--price-->
                            <div class="rgt-sec">
                                <div class="rgt-lft-head rgt-lft-head-mble">
                                    Price
                                </div><!--/rgt-lft-head-->
                                <div class="rgt-rgt-head rgt-rgt-head-mble">
                                    <?php echo display_placeholder_text($vendorData->price.''.$vendorData->currency_symbol); ?>
                                </div><!--/rgt-rgt-head-->
                            </div><!--/rgt-sec-->
                            <!--email-->
                            <div class="rgt-sec">
                                <div class="rgt-lft-head rgt-lft-head-mble">
                                    Email
                                </div><!--/rgt-lft-head-->
                                <div class="rgt-rgt-head rgt-rgt-head-mble">
                                    <?php echo display_placeholder_text($vendorData->email); ?>
                                </div><!--/rgt-rgt-head-->
                            </div><!--/rgt-sec-->
                            <!--phone number-->
                            <div class="rgt-sec">
                                <div class="rgt-lft-head rgt-lft-head-mble">
                                    Contact Number
                                </div><!--/rgt-lft-head-->
                                <div class="rgt-rgt-head rgt-rgt-head-mble">
                                    <?php echo display_placeholder_text($vendorData->contactNumber); ?>
                                </div><!--/rgt-rgt-head-->
                            </div><!--/rgt-sec-->
                            <!--location-->
                            <div class="rgt-sec">
                                <div class="rgt-lft-head usr_city">
                                    City
                                </div><!--/rgt-lft-head-->
                                <div class="rgt-rgt-head usr_city1">
                                    <?php echo display_placeholder_text($vendorData->address); ?>
                                </div><!--/rgt-rgt-head-->
                            </div><!--/rgt-sec-->
                            <!--description-->
                            <div class="descptn">
                                <h5>Description</h5>
                                <p><?php echo display_placeholder_text($vendorData->description); ?></p>
                            </div>
                            <!--View media-->
                            <a href="<?php echo base_url('home/users/vendorMedia');?>">
                                <div class="rgt-sec">
                                    <div class="rgt-lft-head">
                                        View Media
                                    </div><!--/rgt-lft-head-->
                                    <div class="rgt-rgt-head arrow">
                                        <i class="fa fa-chevron-right"></i>
                                    </div><!--/rgt-rgt-head-->
                                </div>
                            </a><!--/rgt-sec-->
                            <?php if(empty($vendorData->socialId && $vendorData->socialType)) {?>
                            <!--change password-->
                            <a href="#" data-toggle="modal" data-target="#exampleModal5">
                                <div class="rgt-sec">
                                    <div class="rgt-lft-head">
                                        Change password
                                    </div><!--/rgt-lft-head-->
                                    <div class="rgt-rgt-head arrow">
                                        <i class="fa fa-chevron-right"></i>
                                    </div><!--/rgt-rgt-head-->
                                </div>
                            </a><!--/rgt-sec-->
                            <?php } ?>
                            <!--edit and logout btn-->
                            <div class="bth-btn">
                                <div class="btn-prf"><a href="<?php echo site_url(); ?>home/users/editProfile"><button type="button" class="m-btn sbmt-btn">Edit</button></a></div><!--/btn-prf-->
                               <div class="btn-prf lgout"><a href="<?php echo site_url(); ?>home/logout"><button type="button" class="m-btn sbmt-btn lgout">Log Out</button></a></div><!--/btn-prf-->
                            </div><!--/bth-btn-->
                        </div>
                    </div>        
                </div>
            </div>
            <!--vendor profile sectn-->
        </div>
    </div>
</section><!--/profile-vndr-->
<!--/vendor profile page-->
<!-- Modal -->
<div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <form method="POST" id="update_password" role="form" action="<?php echo base_url('home/users/changePassword') ?>">
            <div class="modal-content">
                <div class="modal-header bg-img">
                    <div class="frgt-head">
                        Change Password
                    </div><!--/frgt-head-->
                </div>
                <div class="modal-body modal-frgt-body chng-psswrd">
                    <div class="container">
                            <div class="form-group lin-hgt chngr-hgt">
                                <label class="fnt-wt">Current Password</label>
                                <input class="form-control" id="password" name="password" placeholder="" type="password">
                            </div><!--/form-group-->
                            <div class="form-group lin-hgt chngr-hgt">
                                <label class="fnt-wt">New Password</label>
                                <input class="form-control" id="npassword" name="npassword" placeholder="" type="password">
                                </div><!--/form-group-->
                            <div class="form-group lin-hgt chngr-hgt">
                                <label class="fnt-wt">Confirm Password</label>
                                <input class="form-control" id="rnpassword" name="rnpassword" placeholder="" type="password">
                            </div><!--/form-group-->
                        </div>
                </div><!--/modal-frgt-body-->
                 <div class="container">
                    <div class="modal-footer brdr-top">
                        <a href="javascript:void(0)"><button type="button" class="btn btn-primary m-btn change_password">Update</button></a>
                    </div>                                                                      
                </div>
                <div class="bck-arrow-clr">
                    
                    <div class="arrow-bck close float" data-dismiss="modal" >
                        <i class="bck fa fa-arrow-left"></i><span> Back</span>
                    </div>
                 
                </div><!--/bck-arrow-clr-->         
            </div>
        </form>f
    </div>
</div>
<!--/forget password end-->





