 <!--blocks-->
     <?php if(!empty($data)){ ?>
     <?php foreach($data as $oneData){ ?>
    
      <a href="<?php echo site_url(); ?>home/Vendorpost/eventDetail/<?php echo encoding($oneData['id']); ?>"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="evnt-blck blck-tp">
          <!--detail sectn-->
            <div class="evnt-blck-dtl">
              <!--detail text section-->
              <div class="time-ago-evnt">
                <div class="evnt-hed-sec">
                <?php echo $oneData['event_name']; ?>
              </div><!--/evnt-hed-sec-->
                <div class="ago-evnt">
                  <?php echo $oneData['time_elapsed']; ?>
                </div><!--/ago-evnt-->
              </div><!--/time-ago-evnt-->              
               <!--posted by-->
            <div class="pstd-by">
              <!-- <p>Posted By</p> -->
              <div class="pstd-img">                
                <img src="<?php echo $oneData['user_image']; ?>" />
              </div>
              <div class="pst-by-pr-tm">
                <p><b><?php echo $oneData['fullName']; ?></b></p>


                <?php
                $string = $oneData['address']; ?>
                
                  <p><?php echo  wordwrap( substr($string,0,80),50,"<br>\n"); ?></p>
              </div><!--/pst-by-pr-tm-->
            </div><!--/pstd-by-->
              <!--end of detail text [user_image] section-->
              <!--other info-->
            <div class="evnt-info-lst">
              <ul>
                 <li>
                  <i class="fa fa-user"></i>No. of Guest<span><?php echo $oneData['guest_number']; ?></span>
                </li>
                 <li>
                 <?php if($oneData['budget_from'] == '10000+'){?>
                  Budget<span><?php echo $oneData['currency_symbol'].$oneData['budget_from']; ?></span>
                  <?php }else{ ?>
                  Budget<span><?php echo $oneData['currency_symbol'].$oneData['budget_from'].'-'.$oneData['currency_symbol'].$oneData['budget_to']; ?></span>
                  <?php } ?>
                </li>
              </ul>
            </div><!--/evnt-info-lst-->           
            </div><!--/evnt-blck-dtl-->
          <!--date sectn-->

            <div class="evnt-dte-sec">
              <div class="evnt-dtl-sec">
                <p class="mrgn-para"><?php echo date("M", strtotime($oneData['event_date'])); ?></p>
                <h6><?php echo date("d", strtotime($oneData['event_date'])); ?></h6>
                <p><?php echo date("Y", strtotime($oneData['event_date'])); ?></p>
                <p class="tme-dtl"><?php echo date("h:i a", strtotime($oneData['event_time'])); ?></p>
              </div><!--/evnt-dtl-sec-->
            </div><!--/evnt-dte-sec-->
        </div><!--/evnt-blck-->
      </div></a>
      <!--/blocks-->
      <?php } ?>
      
      <!--/blocks-->

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
          <?php } ?>