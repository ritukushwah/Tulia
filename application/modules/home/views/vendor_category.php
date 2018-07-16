<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>
<!--vendor category-->
<section id="content" class="site-content sec-pad">
    <div class="container content-container">
    <div class="row mrgn-btm">
        <!--left portion-->
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div id="sidebar" class="sidebar" role="complementary">
                <header class="vendor-cate-head cat-heading">
                    <h2 id="show_cat" class="vendoe-cate head-clr">
                        
                    </h2><!--/vendoe-cate-->
                </header>
                <aside id="electro_product_categories_widget-1" class="widget woocommerce widget_product_categories electro_widget_product_categories">
                    <ul id="cat_val" class="product-categories category-single">
                        <!--side bar categories-->
                        <?php 
                        $i=0;
                        foreach ($category as $cat) { 
                                $ids = $cat['id'];  $act_cls = '';
                                if($i==0)
                                    $act_cls = 'active';
                            ?>
                            <a  href="javascript:void(0)" data-category-id="<?php echo $ids ?>" >
                            <li id="cat-item" class="cat-item cat-item-81 current-cat <?php echo $act_cls ?>">          
                            <span class="child-indicator open"></span>
                                <?php echo $cat['name']; ?>             
                            </li><!--/cat-item cat-item-81 current-cat-->
                        </a>  
                        <?php $i++; } ?>
                    </ul>
                </aside><!--/electro_product_categories_widget-1-->
            </div><!--/sidebar-->
        </div>
    <!--side bar end-->
    <!--right-portion-->
    <div class="col-lg-9 col-md-9 col-sm-12">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <section>
                <header class="vendor-cate-head">
                    <div class="row">
                        <!--search box-->
                        <div class="wrap">
                            <div class="search">
                                <input type="text" name="search_name" id="search_name" class="searchTerm vendor-search" placeholder="Search Vendor"  />
                                <button class="searchButton">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="woocommerce columns-3">
                    <ul class="product-loop-categories">
                        <!--first vendor-->
                        <div class="scroller ven_loader" style="display:none">
                            <img height="100" width="100" src="<?php echo $frontend_assets ?>img/tulia-loader.gif"> 
                        </div>
                        <div id="ajaxData"></div>
                    </ul><!--/product-loop-categories-->
                </div><!--/woocommerce columns-3-->
               
                </div>
            </section>
        </main><!--/site-main-->
    </div><!--/content-area-->
    </div>
    </div><!--/content-container-->
</section><!--/content-->

<script type="text/javascript">
 
        
    var currentRequest;
    $('#search_name').keyup(function() {
        $("#ajaxData").html('');
        pagination(base_url +"home/users/vendor_cat_list/");
    });
        

    pagination(base_url +"home/users/vendor_cat_list/");
    function pagination(url){

        var search_name= $('#search_name').val(),
            cat_id = $("#cat_val li.active").parent('a').attr('data-category-id');
        $('#loader').hide();
    

        var currentRequest = $.ajax({
            url: url,
            type: "POST",
            data:{page: url,id:cat_id,search_name:search_name},              
            cache: false,   
            beforeSend: function() {
                if(currentRequest != null) {
                    currentRequest.abort();
                }
                $('.scroller').show();
                //$("#ajaxData").html('');
            },                          
            success: function(data){ 
                $('.scroller').hide();
                $("#ajaxData").html(data);
                $("#ven_cat").addClass("active");
            }
        });
    }

    $('body').on('click', "#cat_val li", function (event) {
        $("#ajaxData").html('');
        var _that = $(this),
            cat_name = _that.text();  // gets text contents of clicked li
        $('#show_cat').html(cat_name);

        //remove active class from li
        $('li.cat-item').each(function(){
            $(this).removeClass('active');
        });

        _that.addClass('active'); //add active class to clicked li
      
       pagination(base_url +"home/users/vendor_cat_list/"); //call ajax

    });

/*    $('body').on('keyup', '#search_name', function(){
        pagination();
    });*/


   // $('#cat-item').click();
</script>