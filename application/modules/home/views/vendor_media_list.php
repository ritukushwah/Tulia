
<?php 

    $frontend_assets =  base_url().'frontend_asset/';

  if(!empty($album_list)){ ?>
   
    
    <div class="prfle-vndr-gal">
      <div class="row"><?php foreach ($album_list as $album) { 
        $id = $album->id; 
    ?>  
      <div class="col-lg-6 col-md-6 col-sm-12" >
                
                <ul id="relative-caption-<?php echo $id ?>"   data-sub-html=".caption3" class="list-unstyled row prfle-gallery">
                    <?php 
                        $img = $album->album_attachments; 
                        $RK = 0;
                        foreach ($img as $value) { 
                         ?>
                    <?php
                        if($RK == 0){
                            $sh = 'show';
                        }else{
                            $sh = 'none';
                        }
                    ?>
                
                <li style="display: <?php echo $sh; ?>;" class="relative-caption" data-src="<?php echo $value->album_image ;?>"  data-sub-html=".caption3" >
                        <a href="">
                            <img class="img-responsive" src="<?php echo $value->album_image ;?>" >
                            
                        </a>
                         <div class="caption3" style="display:none">
                <h4><?php echo ucfirst($album->album_title) ;?></h4><p><?php echo ucfirst($album->album_description) ;?></p>
                </div> 
                    </li>  
                    <?php $RK++; } ?>
                </ul>
                <script type="text/javascript">
                    $('#relative-caption-<?php echo $id ?>').lightGallery({
                        subHtmlSelectorRelative: true,
                        addClass: 'fixed-size',
                        download: false
                       
                    }); 
                    
                </script>
 
        </div> <?php  } }else{ ?>
    <div class="no-media-sec">
        <div class="no-media-icn">
            <img src="<?php echo $frontend_assets ?>img/no-media-icn2.png" alt="Image" width="80px" />
        </div><!--/no-media-icn-->
        <div class="no-mdia-text">
            No Media Available
        </div><!--/no-mdia-text-->
    </div><!--/no-media-sec-->
 <?php } ?>
      </div>
    </div><!--/prfle-vndr-gal-->


    <!--pagination-->
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="vendor-pagination">
                <div class="vendor-page pagi-brdr">
                    <?php echo $pagination; ?>
                </div><!--/vendor-page-->
            </div><!--/vendor-pagination-->
        </div>
    </div>
    <!--/pagination-->



<script type="text/javascript">

    function media(id){

        var url = base_url +"home/users/albumData";
        $.ajax({
            url: url,
            type: 'POST',
            data: {page:url,id:id},
            beforeSend: function () {
                
            },
            success: function (data, textStatus, jqXHR) {
              
                
                
            }
        });

    }

    $('#relative-caption').lightGallery(); 

    
/*    
    $('.relative-caption').click(function(){ 
        $("#bck-t-img").hide();
    }) 

    $('.lg-close').click(function(){ 
        $("#bck-t-img").show();
    })*/

   
</script>