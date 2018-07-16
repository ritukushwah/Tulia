<!---Contact Start Here--> 
<?php
        $frontend_assets =  base_url().'frontend_asset/';

?>
<section id="ad-post-sec" class="sectn-pad2">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!--start adpost sectn-->
  <div class="container">
    <div class="row vertical-align adpst-ver pstn-row">
        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="left-blck-crte">
              <div class="rgstrn-icn" style="text-align:center;">
                <img src="<?php echo $frontend_assets ?>img/marry-me.png" alt="Image" />
              </div><!--/rgstrn-icn-->
              <div class="crte-post-head">
                Update Post
              </div><!--/crte-post-head-->
              <div class="border-post" style="text-align:center;">
                <img src="<?php echo $frontend_assets ?>img/heading-bg-white.png" alt="Image" />
              </div><!--/border-post-->
              <div class="crte-post-para">
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo.</p>
              </div><!--/crte-post-para-->
            </div><!--/left-blck-crte-->
        </div>    
        <div class="col-lg-8 col-md-8 col-xs-12 pdng-adpst">
            <div class="row">
                <!--try-->
                 <div class="contact-box">
        <div class="contact-us Updte1">
          <form method="POST" id="create_post" role="form" action="<?php echo base_url('home/posts/updatePost') ?>">

            <div class="row columnheight">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
              <label class="label-deco">Category</label>
              <input class="form-control add-post-frm" type="text" value="<?php echo $post_detail->category_name;?>" readonly>
              
              </select>
            </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
              <label class="label-deco">No. of Guest</label>
              <select class="form-control add-post-frm" id="guest_number" name="guest_number">
                <option class="guest" value="<?php echo $post_detail->guest_number;?>"></option>
                <option>0 - 25</option>
                <option>25 - 50</option>
                <option>50 - 100</option>
                <option>100 - 200</option>
                <option>200 - 300</option>
                <option>300 - 400</option>
                <option>400 - 500</option>
                <option>500+</option>
              </select>
            </div>
            </div>

            <div  class="col-lg-6 col-md-6 col-sm-12">
            
            <div class="form-group" onclick="showCal()" id="demoDiv" style="display: show;" > 
              <label class="label-deco">Event Date</label>
              <div class='input-group date'>
                    <input type='text' class="form-control add-post-frm" placeholder=""  id='showDate' name="" value="<?php echo $post_detail->event_date;?>" readonly onclick="clrText();">
                    <span id="timeErr" style="color: red;font-weight: 600;"></span>
                    <span class="input-group-addon back-none">
                        <span class="fa fa-calendar"></span>
                    </span>
              </div>
            </div>
            <div class="" id="calDiv" style="display: none;">
              <div class="form-group"> 
              <label class="label-deco">Event Date</label>
              <div class='input-group date'>
                    <input type='text' class="form-control add-post-frm" placeholder=""  id='datetimepicker1' name="event_date" value="<?php echo $post_detail->event_date;?>" readonly onclick="clrText();">
                    <span id="timeErrr" style="color: red;font-weight: 600;"></span>
                    <span class="input-group-addon back-none">
                        <span class="fa fa-calendar"></span>
                    </span>
              </div>
            </div>
            </div>
            </div>


             <!--<div id="calDiv" style="display: none;" class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group"> 
              <label class="label-deco">Event Date</label>
              <div class='input-group date'>
                    <input type='text' class="form-control add-post-frm" placeholder=""  id='datetimepicker1' name="event_date" value="<?php echo $post_detail->event_date;?>" readonly onclick="clrText();">
                    <span id="timeErrr" style="color: red;font-weight: 600;"></span>
                    <span class="input-group-addon back-none">
                        <span class="fa fa-calendar"></span>
                    </span>
              </div>
            </div> 
            </div>-->


            <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group"> 
              <label class="label-deco">Event Time</label>
              <div class='input-group date' >
                    <input type='text' class="form-control add-post-frm" placeholder="" id='datetimepicker3' name="event_time" value="<?php echo $post_detail->event_time;?>" readonly onclick="clrText();">
                    <span id="dateErr" style="color: red;font-weight: 600;"></span>
                    <span class="input-group-addon back-none">
                        <span class="fa fa-clock-o"></span>
                    </span>
                </div>
            </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group"> 
              <label class="label-deco">Event Type</label>
             <select class="form-control add-post-frm" id="event_type" name="event_type">
                    <option value="<?php echo $post_detail->event_type;?>"><?php echo $post_detail->event_name;?></option>
                    <?php foreach ($event_type as $rows) { ?>
                    <option value="<?php echo $rows['id'] ?>"><?php echo $rows['event_name']; ?></option>
                <?php } ?>
              </select>
            </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group"> 
                <label class="label-deco">Currency</label>
                <select class="form-control add-post-frm bck-img" id="currency_symbol" name="currency_symbol">
                    <?php $url = APPPATH.'third_party/currency.json'; 
                          $jsonData = json_decode(file_get_contents($url)); 
                          foreach ($jsonData as $key => $value) {
                            if($value->code == $post_detail->currency_code)
                            {   
                                $currency_symbol = $value->name_plural; 
                            }
                        } ?>
                               
                  <option value="<?php echo $post_detail->currency_code; ?>"><?php echo $currency_symbol.'('.$post_detail->currency_symbol.')'; ?></option>

                  <?php foreach ($jsonData as $key => $val) { ?>
                  <option value="<?php echo $val->code; ?>"><?php echo $val->name_plural .' ( '.$val->symbol.')'; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">      
              <label class="label-deco">Budget</label>
            <div class="row mrgn-btm mrl">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">                   
                  <select class="form-control add-post-frm" id="budget_from" name="budget_from">
                    <option id="1" value="<?php echo $post_detail->budget_from;?>" ></option>
                    <option id="2" class="clsTo500" value="500">500</option>
                    <option id="3" class="clsTo1000" value="1000">1000</option>
                    <option id="4" class="clsTo2000" value="2000">2000</option>
                    <option id="5" class="clsTo3000" value="3000">3000</option>
                    <option id="6" class="clsTo4000" value="4000">4000</option>
                    <option id="7" class="clsTo5000" value="5000">5000</option>
                    <option id="8" class="clsTo6000" value="6000">6000</option>
                    <option id="9" class="clsTo7000" value="7000">7000</option>
                    <option id="10" class="clsTo8000" value="8000">8000</option>
                    <option id="11" class="clsTo9000" value="9000">9000</option>
                    <option id="12" class="clsTo10000" value="10000">10000</option>
                    <option id="13" class="clsTo10000+" value="10000+">10000+</option>
                  </select>
                </div>
              </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group"> 
                   <select class="form-control add-post-frm" id="budget_to" name="budget_to" >
                    <option class="clsTo" id="To1" value="<?php echo $post_detail->budget_to;?>"></option>
                    <option class="clsTo" id="To2" value="500">500</option>
                    <option class="clsTo" id="To3" value="1000">1000</option>
                    <option class="clsTo" id="To4" value="2000">2000</option>
                    <option class="clsTo" id="To5" value="3000">3000</option>
                    <option class="clsTo" id="To6" value="4000">4000</option>
                    <option class="clsTo" id="To7" value="5000">5000</option>
                    <option class="clsTo" id="To8" value="6000">6000</option>
                    <option class="clsTo" id="To9" value="7000">7000</option>
                    <option class="clsTo" id="To10" value="8000">8000</option>
                    <option class="clsTo" id="To11" value="9000">9000</option>
                    <option class="clsTo" id="To12" value="10000">10000</option>
                    <option class="clsTo" id="To13" value="10000+">10000+</option>
                  </select>
                </div>
              </div>
            </div>
            </div>
               <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="form-group">
                 <label class="label-deco">Phone Number</label>
                <input type="hidden" name="id" value="<?php echo $post_detail->id;?>">
                <input class="form-control add-post-frm" id="contact_number" name="contact_number" placeholder="" value="<?php echo $post_detail->contact_number;?>" type="text">
              </div>
            </div>           
            <div class="col-lg-6 col-md-6 col-sm-12 showLeft">            
            <div class="form-group"> 
                <label class="label-deco">Address</label>
                <input class="form-control add-post-frm" id="address" name="address" placeholder="" type="text" value="<?php echo $post_detail->address;?>">
                <input type="hidden" id="latitude" name="latitude" value="<?php echo $post_detail->latitude;?>" />
                <input type="hidden" id="longitude" name="longitude" value="<?php echo $post_detail->longitude;?>" />
            </div>
          </div>
           <div class="col-lg-12 col-md-12 col-sm-12">
             <div class="form-group"> 
               <label class="label-deco">Description</label>
               <textarea class="form-control add-post-frm desc" id="description" name="description" rows="3" placeholder=""><?php echo $post_detail->description;?></textarea>
            </div>
           </div>
           <div class="col-lg-12 col-md-12 col-sm-12 sbmt-btn">
            <button type="button" class="m-btn sbmt-btn update_post">Update</button>
          </div>
          </form>
    </div><!--/contact us-->
      </div>
                <!--/try-->
            </div>
        </div>        
    </div><!--/vertical-align-->
</div>
    </div>
  </div>

</section><!--/ad-post-sec-->
<!---Contact End Here-->


<script>
    var today = new Date();
    var defaultDate = $(this).attr("data-date");
    $(function () {
      
        $('#datetimepicker1').datetimepicker({
          format:'YYYY-MM-DD',
          showClear: true,
          ignoreReadonly: true,

        });
    });
    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'HH:mm',
            ignoreReadonly: true
        });
    });

  
    function clrText(){
        $('#dateErr').text('');
        $('#timeErr').text('');
        $('#timeErrr').text('');
    }

    
    function checkTime(){

        var month = (today.getMonth()+1);
        var date = today.getFullYear()+'-'+((month < 10) ? '0'+month : month)+'-'+today.getDate(); 
        var time = today.getHours() + ":" + today.getMinutes(); 
        var t =  $('#datetimepicker3').val();  
        var d = $('#datetimepicker1').val(); 

        if(date == d){
            if(t <= time){
                $('#dateErr').text('Please select valid time');
                return false;
            }
            return true;
        }else if(d <= date){
            $('#timeErr').text('Please select valid date'); 
            $('#timeErrr').text('Please select valid date'); 
            return false;
        }
        return true;
    }


    function showCal(){
        $('#demoDiv').hide();
        $('#calDiv').show();
        $('#datetimepicker1 ').data("DateTimePicker").show();
    }

    function initialize() 
    {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById("address"));
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace(); 
            var latitude = place.geometry.location.lat(),
            longitude = place.geometry.location.lng(); 
            if(latitude != '' && longitude != ''){
                $("#latitude").val(latitude);
                $("#longitude").val(longitude);
                // place.geometry  -- this is used to detect whether User entered the name of a Place that was not suggested and pressed the Enter key, or the Place Details request failed.
            }else{ 
                toastr.error('This is not a valid address');
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); //initialise google autocomplete API on load
    

    $("#address").on('keyup', function() {
        
        $("#latitude").val('');
        $("#longitude").val('');
    
    });


    $("#budget_from").change(function(){

        $('#budget_to').removeAttr("disabled") ;
        $('.clsTo').removeAttr("disabled") ;
        $('.clsTo').css({"color":"black"});
        $('#budget_to').val('') ;

        budget_from = $(this).find(":selected").val();
        id = $(this).find(":selected").attr("id");
        for (i = id; i >= 0; i--) {
            $('#To'+i).prop('disabled', 'disabled');
            $('#To'+i).css({"color":"#eeeeee"});
        } 
    })


    var budget_from = '<?php echo $post_detail->budget_from;?>'; 
    $('#budget_from').find('option').each(function(i,e){ 
            //console.log($(e).val());
            if($(e).val() == budget_from){
                $('#budget_from').prop('selectedIndex',i);
        }
    });


    var budget_to = '<?php echo $post_detail->budget_to;?>'; 
    $('#budget_to').find('option').each(function(i,e){ 
            //console.log($(e).val());
            if($(e).val() == budget_to){
                $('#budget_to').prop('selectedIndex',i);
        }
    });


    for (i = $(".clsTo"+budget_to).attr('id') - 1;  i >= 0; i--) {
            $('#To'+i).prop('disabled', 'disabled');
            $('#To'+i).css({"color":"#eeeeee"});
    } 

    var guest_number = '<?php echo $post_detail->guest_number;?>';
    $('#guest_number').find('option').each(function(i,e){ 
            //console.log($(e).val());
            if($(e).val() == guest_number){
                $('#guest_number').prop('selectedIndex',i);
        }
    });

    var budget_from = '<?php echo $post_detail->budget_from; ?>';
    if(budget_from == '10000+'){
        $('#budget_to').prop('disabled', 'disabled');
    }

    $('#description').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

</script>



