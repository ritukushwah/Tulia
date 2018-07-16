 <script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
 <script type="text/javascript">
    
       // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDXppi4rb-OCK5BXuwSFhHlmh-ug6VKjvE",
        authDomain: "tulia-3e45f.firebaseapp.com",
        databaseURL: "https://tulia-3e45f.firebaseio.com",
        projectId: "tulia-3e45f",
        storageBucket: "tulia-3e45f.appspot.com",
        messagingSenderId: "301086763024"
    };
    firebase.initializeApp(config);

</script>
<!--profile page-->
<section id="my-profile">
    <div class="top-img">
        <!--template profile-->
        <div class="prfle-sctn edit-prfle-sectn sectn-pad">
            <!--flex-->
            <div class="container">

                <div class="row">
                    <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                        <form method="POST" id="edit_user_profile" role="form" action="<?php echo base_url('home/users/update_profile') ?>">
                            <div class="row vertical-align prfle-ver">
                                <!--left portion-->
                                <div class="col-xs-12 col-md-5 col-sm-12 col-xs-12">
                                    <div class="left-prfle-prt">
                                        <div class="lft-img-prt">
                                            <!--img prt-->
                                            <div class="log_div">
                                            <?php $img = (!empty($userData->image))? (filter_var($userData->image, FILTER_VALIDATE_URL))? $userData->image : base_url().USER_AVATAR_PATH.$userData->image: base_url().USER_DEFAULT_AVATAR;
                                            ?>
                                                <div class="usr-prfl">
                                                    <img src="<?php echo $img; ?>" id="pImg">
                                                </div>
                                                <div class="text-center upload_pic_in_album"> 
                                                    <input accept="image/*" class="inputfile hideDiv" id="file-1" id="image" name="image" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" style="display: none;" type="file">
                                                    <label for="file-1" class="upload_pic">
                                                        <span class="fa fa-camera"></span>
                                                    </label>
                                                </div>
                                                <div id="profileImage-err"> </div>
                                            </div>
                                            <!--/img prt-->
                                            <!--detail user part-->
                                            <div class="usr-dtl-prt">
                                                <h5><?php echo $userData->fullName; ?></h5>
                                                <p><?php echo $userData->address; ?></p>
                                            </div><!--/usr-dtl-prt-->
                                        </div><!--/lft-img-prt-->
                                    </div><!--/left-prfle-prt-->
                                </div>  
                                <!--right portion-->    
                                <div class="col-xs-12 col-md-7 col-sm-12 col-xs-12">
                                    <!--right portn detl prt-->
                                    <div class="user-prfl- edit-prfl">
                                        <!--username-->
                                        <div class="form-group">
                                            <label class="label-deco">Username</label>
                                            <input class="form-control add-post-frm" name="fullName" placeholder="" value="<?php echo $userData->fullName; ?>" type="text">
                                        </div>
                                        <!--city-->
                                        <div class="form-group">
                                            <label class="label-deco">City</label>
                                            <input class="form-control add-post-frm" name="address" id="address" placeholder="" value="<?php echo $userData->address; ?>" type="text">
                                            <input type="hidden" id="latitude" name="latitude" />
                                            <input type="hidden" id="longitude" name="longitude" />
                                            
                                        </div>
                                        <!--email id-->
                                        <div class="form-group">
                                            <label class="label-deco">Email Id</label>
                                            <input class="form-control add-post-frm" name="email" placeholder="" value="<?php echo $userData->email; ?>" type="text">
                                        </div>
                                        <!--contact number-->
                                        <div class="form-group">
                                            <label class="label-deco">Contact Number</label>
                                            <input class="form-control add-post-frm" name="contactNumber" placeholder="" value="<?php echo $userData->contactNumber; ?>" type="text">
                                        </div>
                                        <!--edit and logout btn-->
                                        <div class="bth-btn">
                                            <div class="btn-prf"><a href="javascript:void(0)"><button type="button" class="m-btn sbmt-btn update_user_profile">Update</button></a></div><!--/btn-prf-->
                                            <div class="btn-prf lgout"><a href="<?php echo site_url(); ?>home/users/"><button type="button" class="m-btn sbmt-btn">Cancel</button></a></div><!--/btn-prf-->
                                        </div><!--/bth-btn-->
                                    </div>   
                                </div>                  
                            </div><!--/row vertical-align-->
                        </form>
                    </div>
                </div>             
            </div>
            <!--/lex-->
        </div><!--/prfle-sctn-->
    </div><!--/top-img--> 
</section><!--/my-profile-->
<!--/profile page-->

<script type="text/javascript">
     function initialize() 
    {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById("address"));
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace(); 
            var latitude = place.geometry.location.lat(),
            longitude = place.geometry.location.lng(); 
            if(latitude != '' && longitude != ''){
                $("#latitude").val(latitude);
                $("#longitude").val(longitude);
                // place.geometry  -- this is used to detect whether User entered the name of a Place that was not suggested and pressed the Enter key, or the Place Details request failed.
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); //initialise google autocomplete API on load


    $("#address").on('keyup', function() {
        if($("#address").val() == ''){
            $("#latitude").val('');
            $("#longitude").val('');
        }
      
    });

</script>