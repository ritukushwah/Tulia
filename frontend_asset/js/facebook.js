jQuery.validator.addMethod("email", function(value, element) {
    return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
}, 'Please enter valid email address.');

/*login form validation*/
    var login_form = $("#login_form"); 
    login_form.validate({ 
        rules: {
           
            email: {
                required: true, 
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },   
            optradio:{ 
                required:true ,
            }          
        },
        messages: {
           
            email: {
                required: "Email is required field.", 
                email: "Please enter valid email"    
            },
            password: {
                required: "Password is required field.", 
                minlength:"Please enter minimum 6 characters.",
            },
            optradio: {
                required: "Please select user type.", 
            }
            
        },


        errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
                error.appendTo( element.parents('.container') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
         }

    });


    /*registration form validation*/
    var reg_form = $("#registration_form"); 
    reg_form.validate({
        rules: {
            fullName: {
                required: true  
            },
            address: {
                required: true  
            },
            ccategory: {
                required: true  
            },
            email: {
                required: true, 
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            contactNumber: {
                required: true,
                number:true,
                custom_number: true,
                minlength: 7,maxlength:12
            
            },
                               
        },
        messages: {
            fullName: {
                required: "Name is required field."      
            },
            address: {
                required: "Address is required field."      
            },
            ccategory: {
                required: "Category is required field."      
            },
            email: {
                required: "Email is required field.", 
                email: "Please enter valid email"    
            },
            password: {
                required: "Password is required field.", 
                minlength:"Please enter minimum 6 characters.",
            },
            contactNumber: {
                required: "Mobile number is required field.",
                number:"Numbers only in this field.",
                minlength:"Please enter minimum 7 digits.",
                maxlength:"Please enter maximum 20 digits.",
         
            },
            
        }
    });

    $.validator.addMethod("custom_number", function(value, element) {
        return this.optional(element) || value === "NA" ||
        value.match(/^[0-9,.\+-]+$/);
    }, "Please enter a valid number, or 'NA'");




var base_url = $('#tl_front_body').attr('data-base-url'); 
var user_type_inp = "input[name='optradio']"; 
var sel_cat = $("#select_cat");


sel_cat.click( function(){
    if($('#FBdata').val()){
        socialFB();
    }
    $("#category_model").modal("hide");
}); 
    

/* for user type selection*/ 
$('#signup_form').hide();
$("input[type='radio']").click(function(){ 
    user_type = $(user_type_inp+':checked').val(); 
    if(user_type){
        if(user_type == 'vendor'){
            $('#category_list').show();
        }else{
            $('#category_list').hide();
        }
        $('#signup_form').show();
    }
});

    function checkUserSelect(){
        user_type = $(user_type_inp+':checked').val(); 
        if (typeof user_type !== 'undefined'){
            $('#clickRegSpan').click();
        }else{
            toastr["error"]("Please select user type.")
        }
    }

    function fbLogin() {

        user_type = $(user_type_inp+':checked').val(); 
        if (typeof user_type !== 'undefined'){
            FB.login(function(e) {
                e.authResponse ? getFbUserData() : document.getElementById("status").innerHTML = "User cancelled login or did not fully authorize."
            }, {
                scope: "email"
            })
            
        }else{
        	toastr["error"]("Please select user type.")
        }
    }

function getFbUserData() {
    FB.api("/me", {
        locale: "en_US",
        fields: "id,first_name,last_name,email,link,gender,locale,picture"
    }, function(e) {
        userEmail = e.email, "undefined" == typeof e.email && (userEmail = e.id + "@facebook.com");
        var user_type = $(user_type_inp+':checked').val(); 
            t = {
            fullName: e.first_name,
            email: userEmail,
            socialId: e.id,
            image: "http://graph.facebook.com/" + e.id + "/picture?type=large",
            socialType: "facebook",
            userType:user_type
        };
        
        var myJSON = JSON.stringify(t); 
        $('#FBdata').val(myJSON)

        fbLogout(); url = base_url + "home/socialRegister/"; 
        $.ajax({
            url: url,
            type: "POST",
            data: t,
            dataType: "json",
            beforeSend: function () { 
                show_loader(); 
            },
            success: function(data) { 
                hide_loader(); 
                if(data.status==0){
                	toastr["error"](data.msg)
                    return false; //error msg
                } else if(data.status==2){ 
                    $("#category_model").modal("show");   
                } else if(data.status==4){ 
                    toastr["error"](data.message)           
                } else if(data.status== -1){
                    toastr["error"](data.message)
                } else{
                    if(data.url){ 
                        window.location.href = data.url;  //redirect user
                    } 
                }
            },
            error: function(data) {
            } 
        })
    })
}

function setVal(){
    var price = $("input[name='category']"+':checked').attr("price");
    $('#ccategory').val(price);
}

function socialFB(){
    var cat_name = $("input[name='category']"+':checked').val();
    url = base_url + "home/registerVendor/"; 
    var t = JSON.parse($('#FBdata').val());   
    $.ajax({
        url: url,
        type: "POST",
        data: { t ,cat_name},
        dataType: "json",
        beforeSend: function () { 
            show_loader(); 
        },
        success: function(data) { 
            hide_loader();
            toastr["success"](data.message);
            window.setTimeout(function () {
                window.location.href = data.url;
            }, 2000);
        },
        error: function(data) {
            hide_loader();
            toastr["error"](data.message)
           
        } 
    })



}

function fbLogout() {
    FB.logout(function() {})
}
window.fbAsyncInit = function() {
        FB.init({
            appId: "206996679863660",
            cookie: !0,
            xfbml: !0,
            version: "v2.11"
        }), FB.getLoginStatus(function(e) {
            "connected" === e.status && getFbUserData()
        })
    },
    function(e, t, a) {
        var o, i = e.getElementsByTagName(t)[0];
        e.getElementById(a) || (o = e.createElement(t), o.id = a, o.src = "//connect.facebook.net/en_US/sdk.js", i.parentNode.insertBefore(o, i))
    }(document, "script", "facebook-jssdk");


    /*user registration*/
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".user_registration", function (event) { 
        var img_type = fileValidation();
        if(img_type){
            if ($("#registration_form").valid()) {
                var _that = $(this), 
                form = _that.closest('form'),      
                formData = new FormData(form[0]),
                f_action = form.attr('action'),
                user_type = $(user_type_inp+':checked').val(); 

                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val()
                
                if(latitude != 0){
                    formData.append('latitude',latitude);
                    formData.append('longitude',longitude);
                    
                    formData.append('userType',user_type);
                    cat_name = $("input[name='category']"+':checked').val(); 
                    formData.append('category',cat_name);
                    if (typeof user_type !== 'undefined'){
                        $.ajax({
                            type: "POST",
                            url: f_action,
                            data: formData , //only input
                            processData: false,
                            contentType: false,
                            dataType: "JSON", 
                            beforeSend: function () { 
                                show_loader(); 
                            },
                            success: function (data, textStatus, jqXHR) { 
                                hide_loader();        
                                if (data.status == 1){
                                    toastr["success"](data.message);
                                    window.setTimeout(function () {
                                        window.location.href = data.url;
                                    }, 2000);
                                } else {
                                    toastr["error"](data.message)
                                    //$('#registration_form')[0].reset();
                                } 
                            },
                            error:function (){
                                $(".loaders").fadeOut("slow");
                            }
                        });
                    }else{
                       toastr["error"]('Please select user type.')
                    }
                }else{
                    toastr["error"]('Please select valid address.')
                	
                }
            }
        }
             
    });

    //for registration form validation
    $(".user_registration").click(function(){
        var btn = $(this);
        if (reg_form.valid()){
            
            var form_data = {
                'fullName'      : $("#fullName").val(),
                'email'         : $("#email").val(),
                'password'      : $("#password").val(),
                'contactNumber' : $("#contactNumber").val()
            }
            return true;                    
        }
    });
    
    if(localStorage.email){
    	$('#email').val(localStorage.email);
    	$('.checkbox-custom').click();
        $('#'+localStorage.user_type).click();
    }

	if(localStorage.pass){
    	$('#password').val(localStorage.pass)
        $('#'+localStorage.user_type).click();
    }

	if(localStorage.user_type){
		$('#'+localStorage.user_type).click();
	}

	/*if(localStorage.email && localStorage.pass && localStorage.user_type && localStorage.logedIn){
		show_loader();
		setTimeout(function() {
            $('.user_login').click()
        }, 4000);
	}*/

        /**** user login ****/
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".user_login", function (event) {
       

		var checkedValue = $('.checkbox-custom:checked').val();

		if (typeof checkedValue !== 'undefined'){
			localStorage.email = $('#email').val();
			localStorage.pass = $('#password').val();
			localStorage.chkbx = $('.checkbox-custom:checked').val();
		}else{
			localStorage.email = '';
			localStorage.pass = '';
			localStorage.chkbx = '';
		}

        if ($("#login_form").valid()) {
           
            
            var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action'),
            user_type = $(user_type_inp+':checked').val(); 


            if (typeof checkedValue !== 'undefined'){
				localStorage.user_type = user_type;
			}else{
				localStorage.user_type = '';
			}

            formData.append('userType',user_type);

            if (typeof user_type !== 'undefined'){
                show_loader();
                $.ajax({
                type: "POST",
                    url: f_action,
                    data: formData, //only input
                    processData: false,
                    contentType: false,
                    dataType: "JSON", 
                    success: function (data, textStatus, jqXHR) {  
                        hide_loader();       
                        if (data.status == 1){
                        	localStorage.logedIn = '1';
                            toastr["success"](data.message);
                            window.setTimeout(function () {
                                window.location.href = data.url;
                            }, 2000);
                        } else {
                        	localStorage.logedIn = '';
                            toastr["error"](data.message)
                            
                        } 

                        setTimeout(function() {
                            $(".alert").hide(1000);
                        }, 4000);

                    },
                    error:function (){
                        hide_loader();
                    }
                });

            }else{
            	toastr["error"]('Please select user type.')
            }

        }
    });

    function initialize() {
        autocompletee = new google.maps.places.Autocomplete(document.getElementById("address"), {
            types: []
        }), autocompletee.addListener("place_changed", fillInAddress)
    }

    function fillInAddress() {
        var address = document.getElementById('address').value;
        getLatitudeLongitude(showResult, address)
        autocompletee.getPlace()
    }

    $('#address').keyup(function(){
        
        var address = document.getElementById('address').value;
        var address = $.trim( address.replace(" ", "+") );
        jQuery.ajax({
            type: "GET",
            dataType: "json",
            url: "http://maps.googleapis.com/maps/api/geocode/json",
            data: {'address': address,'sensor':false},
            success: function(data){
                if(data.results.length){
                    document.getElementById('latitude').value = data.results[0].geometry.location.lat;
                    document.getElementById('longitude').value = data.results[0].geometry.location.lng;
                }else{
                    document.getElementById('latitude').value = 0;
                    document.getElementById('longitude').value = 0;
               }
            }
        });
    });


    function showResult(result) {
        document.getElementById('latitude').value = result.geometry.location.lat();
        document.getElementById('longitude').value = result.geometry.location.lng();
    }

    function getLatitudeLongitude(callback, address) {
        // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
        address = address || 'Ferrol, Galicia, Spain';
        // Initialize the Geocoder
        geocoder = new google.maps.Geocoder();
        if (geocoder) {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    callback(results[0]);
                }
            });
        }
    }


    function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }

    function forgotPassword(){
        user_type = $(user_type_inp+':checked').val(); 
        if (typeof user_type !== 'undefined'){
            $("#forgotPassword_modal").modal("show");   
        }else{
            toastr["error"]('Please select user type.')
        }
    }

      function sendMail(){

        var myEmail = $('#inputName').val(); 
            user_type = $(user_type_inp+':checked').val(); 
            if( !validateEmail(myEmail)) { 
                toastr["error"]('The Email field must contain a valid email address.');
             }else{
                if(myEmail){
                    show_loader();
                    $.ajax({
                        type: "POST",
                        url: base_url +'/home/users/resetPassword',
                        dataType: "json",
                        data: {'email':myEmail,'userType':user_type}, 
                        success: function (data, textStatus, jqXHR) { 
                            hide_loader();
                            
                            if(data.status == 1){
                                $('.forBtn').click();
                                toastr["success"](data.message);
                            }else{
                               
                                toastr["error"](data.message);
                            }
                        },
                        error:function (){
                            hide_loader();
                            toastr["error"]('Something going wrong.');
                        }
                    });
                }else{
                    toastr["error"]('The Email field is required.');
                }
            }
        
    }


	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-left",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

    /*var geocoder;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    } 
    //Get the latitude and the longitude;
    function successFunction(position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
    }

    function errorFunction(){alert("Geocoder failed");}
    function initialize() {geocoder = new google.maps.Geocoder();}*/
