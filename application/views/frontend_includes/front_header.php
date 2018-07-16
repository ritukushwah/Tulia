<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content=""> 
<meta name="keywords" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TuliA Event Planning App – Make Your Events Memorable</title>
<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>
<link rel="shortcut icon" href="<?php echo $frontend_assets ?>img/apple-icon-76x76.png">
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css"  href="<?php echo $frontend_assets ?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $frontend_assets ?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $frontend_assets ?>css/menuzord.css">
<link href="<?php echo $frontend_assets ?>css/owl.carousel.css" rel="stylesheet" media="screen">
<link href="<?php echo $frontend_assets ?>css/plugins.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css"  href="<?php echo $frontend_assets ?>css/animate.min.css">
<link rel="stylesheet" type="text/css"  href="<?php echo $frontend_assets ?>css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css"  href="<?php echo $frontend_assets ?>css/bootstrap-datetimepicker-standalone.css">
<link rel="stylesheet" type="text/css" href="<?php  echo $frontend_assets.auto_version('/css/style.css') ?>">
<link rel="stylesheet" type="text/css"  href="<?php echo $frontend_assets ?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php  echo $frontend_assets.auto_version('/css/login2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php  echo $frontend_assets.auto_version('/css/media-querie.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php  echo $frontend_assets.auto_version('/custom/css/front_custom.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $frontend_assets ?>toastr/toastr.min.css">

<!-- <script src="<?php //echo $frontend_assets ?>js/jquery.min.js"></script> -->
<!-- Light Gallery Plugin Css -->



<link href="<?php echo $frontend_assets ?>light-gallery/css/lightgallery.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBCKpfnLn74Hi2GBmTdmsZMJORZ5xyL1as" type="text/javascript">
</script> -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjRQfxz2XzwQuISEwlwYqPvZ_SmZH_2Ng&placeid=PLACE_ID&libraries=places&amp;libraries=places"></script>


<?php load_css($front_styles);  //load required page styles ?>
<!--og-->
<meta property="og:type" content="business.business">
<meta property="og:title" content="TuliA Event Planning App">
<meta property="og:url" content="http://www.tulia.tech/">
<meta property="og:image" content="http://www.tulia.tech/frontend_asset/img/logo03.png">
<meta property="og:image" content="http://www.tulia.tech/frontend_asset/img/mainimg.png">
<meta property="business:contact_data:street_address" content="9404 Harrell Dr">
<meta property="business:contact_data:locality" content="McKinney">
<meta property="business:contact_data:region" content="Texax">
<meta property="business:contact_data:postal_code" content="75070">
<meta property="business:contact_data:country_name" content="United States">
<!--schema-->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Website",
  "name": "Tulia",
  "image": "http://www.tulia.tech/frontend_asset/img/logo03.png",
  "@id": "Tulia",
  "url": "http://schema.org"
  }
}
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '168333790469635');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=168333790469635&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>
<script type="text/javascript">
  var base_url = '<?php echo base_url();?>';
</script>
<body id="tl_front_body" data-base-url="<?php echo base_url();?>">

<!--preloader start-->
<div class="ava-loader-overlay"></div>
<!--preloader end--> 
<!-- Nav Bar-->
<?php if(!empty($this->uri->segment(1))){ ?>
<div class="navbar navbar-custom navbar-fixed-top back-red-color" role="navigation">
 <?php   }else{ ?>
<div class="navbar navbar-custom navbar-fixed-top " role="navigation">
<?php } ?>
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
      <a class="navbar-brand page-scroll" href="<?php echo site_url(); ?>"></a> </div>
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse"> 
      <!---<a href="#contact" class="theme-btn btn-orange page-scroll">Contact Us</a>-->
     <ul class="nav navbar-nav">
        <li> <a class="page-scroll" href="<?php echo site_url(); ?>">Home</a> </li>
        
       
        <?php if(!empty($this->session->userdata('id'))){
                    if($this->session->userdata('userType') == 'user'){ ?>
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/posts/">My Post</a> </li>
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/users/vendorList">Vendors</a> </li>
           
          
                    <?php }else{ ?>
    
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/vendorpost/allEvents">All Events</a> </li>
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/vendorpost/myAllEvents">My Events </a> </li>
            
            
                    <?php } ?>
            
           <!--  <li> <a class="page-scroll" href="javascript:void(0)">Notification</a> </li> -->
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/users/chat/0">Chat</a> </li>
            <li> <a class="page-scroll" href="<?php echo site_url(); ?>home/users/">Profile</a> </li>
            <li>
                <div class="dropdown cstm-drpdn dsktop-viw">
                    <i class="btn btn-primary dropdown-toggle cstm-prm" type="button" data-toggle="dropdown" onclick="notify();" >
                        <span class="fa fa-bell"></span>
                    </i>
                    <ul class="dropdown-menu cstm-mne scr-not drpdn-pad">
                        
                            <div class="scroll_loader load-wdth" style="display:none">
                                <img height="100" width="100" src="<?php echo $frontend_assets ?>img/show_loading.gif"> 
                            </div>
                        
                        <div id="notifyData">
                            
                        </div>
                    </ul>
                </div>
                <?php $count = $this->common_model->getcount(NOTIFICATIONS, array('notification_for'=>$this->session->userdata['id'],'is_show'=>0));
                    if($count != 0){ ?>
                        <div id="count_notify"><?php 
                        echo $count;
                     ?>
                </div> 
                    <?php    } ?>
                
            </li>
            
        <?php }else{ ?>
        
         <li> <a class="page-scroll" href="<?php echo site_url(); ?>#downloapp">Download App</a> </li> 
         <li> <a class="page-scroll" href="<?php echo site_url(); ?>#aboutus">About</a> </li>
        <li> <a class="page-scroll" href="<?php echo site_url(); ?>#features">Features</a> </li>
        <li> <a class="page-scroll" href="<?php echo site_url(); ?>#contact">Contact Us</a> </li>
         <li> <a class="page-scroll" href="<?php echo site_url(); ?>login">Login</a> </li> <?php } ?>
      </ul>
    </div>
  </div>
</div>
<!-- END Nav Bar -->
<div class="clearfix"></div> 
<!-- Header -->




<style type="text/css">
  
#divLoading
{
    display : none;
}
#divLoading.show
{
    display : block;
    position : fixed;
    z-index: 99999;
    background-image : url('<?php echo $frontend_assets ?>img/tulia-loader.gif');
    background-color:#FFF;
    opacity : 0.7;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
}
#loadinggif.show
{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 999999;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
}
div.content {
    width : 1000px;
    height : 1000px;
}

</style>

<div id="divLoading"> </div>

<script type="text/javascript">


    function notify(){ 

        $('#count_notify').hide();
        url = base_url + "home/users/notification_list/";
        $.ajax({
            url: url,
            type: "POST",
            data:{page:url},              
            cache: false,   
            beforeSend: function() {
                $('#loader').hide();
                $(".scroll_loader").show();
            },                          
            success: function(data){ 
                $(".scroll_loader").hide();
                $("#notifyData").html(data);
            }
        });
    }
    
</script>
