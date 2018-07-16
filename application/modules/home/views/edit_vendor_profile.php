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
<!--vendor profile page-->
<section id="profile-vndr" class="sectn-pad">
    <div class="row">

        <div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
            <form method="POST" id="edit_profile" role="form" action="<?php echo base_url('home/users/update_profile') ?>">
                <!--vendor profile sectn-->
                <div class="container">
                    <div class="row vertical-align prfl-vndr-ver">
                        <!--left side portion vendor profile page-->
                        <div class="col-md-5 col-sm-12 col-xs-12" style="background-image: url(<?php echo $userData->cat_image; ?>);">
                            <!--vendor profile info-->
                            <div class="left-prfle-prt rounded-prt">
                                <div class="lft-img-prt">
                                    <!--img prt-->
                                    <div class="log_div">
                                        <?php $img = (!empty($userData->image))? (filter_var($userData->image, FILTER_VALIDATE_URL))? $userData->image : base_url().USER_AVATAR_PATH.$userData->image: base_url().USER_DEFAULT_AVATAR; ?>
                                        <div class="usr-prfl">
                                            <img src="<?php echo $img; ?>" id="pImg">
                                        </div>
                                        <div class="text-center upload_pic_in_album"> 
                                            <input accept="image/*" class="inputfile hideDiv" id="file-1" name="image" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" style="display: none;" type="file">
                                            <label for="file-1" class="upload_pic">
                                            <span class="fa fa-camera"></span></label>
                                        </div>
                                        <div id="profileImage-err"> </div>
                                    </div>
                                    <!--/img prt-->
                                    <!--/img prt-->
                                    <!--detail user part-->
                                    <div class="usr-dtl-prt pdng-btm-vndr">
                                        <h5><?php echo $userData->fullName; ?></h5>
                                        <p><?php echo $userData->category_name; ?></p>
                                    </div><!--/usr-dtl-prt-->
                                    <div class="rating pdng-btm-vndr-rate">
                                        <?php 
                                            $total_rating = intval($userData->rating); 
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
                                        ?></p> 
                                    </div>
                                </div><!--/lft-img-prt-->
                            </div><!--/left-prfle-prt-->
                        </div>
                        <!--right side portion vendor profile page-->
                        <div class="col-xs-12 col-md-7 col-sm-12 col-xs-12">
                            <!--vendor profie detail-->
                            <div class="user-prfl-">
                                <div class="row">               
                                    <!--username-->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Username</label>
                                            <input class="form-control add-post-frm" id="fullName" name="fullName" placeholder="" value="<?php echo $userData->fullName; ?>" type="text">
                                        </div>
                                    </div>
                                        <!--city-->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">City</label>
                                            <input class="form-control add-post-frm" id="address" name="address" placeholder="" value="<?php echo $userData->address; ?>" type="text">
                                            <input type="hidden" id="latitude" name="latitude" />
                                            <input type="hidden" id="longitude" name="longitude" />
                                        </div>
                                    </div>
                                </div>
                                <!--email id-->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Email Id</label>
                                            <input class="form-control add-post-frm" id="email" name="email" placeholder="" value="<?php echo $userData->email; ?>" type="text">
                                        </div>
                                    </div>
                                    <!--contact number-->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Contact Number</label>
                                            <input class="form-control add-post-frm" id="contactNumber" name="contactNumber" value="<?php echo $userData->contactNumber; ?>" placeholder="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <!--select category-->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Category</label>
                                                <select class="form-control add-post-frm bck-img" id="category" name="category">
                                                    <option value="<?php echo $userData->category_id; ?>"><?php echo $userData->category_name; ?></option>
                                                    <?php foreach ($category as $rows) { ?>
                                                    <option value="<?php echo $rows['id'] ?>"><?php echo $rows['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                    <!--select Currency-->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Currency</label>
                                            <select class="form-control add-post-frm bck-img currency" name="currency_code" id="currency_code">
                                            <?php if(empty($userData->currency_symbol && $userData->currency_code)){ ?>
                                            <option value="">select currency</option>
                                              
                                            <?php } 
                                              $url = APPPATH.'third_party/currency.json'; 
                                              $jsonData = json_decode(file_get_contents($url)); 
                                            
                                              foreach ($jsonData as $key => $val) {
                                              ?>
                                              <option data-symbol="<?php echo $val->symbol; ?>" value="<?php echo $val->code; ?>"><?php echo $val->name_plural .' ( '.$val->symbol.')'; ?></option>
                                              <?php } ?>
                                            </select>
                                            <input type="hidden" id="currency_symbol" name="currency_symbol" value="<?php echo $userData->currency_symbol; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <!--Price-->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Price</label>
                                            <input class="form-control add-post-frm" id="price" name="price" placeholder="" value="<?php echo $userData->price; ?>" type="text">
                                        </div>
                                    </div>
                                    <!--description-->
                                    <!--contact number-->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="label-deco">Description</label>
                                            <textarea class="form-control add-post-frm des-cst" id="description" name="description" placeholder="" type="text" maxlength="200"><?php echo $userData->description; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--edit and logout btn-->
                                <div class="bth-btn">
                                    <div class="btn-prf"><a href="javascript:void(0)"><button type="button" class="m-btn sbmt-btn update_profile">Update</button></a></div><!--/btn-prf-->
                                    <div class="btn-prf lgout"><a href="<?php echo site_url(); ?>home/users/"><button type="button" class="m-btn sbmt-btn">Cancel</button></a></div><!--/btn-prf-->
                                </div><!--/bth-btn-->
                            </div>
                        </div>        
                    </div>
                </div>
            </form>
            <!--vendor profile sectn-->
        </div>
    </div>
</section><!--/profile-vndr-->
<!--/vendor profile page-->

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

    
    //for getting currency symbol on change
    $('#currency_code').on('change', function() {
        var symbol = $(this).find(':selected').attr('data-symbol'); 
        $('#currency_symbol').val(symbol);

    })


    //set equal to what you want to compare
    var currency_code = '<?php echo $userData->currency_code;?>'; 
    $('#currency_code').find('option').each(function(i,e){ 
        //console.log($(e).val());
            if($(e).val() == currency_code){
                $('#currency_code').prop('selectedIndex',i);
        }
    });

    $('#description').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

</script>