$(document).ready(function(){

    jQuery.fn.visible = function() {
        return this.css('visibility', 'visible');
    };

    jQuery.fn.invisible = function() {
        return this.css('visibility', 'hidden');
    };

   
    $('#message').keyup(function () {
        var max = 200;
        var len = $(this).val().length;
        if (len >= max) {
            $('#count_message').html('<font color="red"></font>').slideDown(); 
        } else {
            var char = max - len; 
            $('#count_message').html(char+'&nbsp;&nbsp;<font color="black">Characters</font>').slideDown(); 
        }
    });

   
    var add_feedback = $("#myform");  
    add_feedback.validate({ 
        rules: {
            name: {
                required: true  
            },
            email: {
                required: true, 
                email: true
            },
            subject: {
                required: true
            },
            message: {
                required: true,
                minlength: 50,maxlength:200
            
            },
                               
        },
        messages: {
            name: {
                required: "Name is required field."      
            },
            email: {
                required: "Email is required field.", 
                email: "Please enter valid email"    
            },
            subject: {
                required: "Subject is required field."
            },
            message: {
                required: "Messager is required field.",
                minlength:"Please enter minimum 50 characters.",
                maxlength:"Please enter maximum 200 characters.",
         
            },
            
        }
    });

    jQuery.validator.addMethod("phoneno", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "<br />Please enter a valid contact numberr");



     /*create post form validation*/
    var create_post = $("#create_post"); 
    create_post.validate({ 
        rules: {
           
            category: {
                required: true
            },
            guest_number: {
                required: true
            },
            event_date: {
                required: true
            },
            event_time: {
                required: true
            },
            event_type: {
                required: true
            },
            budget_from: {
                required: true
            },
            contact_number: {
                required: true,
                number:true,
                phoneno: true,
                minlength: 7,maxlength:20
            },
            currency_symbol: {
                required: true
            },
            address: {
                required: true
            },
            description: {
                required: true,
                minlength: 50,maxlength:200
            },                   
        },
        messages: {
           
            category: {
                required: "Please select category" 
            },
            guest_number: {
                required: "Please select number of guest"
            },
            event_date: {
                required: "Please select event date"
            },
            event_time: {
                required: "Please select event time"
            },
            event_type: {
                required: "Please select event type"
            },
            budget_from: {
                required: "Please select budget from"
            },
            guest_number: {
                required: "Please select number of guest"
            },
            contact_number: {
                required: "Contact number is required field.",
                number:"Please enter a valid contact number.",
                minlength:"Please enter minimum 7 digits.",
                maxlength:"Please enter maximum 20 digits."

            },
            currency_symbol: {
                required: "Please select currency code"
            },
            address: {
                required: "Address is required field."
            },
            description: {
                required: "Description is required field.",
                minlength:"Please enter minimum 50 characters.",
                maxlength:"Please enter maximum 200 characters."
            }
        }

    });

   
    

    jQuery.validator.addMethod("lettersonly", function(value, element) 
    {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Letters and spaces only please");



    /*update vendor profile form validation*/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    var updateProfile_form = $("#edit_profile"); 
    updateProfile_form.validate({
        rules: {
            fullName: {
                required: true,
                lettersonly: true   
            },
            email: {
                required: true, 
                email: true ,
                remote: base_url + "home/users/check_user_email"
            },
            address: {
                required: true
            },
            contactNumber: {
                required: true,
                number:true,
                phoneno: true,
                remote: base_url + "home/users/check_contact",
                minlength: 7,maxlength:20
            },
            currency_symbol: {
                required: true
            },
            description: {
                required: true
            },  
            category: {
                required: true
            },
            price: {
                required: true,
                number:true,
                min: 1 
            }
                               
        },
        messages: {
            fullName: {
                required: "Name is required field.",
                lettersonly: "Enter only alphabates"      
            },
            email: {
                required: "Email is required field.", 
                email: "Please enter valid email" ,
                remote: "Email already exist"   
            },
            address: {
                required: "City is required field."
            },
            contactNumber: {
                required: "Contact number is required field.",
                number:"Please eneter valid contact number .",
                remote: "Mobile number already exist" ,  
                minlength:"Please enter minimum 7 digits.",
                maxlength:"Please enter maximum 20 digits.",
         
            },
            currency_symbol: {
                required: "please select currency symbol"
            },
            description: {
                required: "description is required field."
            },
            category: {
                required: "please select category" 
            },
            price: {
                required: "Price is required field.",
                number:"Please enter numbers only." ,
                min: "Please enter amount"    
            },
            
        }
    });



    /*update user profile form validation*/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    var updateUserProfile_form = $("#edit_user_profile"); 
    updateUserProfile_form.validate({
        rules: {
            fullName: {
                required: true,
                lettersonly: true   
            },
            email: {
                required: true, 
                email: true ,
                remote: base_url + "home/users/check_user_email"
            },
            address: {
                required: true
            },
            contactNumber: {
                required: true,
                number:true,
                phoneno: true,
                remote: base_url + "home/users/check_contact",
                minlength: 7,maxlength:20
            },             
        },
        messages: {
            fullName: {
                required: "Name is required field.",
                lettersonly: "Enter only alphabates"      
            },
            email: {
                required: "Email is required field.", 
                email: "Please enter valid email" ,
                remote: "Email already exist"   
            },
            address: {
                required: "City is required field."
            },
            contactNumber: {
                required: "Contact number is required field.",
                number:"Please eneter valid contact number .",
                remote: "Mobile number already exist" ,  
                minlength:"Please enter minimum 7 digits.",
                maxlength:"Please enter maximum 20 digits.",
         
            },
            
        }
    });



    /*change password form validation*/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    var changePassword_form = $("#update_password"); 
    changePassword_form.validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                remote: base_url + "home/users/check_password"
            },
            npassword: {
                required: true,
                minlength: 6 
            },
            rnpassword: {
                required: true,
                minlength: 6,
                equalTo: "#npassword"
            }        
        },
        messages: {
            password: {
                required: "Password is required field.", 
                minlength:"Please enter minimum 6 characters.",
                remote: "Your current password is wrong"
            },
            npassword: {
                required: "New password is required field.", 
                minlength:"Please enter minimum 6 characters."   
            },
            rnpassword: {
                required: "Confirm password is required field.", 
                minlength:"Please enter minimum 6 characters.",
                equalTo: "Confirm password and new password doesn't match."
            }
        }
    });



    var addReview_form = $("#vendor_review");  
    addReview_form.validate({ 
        rules: {

            review_description: {
                required: true,
                maxlength:200
            },             
        },
        messages: {
           
            review_description: {
                required: "Please enter description." ,
                maxlength:"Please enter maximum 200 words."    
            },
        }
    });


    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


    /**** update user profile here ****/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".update_user_profile", function (event) {
        //for update profile form validation
        if (updateUserProfile_form.valid()){ 
            var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action'); 
 

            $.ajax({
                type: "POST",
                url: f_action,
                data: formData, //only input
                processData: false,
                contentType: false,
                dataType: "JSON", 
                beforeSend: function () { 
                    show_loader(); 
                },
                success: function (data, textStatus, jqXHR) {  
                    hide_loader();  

                          
                    if (data.status == 1){ 

                    var userData = {
                        category: "",
                        email: data.userData.email,
                        firebaseId: "",
                        firebasetoken: "",
                        name: data.userData.fullName,
                        profilePic: data.userData.thumbImage,
                        uid: data.userData.id,
                        userType: data.userData.userType

                    };

                var userType = data.userData.userType;   
                var uid = data.userData.id;
                if(userType == 'user'){ 
                    var newPostKey = firebase.database().ref('users').child('user').child(data.userData.id).set(userData);
                }else{ 
                    var newPostKey = firebase.database().ref('users').child('vendor').child(data.userData.id).set(userData);
                }

                        toastr.success(data.message);
                        window.setTimeout(function () {
                             window.location.href = data.url;
                        }, 2000);

                    } else {
                            toastr.error(data.message);
                            //$('#edit_profile')[0].reset();
                    } 

                     setTimeout(function() {
                            $(".alert").hide(1000);
                        }, 4000);
                },

                error:function (){
                    $(".loaders").fadeOut("slow");
                }
            });
        }else{ 
            toastr.error('Failed! Please try again');
        }
    });








    /**** update vendor profile here ****/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".update_profile", function (event) { 
        //for update profile form validation
        if (updateProfile_form.valid()){ 
            var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action'); 


            $.ajax({
                type: "POST",
                url: f_action,
                data: formData, //only input
                processData: false,
                contentType: false,
                dataType: "JSON", 
                beforeSend: function () { 
                    show_loader(); 
                },
                success: function (data, textStatus, jqXHR) {  
                    hide_loader();  



                    if (data.status == 1){ 

                       
                    var userData = {
                        category: "",
                        email: data.userData.email,
                        firebaseId: "",
                        firebasetoken: "",
                        name: data.userData.fullName,
                        profilePic: data.userData.thumbImage,
                        uid: data.userData.id,
                        userType: data.userData.userType

                    };

                var userType = data.userData.userType;   
                var uid = data.userData.id;
                if(userType == 'user'){ 
                    var newPostKey = firebase.database().ref('users').child('user').child(data.userData.id).set(userData);
                }else{ 
                    var newPostKey = firebase.database().ref('users').child('vendor').child(data.userData.id).set(userData);
               
                }

                        toastr.success(data.message);
                        window.setTimeout(function () {
                             window.location.href = data.url;
                        }, 2000);

                    } else {
                            toastr.error(data.message);
                            //$('#edit_profile')[0].reset();
                    } 

                     setTimeout(function() {
                            $(".alert").hide(1000);
                        }, 4000);
                },

                error:function (){
                    $(".loaders").fadeOut("slow");
                }
            });
        }else{
            toastr.error('Failed! Please try again');
        }
    });


    /**** Change password here ****/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".change_password", function (event) {
        if (changePassword_form.valid()){
            var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData, //only input
                processData: false,
                contentType: false,
                dataType: "JSON", 
                beforeSend: function () { 
                    show_loader(); 
                },
                success: function (data, textStatus, jqXHR) {  
                    hide_loader();        
                    if (data.status == 1){
                        toastr.success(data.message);
                        window.setTimeout(function () {
                        window.location.href = data.url;
                    }, 2000);
                    } else {
                        toastr.error(data.message);
                        //$('#edit_profile')[0].reset();
                    } 
                },
                error:function (){
                    $(".loaders").fadeOut("slow");
                }
            });
        }
    });

 /**** create post here ****/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".add_post", function (event) {
        var t = checkDateTime();
        if(t){
            var add_post = $('.add_post');
            add_post.attr('disabled','disabled');
            //add_post.invisible();
            if (create_post.valid()){
                var latitude = $("#latitude").val();
                var longitude = $("#longitude").val();
                if(latitude == '' && longitude == ''){
                    toastr.error('This is not a valid address');
                }else{

                    var _that = $(this), 
                    form = _that.closest('form'),      
                    formData = new FormData(form[0]),
                    f_action = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: f_action,
                        data: formData, //only input
                        processData: false,
                        contentType: false,
                        dataType: "JSON", 
                        beforeSend: function () { 
                            $("div#divLoading").addClass('show'); 
                        },
                        success: function (data, textStatus, jqXHR) {  

                            $("div#divLoading").removeClass('show');        
                            if (data.status == 1){
                                toastr.success(data.message);
                                window.setTimeout(function () {
                                    window.location.href = data.url;
                                }, 1000);
                                
                            }else if(data.status == -1){
                                toastr.error(data.message);
                                window.setTimeout(function () {
                                    window.location.href = data.url ;
                                }, 100); 
                            }
                             else {
                                //add_post.visible();
                                add_post.removeAttr('disabled');
                                toastr.error(data.message);
                            } 
                        },
                        error:function (){
                            $(".loaders").fadeOut("slow");
                        }
                    });
                }
            }else{
                //add_post.visible();
                add_post.removeAttr('disabled');
            }

        }
    });
   /**** update post here ****/
    var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".update_post", function (event) {
        var d = checkTime();
        if(d){
                if (create_post.valid()){
                var latitude = $("#latitude").val();
                var longitude = $("#longitude").val();
                if(latitude == '' && longitude == ''){
                    toastr.error('This is not a valid address');
                }else{

                    var _that = $(this), 
                    form = _that.closest('form'),      
                    formData = new FormData(form[0]),
                    f_action = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: f_action,
                        data: formData, //only input
                        processData: false,
                        contentType: false,
                        dataType: "JSON", 
                        beforeSend: function () { 
                            show_loader(); 
                        },
                        success: function (data, textStatus, jqXHR) {  
                            hide_loader();        
                            if (data.status == 1){
                                toastr.success(data.message);
                                window.setTimeout(function () {
                                    window.location.href = data.url;
                                }, 2000);
                            } else {
                                toastr.error(data.message);
                                //$('#create_post')[0].reset();
                            } 
                        },
                        error:function (){
                            $(".loaders").fadeOut("slow");
                        }
                    });
                }
            }  
        }
     
    });



  /**** add vendor's review here ****/
   var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".add_review", function (event) {
        var add_review = $('.add_review');
        //add_review.invisible();
        add_review.attr('disabled','disabled');
        if (addReview_form.valid()){
            
            var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData, //only input
                processData: false,
                contentType: false,
                dataType: "JSON", 
                beforeSend: function () { 
                    show_loader(); 
                },
                success: function (data, textStatus, jqXHR) {  

                    hide_loader(); 

                    if (data.status == 1){
                        toastr.success(data.message);
                        window.setTimeout(function () {
                        window.location.href = data.url;
                        
                    }, 1000);
                    }
                    else if(data.status == -1){
                        toastr.error(data.message);
                        window.setTimeout(function () {
                            window.location.href = data.url ;
                        }, 1000); 
                    }
                    else {
                        //add_review.visible();
                        add_review.removeAttr('disabled');  
                        toastr.error(data.message);
                    }
                    
                },
               
                error:function (){
                    $(".loaders").fadeOut("slow");
                    add_review.removeAttr('disabled');
                    //add_review.visible();  
                }
            });
        }else{
            //add_review.visible();
            add_review.removeAttr('disabled');
            toastr.error('Please, select rating!');
        }
    });
    
    



});


