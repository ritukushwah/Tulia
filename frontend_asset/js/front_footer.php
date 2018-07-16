<!---Footer Start Here-->
<?php
    $frontend_assets =  base_url().'frontend_asset/';
?>
<footer>
  <div class="container">
  	<div class="foot-img"><img src="<?php echo $frontend_assets ?>img/logo02.png"><img class="img-top" src="<?php echo $frontend_assets ?>img/logo03.png"></div>
    <div class="social-link"><ul><li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li></ul></div>
  </div>
</footer>
<div class="copyright">Copy Right © By Tulia 2017-18 | All Rights Reserved.</div>
 
<!-- Back to Top --> 
<a href="#" id="back-to-top" title="Back to top"><img src="<?php echo $frontend_assets ?>img/top-arrow.png" alt=""></a> 

<!-- js file  --> 

<script src="<?php echo $frontend_assets ?>js/bootstrap.js"></script>
<script src="<?php echo $frontend_assets ?>js/moment.js"></script>
<!-- <script src="<?php //echo $frontend_assets ?>js/init-round.js"></script> -->
<script src="<?php echo $frontend_assets ?>js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $frontend_assets ?>js/owl.carousel.js"></script>  
<!-- <script src="<?php //echo $frontend_assets ?>js/plugin.js"></script>  -->
<script src="<?php echo $frontend_assets ?>js/menuzord.js"></script> 

<script src="<?php echo $frontend_assets ?>js/main.js"></script>

<script src="<?php echo $frontend_assets ?>custom/js/front_common.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script src="<?php echo $frontend_assets ?>custom/js/validation.js"></script> 
<script src="<?php echo $frontend_assets ?>js/facebook.js"></script> 


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