<!--review-->
<?php foreach ($user_reviews as $rows) { ?>

<div class="prfle-review">
    <ul>
        <li>
            <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="prfle-rev-img">
                            <img src="<?php echo $rows->user_image; ?>" alt="Image" />
                        </div><!--/prfle-rev-img-->
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10">
                        <div class="prfl-review-detail">
                            <div class="head-rate">
                                <div class="prfle-vendr-name">
                                <!-- name -->
                               
                                <?php echo $rows->fullName; ?>
                                </div><!--/prfle-vendr-name-->
                                <div class="rating prfle-vendor">
                                <!-- show vendor's rating here -->
                                <?php 
                                    $total_rating = intval($rows->rating); 
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
                            </div><!--/head-rate-->
                            <!--time of review-->
                            <div class="time-review">
                            <!-- time -->
                            <?php echo  date('d'.' '.'M'.' '.'Y', strtotime($rows->created_on)); //$rows->time_elapsed; ?>
                            </div><!--/time-review-->
                            <div class="review-para">
                            <!-- description -->
                            <?php echo $rows->review_description; ?>
                            </div><!--/review-para-->
                            <div class="revw-dlte">
                            <i style="cursor:pointer;" class="fa fa-trash" onclick="delData(<?php echo $rows->id; ?>)" data-toggle="modal" data-target="#exampleModal10"></i>
                            </div><!--/revw-dlte-->
                        </div><!--/prfl-review-detail-->
                    </div>
            </div>
        </li>
    </ul>
</div><!--/prfle-review-->


<?php } ?>
<!--pagination-->
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="vendor-pagination">
            <div class="vendor-page">
            <!-- pagination -->
            <?php echo $pagination; ?>
            </div><!--/vendor-page-->
        </div><!--/vendor-pagination-->
    </div>
</div>
<!--/pagination-->
<!--end of review-->

<script type="text/javascript">
    function delData(id){
        $('#next').attr('onclick',"deleteFunc("+id+",'home/users/','deleteReview')");
    }
</script>



<div class="modal fade" id="exampleModal10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Delete
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        Are you sure you want to delete this review ?
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top">
                    <button id="next" type="button" class="btn btn-primary del_btn">Yes</button>
                </div>                                                                      
            </div>
            <div class="bck-arrow-clr">
                <div class="arrow-bck close float" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Back</span>
                </div>
            </div><!--/bck-arrow-clr-->         
        </div>
    </div>
</div>


