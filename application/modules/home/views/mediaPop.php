
<input type="hidden" id="imgCount" value="<?php echo count($album->album_attachments); ?>">
<div class="modal-dialog cstm-width" role="document">
      <div class="modal-content">
         <div class="modal-header bordr-btm">
            <div class="close-btn-bordr">
               <button type="button" class="close cstm-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
         </div>
         <div class="modal-body">
            <div class="row">
               <!--pop up image-->
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div id="abc" class="pop-up-image detl-img">
                     <?php 
          
                    for ($i = 0; $i < count($album->album_attachments); $i++) {
                      $imgS = 'none';
                      if($i == 0){
                        $imgS = 'nonee';
                      }
                      ?>
                        <img id="imagec<?php echo $i; ?>" class="hideImge" style="display:<?php echo $imgS; ?>" src="<?php echo $album->album_attachments[$i]->album_image; ?>" alt="Image"  />
                    <?php } ?>
 
                  </div>
    
                    <?php if(count($album->album_attachments) != 1){ ?>
                        <button onclick="imageC(1);" class="prvd round lft-rnd"><i class="fa fa-angle-left"></i></i></button>
                        <button onclick="imageC(2);" class="prvd round btnSide rgt-rnd"><i class="fa fa-angle-right"></i></i></button>

                     <?php   } ?>
                  
                  <!--/pop-up-image-->
               </div>
            </div>
            <!--pop up detail-->
            <div class="row pdnt-pop-head-time">
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="detail-pop">
                     <!--head and time-->
                     <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9 pop-pad">
                           <div class="pop-detail-head">
                              <?php echo $album->album_title; ?>
                           </div>
                           <!--/pop-detail-head-->
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                           <div class="pop-detail-time" style="text-align:right;">
                              <?php echo $album->time_elapsed; ?>
                           </div>
                           <!--/pop-detail-time-->
                        </div>
                     </div>
                     <!--pop up detail para-->
                     <div class="pop-detail-para">
                        <p><?php echo $album->album_description; ?></p>
                     </div>
                     <!--/pop-detail-para-->
                  </div>
                  <!--/detail-pop-->
               </div>
            </div>
         </div>
         <div class="modal-footer bordr-top">
            <!--edit and logout btn-->
            <div class="col-lg-12 col-md-12 col-sm-12">
               <div class="edit-dlte">
                  <p>
                     <a href="javascript:void(0)" onclick="updateMedia(<?php echo $album->id; ?>)"><span><i class="fa fa-edit"></i></span></a>
                     <a href="javascript:void(0)" data-toggle="modal" onclick="deleteMedia(<?php echo $album->id; ?>)" data-target="#exampleModal9"><span class="pad-dlt-rgt"><i class="fa fa-trash"></i></span></a>
                  </p>
               </div>
               <!--/edit-dlte-->
            </div>
            <!--end of edit and logout-->
         </div>
      </div>
   </div>

   <div id="openModal">
       
   </div>
<script type="text/javascript">
    
    function updateMedia(id){
        var url = base_url + "home/Vendorpost/updateAlbum";
        $.ajax({
            url: url,
            type: "POST",
            data:{id:id},              
            cache: false, 
            success: function(data){ 
              $('#openModal').html(data);
              $('#update_modal').modal('show');
            }
        });
    }

</script>