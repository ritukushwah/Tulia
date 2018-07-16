<!--profile page-->
<section id="my-profile">
    <div class="top-img">
        <!--template profile-->
        <div class="prfle-sctn sectn-pad">
            <!--flex-->
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
                        <div class="row vertical-align prfle-ver">
                            <!--left portion-->
                            <div class="col-xs-12 col-md-5 col-sm-12 col-xs-12">
                                <div class="left-prfle-prt">
                                    <div class="lft-img-prt">
                                        <div class="prfle-imge">
                                            <?php $img = (!empty($vendorData->image))? (filter_var($vendorData->image, FILTER_VALIDATE_URL))? $vendorData->image : base_url().USER_AVATAR_PATH.$vendorData->image: base_url().USER_DEFAULT_AVATAR;
                                            ?>
                                            <img src="<?php echo $img; ?>" alt="Image" />
                                        </div><!--/prfle-imge-->
                                        <!--/img prt-->
                                        <!--detail user part-->
                                        <div class="usr-dtl-prt">
                                            <h5><?php echo display_placeholder_text($vendorData->fullName); ?></h5>
                                            <p><?php echo display_placeholder_text($vendorData->address); ?></p>
                                            </div><!--/usr-dtl-prt-->
                                    </div><!--/lft-img-prt-->
                                </div><!--/left-prfle-prt-->
                            </div>  
                            <!--right portion-->    
                            <div class="col-xs-12 col-md-7 col-sm-12 col-xs-12">
                                <!--right portn detl prt-->
                                <div class="user-prfl-">
                                    <!--username-->
                                    <div class="rgt-sec">
                                        <div class="rgt-lft-head rgt-lft-head-mble">
                                            Username
                                        </div><!--/rgt-lft-head-->
                                        <div class="rgt-rgt-head rgt-rgt-head-mble">

                                            <?php echo display_placeholder_text($vendorData->fullName); ?>
                                        </div><!--/rgt-rgt-head-->
                                    </div><!--/rgt-sec-->
                                    <!--city-->
                                    <div class="rgt-sec">
                                        <div class="rgt-lft-head usr_city">
                                            City
                                        </div><!--/rgt-lft-head-->
                                        <div class="rgt-rgt-head usr_city1">
                                            <?php echo display_placeholder_text($vendorData->address); ?>
                                        </div><!--/rgt-rgt-head-->
                                    </div><!--/rgt-sec-->
                                    <!--email id-->
                                    <div class="rgt-sec">
                                        <div class="rgt-lft-head rgt-lft-head-mble">
                                            Email Id
                                        </div><!--/rgt-lft-head-->
                                        <div class="rgt-rgt-head rgt-rgt-head-mble">

                                            <?php echo display_placeholder_text($vendorData->email); ?>
                                        </div><!--/rgt-rgt-head-->
                                    </div><!--/rgt-sec-->
                                    <!--contact number-->
                                    <div class="rgt-sec">
                                        <div class="rgt-lft-head rgt-lft-head-mble">
                                            Contact Number
                                        </div><!--/rgt-lft-head-->
                                        <div class="rgt-rgt-head rgt-rgt-head-mble">
                                            <?php echo display_placeholder_text($vendorData->contactNumber); ?>
                                        </div><!--/rgt-rgt-head-->
                                    </div><!--/rgt-sec-->
                                    <?php if(empty($vendorData->socialId && $vendorData->socialType)) {?>
                                    <!--change password-->
                                    <a href="#" data-toggle="modal" data-target="#changePassword_modal"><div class="rgt-sec">
                                        <div class="rgt-lft-head">
                                            Change password
                                        </div><!--/rgt-lft-head-->
                                        <div class="rgt-rgt-head arrow">
                                            <i class="fa fa-chevron-right"></i>
                                        </div><!--/rgt-rgt-head-->
                                    </div></a><!--/rgt-sec-->
                                    <?php } ?>
                                    <!--edit and logout btn-->
                                    <div class="bth-btn">
                                        <div class="btn-prf"><a href="<?php echo site_url(); ?>home/users/editProfile"><button type="button" class="m-btn sbmt-btn">Edit</button></a></div><!--/btn-prf-->
                                        <div class="btn-prf lgout"><a href="<?php echo site_url(); ?>home/logout"><button type="button" class="m-btn sbmt-btn">Log Out</button></a></div><!--/btn-prf-->
                                    </div><!--/bth-btn-->
                                </div>   
                            </div>                  
                        </div><!--/row vertical-align-->
                    </div>
                </div>             
            </div>
            <!--/lex-->
        </div><!--/prfle-sctn-->
    </div><!--/top-img--> 
</section><!--/my-profile-->
<!--/profile page-->
<!--forget password-->
<!-- Modal -->
<div class="modal fade" id="changePassword_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label class="fnt-wt">Comfirm Password</label>
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
        </form>
    </div>
</div>
<!--/forget password end-->