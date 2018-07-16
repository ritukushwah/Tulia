
     <!-- Modal -->
         
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
                      <div class="pop-up-image">
                            <?php $img = $album_data->album_attachments; foreach ($img as $value) { ?>
        
                            <img src="<?php echo $value->album_image; ?>" alt="Image" />
                            <?php } ?>
                        
                      </div><!--/pop-up-image-->
                    </div>
                  </div>
                    <!--pop up detail-->
                    <div class="row pdnt-pop-head-time">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="detail-pop">
                          <!--head and time-->
                          <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="pop-detail-head">
                                <?php echo $album_data->album_title; ?>
                              </div><!--/pop-detail-head-->
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="pop-detail-time" style="text-align:right;">
                                <?php echo $album_data->album_title; ?>
                              </div><!--/pop-detail-time-->
                            </div>
                          </div>
                          <!--pop up detail para-->
                          <div class="pop-detail-para">
                            <p><?php echo $album_data->time_elapsed; ?></p>
                          </div><!--/pop-detail-para-->
                        </div><!--/detail-pop-->
                      </div>
                    </div>  
                </div>
                <div class="modal-footer bordr-top">
                  <div class="sbmt-btn" style="text-align:right;">
                    <a><button type="button" class="m-btn" data-dismiss="modal">Close</button></a>
                  </div>
                </div>
              </div>
            </div>
         
  <!--/pop up-->