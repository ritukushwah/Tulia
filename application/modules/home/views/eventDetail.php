<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>
<!--my post detail page-->
<section id="mypst-dtl" class="sectn-pad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="row">
      <!--left side-->
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="row">
          <!--date sec-->
            <div class="gdlr-standard-style">
              <div class="blog-date-wrapper evnt-dte-wrpe-new gdlr-title-font evnt-blog-wrpr">
                <i class="fa fa-calendar">            
                </i>
                <div class="blog-date-day"><?php echo date('d', strtotime($data->event_date)); ?></div>
                <div class="blog-date-month"><?php echo date('M', strtotime($data->event_date)); ?></div>
                <div class="blog-date-year"><?php echo date('Y', strtotime($data->event_date)); ?></div>
              </div><!--/blog-date-wrapper gdlr-title-font-->
              <!--img section-->
              <div class="blog-content-wrapper">
                 <div class="gdlr-blog-thumbnail">
                  <img src="<?php echo $data->cat_image; ?>" />
                </div><!--/gdlr-blog-thumbnail-->
                <!--heading-->
                <div class="blog-content-inner-wrapper envt-new-wrper">
                  <header class="post-header">
                      <h3 class="gdlr-blog-title">
                       <?php echo $data->event_name; ?>
                      </h3>                      
                    <!--other info-->
                    <div class="detl-info">
                      <span><i class="fa fa-clock-o"></i><?php echo date('h:i A', strtotime($data->event_time)); ?></span>
                      <!-- <span>/</span> -->
                      <!-- <span><i class="fa fa-phone"></i>+2145789632</span> -->
                      
                      <span>/</span>
                      <span><i class="fa fa-user"></i><b>No.of Guest</b> :<?php echo $data->guest_number; ?></span>
                      <span>/</span>
                       <span><b>Budget</b> :<?php if($data->budget_from == '10000+'){?>
                  <?php echo $data->currency_symbol.$data->budget_from; ?>
                  <?php }else{ ?>
                  <?php echo $data->budget_from.'-'.$data->budget_to.' '. $data->currency_symbol; ?>
                  <?php } ?></span>
                  <span>/</span>
                      <span><i class="fa fa-map-marker"></i><?php echo $data->address; ?></span>
                    </div><!--/detl-info-->
                    <div class="detl-info">
                      
                    </div><!--/detl-info-->                    
                  </header><!--/post-header-->
                  <!--detail description-->
                  <div class="dtail-dscrptn evnt-dtail-descrptn">
                    <p><?php echo $data->description; ?></p>
                  </div><!--/dtail-dscrptn-->            
                </div><!--/blog-content-inner-wrapper-->
              </div><!--/blog-content-wrapper-->
            </div><!--/gdlr-standard-style-->
        </div>
        <!--info detail head-->        
      </div>
      <!--right side-->
      <a href="#">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="profile-evnt-detl">
                <div class="prfl-evt-img">
                  <img src="<?php echo $data->user_image; ?>" />
                </div><!--/prfl-evt-img-->
                <div class="prfle-evnt-nme">
                  <?php echo $data->fullName; ?>
                  <p><?php echo $data->email; ?><span>|</span><span><?php echo $data->contact_number; ?></span></p>
                  <p> <?php if($data->usrAdd != ''){ ?>
                    <p><?php echo $data->usrAdd; ?></p>
                  <?php }else{ ?>
                    <p>NA</p>
                  <?php } ?></p>
                </div><!--/prfle-evnt-nme-->
            </div><!--/profile-evnt-detl-->
                <!--i am doing this evnt-->
               <!--i am doing this evnt-->
                <?php if($data->is_doing == 0){ ?>
                <div class="dng-evnt"><a href="javascript:void(0)" onclick="eventDoing(<?php echo $data->id; ?>)"><button type="button" class="m-btn am_doing" >I am doing this event</button></a></div><!--/dng-evnt-->
                <?php } ?>
                <div class="edit-dlte-mypst-dtl evnt-dtl">
                  <a href="<?php echo site_url(); ?>home/users/chat/<?php echo encoding($data->post_author);  ?>">
                   <img class="cht-sze" src="<?php echo $frontend_assets ?>img/chat1.png"></a>
                </div><!--/edit-dlte-mypst-dtl-->
          </div>
      </a>
    </div>
      </div>
    </div>
    
  </div>
</section><!--/mypst-dtl-->
<!--event detail sectn end-->
 

 <script type="text/javascript">

    jQuery.fn.visible = function() {
        return this.css('visibility', 'visible');
    };

    jQuery.fn.invisible = function() {
        return this.css('visibility', 'hidden');
    };



    function eventDoing(id) {
        //$(".am_doing").invisible();
        $(".am_doing").attr('disabled','disabled');
        var url = base_url+"/home/Vendorpost/eventDoing";
        $.ajax({
            type: "POST",
            url: url,
            data: {post_id:id},
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
                    toastr.error(data.message);
                } 
            },
            error:function (){
                $(".loaders").fadeOut("slow");
            }
        });
            
    }
 </script>

