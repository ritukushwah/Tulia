<?php
$frontend_assets =  base_url().'frontend_asset/';
?>
<style type="text/css">
    input[type=radio]:checked + label {
    color: red;
    font-weight: 600;
}
</style>
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
                <!--head-->
                <div class="welcme-tulia-head">
                  Welcome To Tulia
                  <div class="border" style="text-align:center;">
                    <img src="<?php echo $frontend_assets ?>img/border-welcm.png" alt="Image" />
                  </div>
                </div><!--/welcme-tulia-head--> 
                <!--/head-->            
              <!--end of i wnt to sign in as-->
                    <div class="row">                     
                      <div class="col-lg-12 col-md-12 col-sm-12">
                      <!--user select-->
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-6 mrgn-top-rdio">
                            <!--test-->
                            <div class="">
                                <div class="form-style-10">
                                    <div class="userType">
                                      <div class="Ustype pdng-type">
                                      <span class="radio-inline res-rdio hvr-radial-out">
                                          <input onclick=" $('#loginUrEr').html('') " type="radio" name="optradio" id="vendor" value="vendor">
                                          <label><span><i class="fa fa-users"></i></span>Vendor
                                          </label>
                                      </span>
                                      </div>
                                      <div class="Ustype pdng-type">
                                      <span class="radio-inline hvr-radial-out">
                                          <input onclick=" $('#loginUrEr').html('') " type="radio" name="optradio" id="user" value="user" >
                                          <label><span><i class="fa fa-user"></i></span>User
                                          </label>
                                      </span>
                                      </div>
                                    </div>  
                                    <center id="loginUrEr" style="color: red;" ></center>                  
                                </div>
                            </div>
                            <!--/test-->
                          </div>
                        <div class="col-sm-2" role="alert"></div>
                        <div id="error" class="alert alert-danger text-center alert-dismissible col-sm-8" role="alert" style="display:none">
                            <button type="button" id="closeAlert1" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div id="selectedAssetsDetails"> </div>
                        </div>
                        <div id="succeess" class="alert alert-success text-center alert-dismissible col-sm-8" role="alert" style="display:none">
                            <button type="button" id="closeAlert1" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div id="selectedAssetsDetailss"> </div>
                        </div>
                        <div class="col-sm-2" role="alert"></div>
                        </div>
                      <!--/user select-->
                      
                        <!--/test-->
                        <form class="login-form login-res" method="POST" id="login_form" role="form" action="<?php echo base_url('home/userLogin') ?>">
                            <div class="form-group lin-hgt">
                              <label class="fnt-wt label-deco" style="font-size:16px;">Email</label>
                              <input class="form-control" id="email" name="email" placeholder="" type="text" value="">
                            </div><!--/form-group-->
                            <div class="form-group lin-hgt">
                              <label class="fnt-wt label-deco" style="font-size:16px;">Password</label>
                              <input class="form-control" id="password" name="password" placeholder="" type="password" value="">
                            </div><!--/form-group-->
                            <div class="form-group mrg-bm">
                            <input type="hidden" val="" id="FBdata">
                              <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                  <div class="checked">
                                    <input id="checkbox-2"  value="remember-me" class="checkbox-custom" name="checkbox-2" type="checkbox">
                                    <label for="checkbox-2" class="checkbox-custom-label fnt-wt label-deco" style="font-size:16px;">Remember Me</label>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                  <div class="frgt-pswd" style="text-align:right;">
                                    <a style="cursor: pointer;color:#787878;font-size:16px;" data-toggle="modal" class="forgot fnt-wt label-deco" onclick="forgotPassword()" >Forgot password ?</a>
                                  </div>                              
                                </div>                            
                              </div>
                            </div>
                            <div class="login-snd">
                             <a href="javascript:void(0)"><button type="button" class="m-btn login-btn user_login">Login</button></a>
                            </div>
                            <div class="or-with">
                               <p style="font-size:16px;">Or Sign In With</p>
                            </div><!--/or-with-->
                            <div class="form-group f-alignmnt">
                                <div id="status"></div>

                                <!-- Facebook login or logout button -->
                                <button type="button" onclick="fbLogin()" id="fbLink" class="fbbtn fb-btn" ><i class="fa fa-facebook"></i><span>  Facebook</span></button>

                                <!-- Display user profile data -->
                                <div id="userData"></div>
                            </div>  
                            <div style="cursor: default; color:#787878;font-size:16px;" class="agree">Don’t have an account?
                            <a href="javascript:void(0)" >
                           
                            <span class="crte-accnt" style="color:#787878;font-weight:700;font-size:18px;" value="Click" onclick="checkUserSelect();">  Create account</span>

                            <span id="clickRegSpan" class="crte-accnt" style="display: none; color:#787878;font-weight:700;font-size:18px;" value="Click" onclick="switchVisible();">  Create account</span>    
                            </a>
                            </div>  
                        </form>                  
                      </div>
                    </div>
                </div><!--/login-wrapper-->
              </div>
            </div>
          <!--/login form end-->
        </div>
      </div>
    </div>
  </div><!--/login-frm-->

     <!--registration-frm-->
    <div id="regstrn-frm" style="display:none;">
        <div class="container">
            <!--registration form start-->
            <div class="row">
                <!--blank space-->
                <div class="col-lg-2 col-md-0 col-sm-0"></div>
                <!--form sectn-->
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="login-wrapper"> 
                            <form class="login-form" method="POST" id="registration_form" role="form" action="<?php echo base_url('home/userRegistration') ?>">
                           
                                <div class="row mar-btm">
                                <!--test-->
                                <div class="col-lg-12 col-md-12 col-sm-12" style="text-align:center;">
                                    <div class="log_div">
                                        <img src="<?php echo $frontend_assets ?>img/user-acnt-icn.png" id="pImg">
                                        <div class="text-center upload_pic_in_album"> 
                                            <input  accept="image/png,image/jpg,image/jpeg" class="inputfile hideDiv" id="file-1" name="image" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0]); return fileValidation()" style="display: none;" type="file">
                                            <label for="file-1" class="upload_pic">
                                            <span class="fa fa-camera"></span></label>
                                        </div>
                                        <div id="image-err"> </div>
                                    </div>
                                </div>   

                            </div>                 
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group lin-hgt">
                                            <label class="fnt-wt">Name</label>
                                            <input class="form-control" id="fullName" name="fullName" placeholder="" type="text">
                                        </div><!--/form-group-->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group lin-hgt">
                                            <label class="fnt-wt">Email</label>
                                            <input class="form-control" id="reg_email" name="email" placeholder="" type="text">
                                        </div><!--/form-group-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group lin-hgt">
                                            <label class="fnt-wt">Password</label>
                                            <input class="form-control" id="reg_password" name="password" placeholder="" type="password">
                                        </div><!--/form-group-->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group lin-hgt">
                                            <label class="fnt-wt">Mobile No.</label>
                                            <input class="form-control" id="contactNumber" name="contactNumber" placeholder="" type="text">
                                        </div><!--/form-group-->
                                    </div>
                                </div>

                                <input type="hidden" id="latitude" />  
                                <input type="hidden" id="longitude" />

                               




                                <!--country code and mble no-->                     
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group lin-hgt">
                                            <label class="fnt-wt">Address</label>
                                            <input onkeyup="initialize();"  class="form-control" id="address" name="address" placeholder="" type="text">
                                        </div><!--/form-group-->
                                    </div>

                                    <div  id="category_list"  class="col-lg-6 col-md-6 col-sm-12">
                                        <div data-toggle="modal" data-target="#category_model" class="form-group lin-hgt">
                                            <label class="fnt-wt">Category</label>
                                            <input onkeyup="initialize();"  class="form-control" id="ccategory" name="ccategory" placeholder="" type="text" readonly="">
                                        </div><!--/form-group-->
                                    </div>
                                </div>
                              <!--end of country code and mble no-->


                                <div style="display: none;" class="row" >
                                     <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group brdr-btm" > 
                                            <label class="label-deco fnt-wt">Category</label>
                                            <i class="fa fa-caret-down" style="float:right;padding-top:14px;color:#eb0202;"></i>
                                        </div>
                                    </div>
                                </div>

  

                                <div class="login-snd">
                                <a href="javascript:void(0)"><button type="button" class="m-btn login-btn user_registration">Sign Up</button></a></div>
                                <div class="or-with">
                                    <p>Or Sign In With</p>
                                </div><!--/or-with-->
                                <div class="form-group f-alignmnt">
                                    <div id="status"></div>

                                    <!-- Facebook login or logout button -->
                                    <button type="button" onclick="fbLogin()" id="fbLink" class="fbbtn fb-btn" ><i class="fa fa-facebook"></i><span>  Facebook</span></button>

                                    <!-- Display user profile data -->
                                    <div id="userData"></div>
                                </div>  
                                <div style="cursor: default;font-size:16px;color:#787878;" class="agree">Already a member?<a href="javascript:void(0)" ><span style="color:#787878;font-size:18px;font-weight:700;" value="Click" onclick="switchVisible();">  Login</span></a></div>  
                            </form><!--/login-form-->
                        </div><!--/login-wrapper-->
                </div>
            </div>
            <!--/registration form end-->       
        </div>
    </div><!--/regstrn-frm-->
