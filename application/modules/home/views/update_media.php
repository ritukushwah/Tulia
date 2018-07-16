
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog frgt-pswd" role="document">
      <div class="modal-content">
         <div class="modal-header bg-img">
            <div class="frgt-head">
               Update Media
            </div>
            <!--/frgt-head-->
         </div>
         <div class="modal-body modal-frgt-body">
            <div class="container">
               <!--add media sectn-->
               <div class="media-img-sectn">
                  <div id="apndDiv"  >
                  </div>
                  <!--/mdi-img-upld-->
                    <div id="preData">
                         <?php $img = $album_images->album_attachments;
                            foreach ($img as $val) { ?>
                            <div  class="mdi-img-upld mrgn-mdia medi-upld-sze">
                               <img src="<?php echo $val->album_image; ?>" />
                            </div>
                      
                         <?php  } ?>
                     </div>
                     <div id="imgBtm" class="medi-upld-sec">
                        <div class="add-mdia-icn">
                           <div class="text-center upload_pic_in_album"> 
                              <label id="imageFoc" for="file-1" class="upload_pic">
                              <span class="fa fa-upload"></span></label>
                           </div>
                        </div>
                     </div>
               </div>
               <!--/media-img-sectn-->
               <p id="errorImg" style="color:red;" ></p>
               <!--/add media sectn-->
               <!--/view preview-->
               <!--end of add media-->
               <div class="form-group">
                  <label class="label-deco">Title</label>
                  <input maxlength="50" id="album_title" class="form-control add-post-frm" name="album_title" placeholder="" type="text" value="<?php echo $album_images->album_title; ?>">
                  <p id="errorTit" style="color:red;" ></p>
               </div>
               <div class="form-group">
                  <label class="label-deco">Description</label>
                  <textarea maxlength="200" id="album_description" class="form-control add-post-frm bordr-media" name="album_description" placeholder="" type="text"><?php echo $album_images->album_description; ?></textarea>
                  <p id="errorDes" style="color:red;" ></p>
               </div>
            </div>
         </div>
         <!--/modal-frgt-body-->
         <div class="container">
            <div class="modal-footer brdr-top">
               <a onclick="updateAlbum()" href="javascript:void(0)"><button type="button" class="btn btn-primary m-btn">Update</button></a>
            </div>
         </div>
         <div class="bck-arrow-clr">
            <div class="arrow-bck close float" data-dismiss="modal" >
               <i class="bck fa fa-arrow-left"></i><span> Back</span>
            </div>
         </div>
         <!--/bck-arrow-clr-->         
      </div>
   </div>
</div>


<input type="hidden" id="imageCount" value="1" >
<input type="hidden" id="album_id" value="<?php echo $album_images->id; ?>" >
<input accept="image/*" class="inputfile hideDiv" id="file-1" name="album_images[]" onchange=" addimagePre(this.files)" style="display: none;" type="file" multiple>

<script type="text/javascript">

    function addimagePree(img){


        var imageCount = $('#imageCount').val();
        $('#apndDiv').append('<div  class="mdi-img-upld mrgn-mdia"><img id="pImg'+imageCount+'" src="https://images.inuth.com/2017/05/1ranbirkapoorsexywallpaper.jpg" /></div>')

        var forfor = Number(imageCount)+1;
        document.getElementById("imageFoc").setAttribute("for", "file-"+forfor);
        document.getElementById('pImg'+imageCount).src = window.URL.createObjectURL(img);

        if($('#imageCount').val() == 4){
            document.getElementById('imgBtm').style.display = 'none';
        }else{
            $('#imageCount').val( Number($('#imageCount').val())+1);
        }
    }  


    function addimagePre(img){

        $('#preData').hide();
        $('#errorImg').html('');
        $('#apndDiv').html('');
        if(img.length > 4){
            $('#errorImg').html('Select max 4 image');
        }else{
            for (i = 0; i < img.length; ++i) {
                $('#apndDiv').append('<div  class="mdi-img-upld mrgn-mdia medi-upld-sze"><img id="pImg'+i+'" src="https://images.inuth.com/2017/05/1ranbirkapoorsexywallpaper.jpg" /></div>');
                document.getElementById('pImg'+i).src = window.URL.createObjectURL(img[i]);
            }
        } 
    }


    function updateAlbum(){

        $('#errorTit,#errorDes,#errorImg').html('');
        var formData = new FormData(); // Currently empty
        var imageSelect = 0;
        var writeText = 1;
        var titleText = $('#album_title').val();
        var descriptionText = $('#album_description').val();

        if($.trim(titleText) == ''){
            var writeText = 0;
            $('#errorTit').html('Please insert title');
        }

        if($.trim(descriptionText) == ''){
            var writeText = 0;
            $('#errorDes').html('Please insert descriptionText');
        }

        var file_data1 = $('#file-1')[0].files; 

       
        if (file_data1){
            imageSelect = 1;
        }

        for (i = 0; i < file_data1.length; ++i) {
            formData.append("album_images[]", file_data1[i]);
        }

        formData.append('album_title', titleText);
        formData.append('album_description', descriptionText);
        formData.append('album_id', $('#album_id').val());


        if(imageSelect == 1){
            if(writeText == 1){
                if(file_data1.length > 4){
                    $('#errorImg').html('Select max 4 image');
                }else{
                    show_loader(); 
                    var url = base_url + "home/Vendorpost/update_media";
                    $.ajax({
                    url: url,
                    type: "POST",
                    data:formData, 
                    dataType: "json",             
                    cache: false,   
                    processData: false,
                    contentType: false,  
                    success: function(data){ 
                        hide_loader();
                        

                          if (data.status == 1){ 
                            $('#update_modal').click();
                            toastr.success(data.message);
                            window.setTimeout(function () {
                                 window.location.href = data.url;
                            }, 2000);

                        }else if(data.status == -1){
                            toastr.error(data.message);
                            window.setTimeout(function () {
                                window.location.href = data.url ;
                            }, 1000); 
                        } else {
                                $('#update_modal').click();
                                toastr.error(data.message);
                                //$('#edit_profile')[0].reset();
                        }
                      
                        }
                    });
                }
            }
        }else{
            $('#errorImg').html('Please select image');
        }
   }

    $('#album_title').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

    $('#album_description').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });


</script>