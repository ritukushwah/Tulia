<!---Footer Start Here-->
<?php
    $frontend_assets =  base_url().'frontend_asset/';
?>
<footer>
<div class="container">
    <div class="foot-img"><img src="<?php echo $frontend_assets ?>img/logo02.png" alt="TuliA Event Planning App"><img class="img-top" src="<?php echo $frontend_assets ?>img/logo03.png" alt="TuliA Event Planning App"></div>
    <div class="social-link"><ul><li><a href="https://www.facebook.com/tuliatech/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><li><a href="https://twitter.com/tulia_app"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li><li><a href="https://www.instagram.com/tulia_app_/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li></ul></div>
  </div>
</footer>
<div class="copyright">Copy Right © By Tulia 2017-18 | All Rights Reserved.</div>

<!-- Back to Top --> 
<a href="#" id="back-to-top" title="Back to top"><img src="<?php echo $frontend_assets ?>img/top-arrow.png" alt=""></a> 

<!-- js file  --> 

<script src="<?php echo $frontend_assets ?>js/bootstrap.js" ></script>
<script src="<?php echo $frontend_assets ?>js/moment.js" ></script>
<script src="<?php echo $frontend_assets ?>js/bootstrap-datetimepicker.min.js" ></script>
<script src="<?php echo $frontend_assets ?>js/owl.carousel.js" ></script>  
<script src="<?php echo $frontend_assets ?>js/sketch.js" ></script>
<script src="<?php echo $frontend_assets ?>js/menuzord.js" ></script> 
<script src="<?php echo $frontend_assets ?>js/main.js" ></script>
<script src="<?php echo $frontend_assets ?>toastr/toastr.min.js" ></script>
 <!-- Light Gallery Plugin Js -->
<script src="<?php echo $frontend_assets ?>light-gallery/js/lightgallery.js" ></script>

<script src="<?php  echo $frontend_assets.auto_version('/custom/js/front_common.js') ?>" ></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js" ></script>


<script src="<?php  echo $frontend_assets.auto_version('/custom/js/validation.js') ?>" ></script> 
<!-- <script src="<?php //echo $frontend_assets ?>js/facebook.js"></script>  -->


<?php load_js($front_scripts);  //load required page js ?>
<script>
    function switchVisible() {
        if (document.getElementById('login-frm')) {

            if (document.getElementById('login-frm').style.display == 'none') {
                document.getElementById('login-frm').style.display = 'block';
                document.getElementById('regstrn-frm').style.display = 'none';
            }
            else {
                document.getElementById('login-frm').style.display = 'none';
                document.getElementById('regstrn-frm').style.display = 'block';
            }
        }
    }

    
</script>

</body>
</html>

<script>
    function show_loader(){ 
        $("div#divLoading").addClass('show');
    }
    function hide_loader(){
        $("div#divLoading").removeClass('show');
    }


    window.setInterval(function(){
        myFunction();
    }, 60000);


    
    function myFunction(){
        $.ajax({
            url: '<?php echo base_url() ?>home/Vendorpost/checklogin',
            type: "get",
            data: {},
            cache: false,
            success: function(result) {

                if(result != '0'){

                    $.each(JSON.parse(result), function(key, value) {
                        spawnNotification(value.notification_message.body,value.notification_message.title)
                    });
                }
            }
        });
    }


    Notification.requestPermission().then(function(result) {
        console.log(result);
    });


    Notification.requestPermission();
    function spawnNotification(theBody,theTitle) {
    
        var options = {
            body: theBody,
        }
        var notification = new Notification(theTitle, options);
        notification.onclick = function(event) {
            event.preventDefault(); // prevent the browser from focusing the Notification's tab
        }
        setTimeout(notification.close.bind(notification), 7000);
    }


</script>

