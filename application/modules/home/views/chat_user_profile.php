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
