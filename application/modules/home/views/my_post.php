<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>

<!--my post-->
<section id="my-post" class="sectn-pad2">
    <div class="container">
        <!--create button-->  
        <div class="col-lg-8 col-lg-offset-2 col-md-12 col-xs-12">
            <a href="<?php echo site_url(); ?>home/posts/addPost"><div class="btn-add-pst">
                <button class="btn-1 icon-plus"><span>Create Post</span></button>
            </div></a><!--/btn-add-pst-->
        </div> 
        <!--button for create-post-->
        <div id="ajaxData">
            
        </div>
    </div>
</section>

<script type="text/javascript">
    
   
    pagination(base_url + "home/posts/postList/");
    function pagination(url)
    {   
        $.ajax({
            url: url,
            type: "POST",
            data:{page: url},              
            cache: false,   
            beforeSend: function() {
               //show_loader(); 
            },                          
            success: function(data){ 
               //hide_loader(); 
                $("#ajaxData").html(data);
            }
        });

    }

</script>