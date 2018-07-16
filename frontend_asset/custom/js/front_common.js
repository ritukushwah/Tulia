
function show_loader(){
    $('#tl_admin_loader').show();
}

function hide_loader(){
    $('#tl_admin_loader').hide();
}


var deleteFunc = function (id, ctrl, method) { 
        if(typeof method == "undefined" || method==""){
            method = "posts/deletePost";
        }
        else{
            method = ctrl+method;
        }
       
            show_loader();
            var url = base_url+method;
            $.ajax({
                method: "POST",
                url: url,
                dataType: "json",
                data: {id: id},
                success: function (data) {
                    hide_loader(); 
                    if (data.status == 1) {
                        toastr.success(data.message);
                        window.setTimeout(function () {
                                window.location.href = data.url;
                            }, 2000);
                    }
                    else{
                        toastr.error(data.message);
                    }
                },
                
            });
  
    }

/**** for inserting feedback ****/
$(document).ready(function(){ 

   var base_url = $('#tl_front_body').attr('data-base-url'); 
    $('body').on('click', ".add_feedback", function (event) {
        var _that = $(this), 
            form = _that.closest('form'),      
            formData = new FormData(form[0]),
            f_action = form.attr('action'),
            success_cont =$(".success_cont"),
            error_cont = $(".error_cont");
            success_cont.hide();
            error_cont.hide(); 
            
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
                            success_cont.show().fadeOut(5000);
                            success_cont.html(data.message);
                            window.setTimeout(function () {
                                window.location.href = data.url;
                            }, 2000);

                    } else {
                        error_cont.show();
                        error_cont.html(nl2br(data.message));
                        $('#myform')[0].reset();
                    } 
            },
            error:function (){
                //alert('Something went wrong :-(');
                $(".loaders").fadeOut("slow");
            }
        });

    });

    function nl2br (str, is_xhtml) { 
        
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';      
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');  
    }  

    $(".morelink").click(function(){
        $("span.morecontent").slideDown("slow");
        $('.morelink').hide();
    });

 });

