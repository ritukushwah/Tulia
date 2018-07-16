
<?php

    if(!empty($notify_list)){ 
        foreach ($notify_list as $value) { ?>
        <li class="notn-li"> 
        <?php if($value->notification_type == 'user_review' ){ ?>
       
        <a href="<?php echo site_url(); ?>home/users/vndrReview/<?php echo encoding($value->notification_message->reference_id); ?>">
           
            <?php }else if($value->notification_type == 'post_create'){ ?>
                
                <a href="<?php echo site_url(); ?>home/Vendorpost/eventDetail/<?php echo encoding($value->notification_message->reference_id); ?>">
  
                <?php }else{ ?>
                    <a href="<?php echo site_url(); ?>home/posts/postDetail/<?php echo encoding($value->notification_message->reference_id); ?>">
                <?php } ?>
       
                <div class="notfcn-lst">
                    <div class="notfn-img">
                        <img src="<?php echo $value->user_image; ?>" alt="Image" />
                    </div><!--/notfn-img-->
                    <div class="notfn-detl">
                        <h6><?php echo $value->fullName; ?></h6>
                        <p class="notn-sub-hed eve-col"><?php echo $value->notification_message->title; ?></p>
                        <p class="notn-sub-text"><?php echo $value->notification_message->body; ?></p>
                    </div><!--/notfn-detl-->
                </div><!--/notfcn-lst-->
                <div class="time-notn">
                    <?php echo $value->time_elapsed; ?>
                </div><!--/time-notn-->
            </a>
        </li>
<?php } }else{ ?>
    <li class="notn-li">
        <a href="#">
            <div class="notfcn-lst no-lit">
               <div class="no-notifcn">
                   <i class="fa fa-bell-slash"></i>
               </div> 
               <div class="no-noti-text">
                   No Notification Available
               </div>
            </div><!--/notfcn-lst--> 
        </a>
    </li>
<?php } ?>

