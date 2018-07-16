<?php
$frontend_assets =  base_url().'frontend_asset/';
?>
<!--section start-->
<section class="tulia-login sectn-pad">
    <div id="login-frm">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">     
                    <!--login form start-->
                    <div class="row">
                        <!--blank space-->
                        <div class="col-lg-2 col-md-0 col-sm-0"></div>
                        <!--form sectn-->
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="login-wrapper pdng-login"> 
                                <!--form start-->
                                <section id="user-select-radio">
                                    <div class="container">
                                        <div class="row">
                                            <div class="sign-in-as">
                                                I want to sign in as
                                            </div><!--/sign-in-as-->
                                            <div class="sign-brdr" style="text-align:center; margin-top:20px;">
                                                <img src="<?php echo $frontend_assets ?>img/user-design.png" alt="Image" />
                                            </div><!--/sign-brdr-->
                                        </div>
                                        <!--user select option-->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 mrgn-top-rdio">
                                                <!--test-->
                                                <div class="">
                                                    <div class="form-style-10">
                                                        <form>
                                                            <div class="userType">
                                                                <div class="Ustype">
                                                                    <span class="radio-inline">
                                                                        <input type="radio" name="optradio" value="vendor" checked="">
                                                                        <label><span><i class="fa fa-users"></i></span>
                                                                        <p>Vendor</p></label>
                                                                    </span>
                                                                </div>
                                                                <div class="Ustype">
                                                                    <span class="radio-inline">
                                                                        <input type="radio" value="user" name="optradio">
                                                                        <label><span><i class="fa fa-user"></i></span>
                                                                        <p>User</p></label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!--/test-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section><!--/user-select-radio-->            
                            </div>
                        </div>
                    </div>
                    <!--/login form end-->
                </div>
            </div>
        </div>
    </div><!--/login-frm--> 
</section><!--/tulia-login-->
<!--section close-->