</section><!--/tulia-login-->

<div class="modal fade" id="forgotPassword_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Forget Your Password
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="modal-frgt-para">
                        Dont't Worry ! Just fill in your email and we'll help you reset your password.
                    </div>
                    <div class="form-group lin-hgt">
                        <label class="fnt-wt">Email</label>
                        <input class="form-control" id="inputName" onkeyup="emptyEmail()" placeholder="" type="text">
                    </div><!--/form-group-->
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top">
                    <a href="javascript:void(0)"><button type="button" id="btnDisEmil" onclick="sendMail()" class="btn btn-primary m-btn" disabled="">Send</button></a>
                </div>                                                                      
            </div>
            <div class="bck-arrow-clr">
                <div class="arrow-bck close float forBtn" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Back to login</span>
                </div>
            </div><!--/bck-arrow-clr-->         
        </div>
    </div>
</div>
<script type="text/javascript">
  function emptyEmail(){
    $('#btnDisEmil').prop('disabled', true);
    var mail = $('#inputName').val();
    if(mail){
      $('#btnDisEmil').prop('disabled', false);
    }
  }
</script>
<!--/forget password end-->
<!-- category selection -->
<div class="modal fade" id="category_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog slct-ctrgy" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Select Your Category
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body">
                <?php foreach ($category as $rows) { ?>
                <div onclick=" $('#select_cat').click();" class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <!--test-->
                        <div class="rad-type">
                            <div class="cat-type">
                                <span class="radio-inline">
                                    <input name="category" price="<?php echo $rows['name'] ?>" type="radio" value="<?php echo $rows['id'] ?>">
                                    <label><?php echo $rows['name'] ?></label>

                                </span>
                            </div><!--/cat-type-->
                        </div><!--/rad-type-->
                        <!--/test-->
                    </div>
                </div>
                <?php } ?>
                <div class="row" style="margin:20px 0 0 0;">
                    <div class="col-lg-12 col-md-12 col-sm-12 slct-btn2">
                        <a href="javascript:void(0)"><button onclick="setVal();" type="button" id="select_cat" class="m-btn sbmt-btn">Done</button></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer brdr-top-disms left-flt">
                <div class="arrow-bck close float" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Close</span>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--/category selection end-->

<script type="text/javascript">
    function fileValidation(){
    var fileInput = document.getElementById('file-1'); 
    var filePath = fileInput.value; 
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
     if(!filePath ){
            return true;
        }
        if(!allowedExtensions.exec(filePath)){ 
            toastr.error('Please select png,jpg and jpeg image formats.');
            // alert('Please upload file having extensions .jpeg/.jpg/.png only.');
            return false;
        }else{ 
            //Image preview
            if (fileInput.files && fileInput.files[0]) { 
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('pImg').innerHTML = '<img src="'+e.target.result+'"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
            return true;
        }
    
    
}
</script>