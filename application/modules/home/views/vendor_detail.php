<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>
<section id="vendor-profile" class="sec-pad">
  <div class="container">
    <div class="row">
      <!--profile info-->
      <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="row">
          <!--profle-pic-->
          <div class="col-lg-12 col-md-12 col-sm-12">
            <!--profile pic sec-->
            <div class="profile-pic-sec">
              <img src="<?php echo $vendor_data->cat_image; ?>" alt="Image" />
            </div><!--/profile-pic-sec-->
             <!--user profile image and info-->
            <div class="prfle-img-info">
              <!--user image-->
              <div class="vndr-prfle-pic">
                <img src="<?php echo $vendor_data->thumbImage; ?>"/>
              </div><!--/vndr-prfle-pic-->
              <!--user info-->
              <div class="pflr-info-head pflr-info-head-mble">
              <input type="hidden" id="ven_cat_id" name="category_id" value="<?php echo $vendor_data->category_id; ?>">
                <h3><?php echo display_placeholder_text($vendor_data->fullName); ?></h3>
                <p class="phtgrphr-pad">
                    <input type="hidden" name="id" id="ven_id" value="<?php echo $vendor_data->id; ?>" >
                  <span><?php echo display_placeholder_text($vendor_data->category_name); ?></span>
                  <span> -<i class="fa fa-tag"></i><?php echo display_placeholder_text($vendor_data->price).' '.$vendor_data->currency_symbol; ?></span>
                </p>
                <p>
                  <span><i class="fa fa-map-marker"></i><?php echo display_placeholder_text($vendor_data->address); ?></span>
                </p>
                <p>
                    <?php echo display_placeholder_text($vendor_data->description); ?>
                </p>
              </div><!--/pflr-info-head-->
              <!--chat comment-->
              <div class="vndr-prfl-cht-rate vndr-prfl-cht-rate-mble rte-res-str">
                <div class="rating">
                   <!-- add vendor's review here -->

                        <?php
                        $total_rating = intval($vendor_data->rating); 
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
                    ?>
                </div>
                <a href="<?php echo site_url(); ?>home/users/chat/<?php echo encoding($vendor_data->id);  ?>">
                    <div class="chat-option cht-img-icn">
                        <!-- <i class="fa fa-comments"></i> -->
                        <img src="<?php echo $frontend_assets ?>img/chat1.png">
                    </div>
                </a>
              </div><!--/vndr-prfl-cht-rate-->
            </div><!--/prfle-img-info-->
            <!--/user profile image and info-->
          </div>
          <!--profile info--> 
        </div>
        <!--media and reviews-->
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div id="exTab1" class="med-rev-tab"> 
                <ul  class="nav nav-pills">
                  <li class="active">
                    <a  href="#1a" data-toggle="tab">Media</a>
                  </li>
                  <li>
                    <a href="#2a" onclick="pagination();" data-toggle="tab">Reviews</a>
                  </li>
                </ul>
                <div class="tab-content clearfix">
                  <!--media-->
                    <div class="tab-pane active" id="1a">
                        <div id="vendorMedia">
                            <!-- vendor's media -->
                        </div>
                    </div>
                  <!--no media-->
                  
                  <!--/end of no media-->
                  <!--reviews-->
                  <div class="tab-pane revw-pdng" id="2a">
                        <div id="vendorReview">
                            <!-- vendor's review -->
                        </div>
                  </div>
                </div>
                </div><!--/exTab1-->
            </div>
          </div>
        <!--end of media and reviews-->
      </div>
      <!--profile-info end-->
      <!--profile related vendors-->
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="relatd-head">
              <h6>Related vendors</h6><!--/vendoe-cate-->
        </div>
        <div id="realatedVendor">
            
        </div>
         
      <!--related item 2-->
     
      </div>
      <!--profile related vendors end-->
    </div>
  </div>
