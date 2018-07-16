
<section id="vndr-rvw" class="sectn-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-1">
                <input type="hidden" name="id" id="ven_id" value="<?php echo $ven_id; ?>">
                <div id="vendorReview">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    pagination(base_url + "home/users/review_list/");
    function pagination(url){ 
            id = $('#ven_id').val(); 
        $.ajax({
            url: url,
            type: "POST",
            data:{page:url,id:id},              
            cache: false,   
            beforeSend: function() {
                $('#loader').hide();
               $("div#divLoading").addClass('show');
            },                          
            success: function(data){ 
                $("div#divLoading").removeClass('show');
                $("#vendorReview").html(data);
            }
        });
    }
    
</script>