</section><!--/vendor-profile-->
<!--write your review pop up-->
  <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog frgt-pswd rev-str-frgt" role="document">
  <form method="POST" id="vendor_review" role="form" action="<?php echo base_url('home/users/addReview') ?>">
        <div class="modal-content">
           <div class="modal-header bg-img">
              <div class="frgt-head">
                Give Review
              </div><!--/frgt-head-->
            </div>
          <div class="modal-body">
            <div class="gve-rvw">
              <!--rate-->
              <div class="container">
                    <span class="star-cb-group">
                      <input type="radio" id="rating-5" name="rating" value="5" /><label for="rating-5">5</label>
                      <input type="radio" id="rating-4" name="rating" value="4" /><label for="rating-4">4</label>
                      <input type="radio" id="rating-3" name="rating" value="3" /><label for="rating-3">3</label>
                      <input type="radio" id="rating-2" name="rating" value="2" /><label for="rating-2">2</label>
                      <input type="radio" id="rating-1" name="rating" value="1" /><label for="rating-1">1</label>
                    </span>
                </div>
                      <input type="hidden" name="rating" value="" id="vendor_rating">
                      <input type="hidden" name="review_for" id="review_for" value="<?php echo $vendor_data->id; ?>" >
                     
              
              <div class="container">
                <div class="wrte-feedbck">
                  <div class="form-group lin-hgt">
                    <label class="fnt-wt mrgn-pz">Please Write Your Feedback here</label>
                    <textarea class="form-control rec-text" name="review_description" id="review_description" placeholder="" type="text" maxlength="200"></textarea>
                  </div><!--/form-group-->
                </div><!--/wrte-feedbck-->
              </div>
              <!--/rate-->
            </div><!--/gve-rvw-->
          </div>
         <div class="container">
            <div class="modal-footer brdr-top">
              <a href="javascript:void(0)"><button type="button" class="btn btn-primary m-btn add_review">Submit</button></a>
            </div>                                                                      
          </div>
          <div class="bck-arrow-clr">
              <div class="arrow-bck close float" data-dismiss="modal" >
                <i class="bck fa fa-arrow-left"></i><span> Back</span>
              </div>
        </div><!--/bck-arrow-clr-->
        </div>
    </form>
  </div>
</div>
<!-- end of review pop up -->

<script type="text/javascript">


    vendorAlbum(base_url + "home/users/vendor_album_list");
    function vendorAlbum(url)
    {   
        id = $('#ven_id').val(); 

            $.ajax({
                url: url,
                type: "POST",
                data:{page: url,id:id},              
                cache: false,   
                beforeSend: function() {
                    $('#loader').hide();
                   $("div#divLoading").addClass('show');
                },                          
                success: function(data){ 
                    $("div#divLoading").removeClass('show');
                    $("#vendorMedia").html(data);
                }
            });

    }


    function pagination(url = ''){ 
        if(url == ''){
        var url = base_url +"home/users/vendor_review_list";
    }
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


    // for getting review of vendor
   /* $(".rating input:radio").attr("checked", false);
    $('.rating input').click(function () {
        $(".rating label").removeClass('checked');
        $(this).parent().addClass('checked');
    });
    $('input:radio').change(function(){
        var userRating = this.value;
        $('#vendor_rating').val(userRating); 
    });*/


    
    $('[type*="radio"]').change(function () {
        var userRating = $(this);
        $('#vendor_rating').val(userRating.attr('value'));
        //console.log(userRating.attr('value'));
    }); 


    $(document).ready(function() {
        var url = base_url +"home/users/realated_vendor",
            ven_cat_id = $('#ven_cat_id').val(),
            ven_id = $('#ven_id').val(); 
        $.ajax({
            url: url,
            type: "POST",
            data:{page:url,cat_id:ven_cat_id,id:ven_id},              
            cache: false,   
            beforeSend: function() {
               $("div#divLoading").addClass('show');
            },                          
            success: function(data){ 
               
                $("div#divLoading").removeClass('show');
                $("#realatedVendor").html(data);
            }
        });
});


$('#review_description').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

</script>


