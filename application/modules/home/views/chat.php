<?php
    $frontend_assets =  base_url().'frontend_asset/';
   ?>

<?php 
    if(isset($userId) && empty($userId)){
        $arrayName = array('fullName' => '','thumbImage' => '','id'=>'','category_name'=>'');
        $op_data = (Object)$arrayName;
    }
 ?>

<style type="text/css">
    img[src=""] {
        display: none;
    }
  
</style>


<input type="hidden" name="" id="op_chat_id" value="<?php echo $userId; ?>">
<input type="hidden" name="" id="op_chat_name" value="<?php echo $op_data->fullName; ?>">
<input type="hidden" name="" id="op_chat_image" value="<?php echo $op_data->thumbImage; ?>">
<input type="hidden" name="" id="user_type" value="<?php echo $this->session->userdata['userType']; ?>">

<link rel="stylesheet" type="text/css" href="<?php echo $frontend_assets ?>custom/css/jquery.emojipicker.css">
<!-- Emoji Data -->
<link rel="stylesheet" type="text/css" href="<?php echo $frontend_assets ?>custom/css/jquery.emojipicker.tw.css">

<input type="hidden" id="chatRoom" name="" value="0">
<section id="chat" class="sectn-pad2">
    <div class="container">
        <div class="row app-one app">
          <div class="col-sm-4 side cht-rgt-pdng">
            <div class="side-one">
              <div class="row heading cht-clor">
                <div class="col-sm-3 col-xs-3 heading-avatar head-msg">
                  Messages
                </div>
              </div>

              <div class="row searchBox">
                <div class="col-sm-12 searchBox-inner">
                  <div class="form-group has-feedback">
                    <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search" onkeyup="getchat_history(this);" >
                    <span class="fa fa-search"></span>
                  </div>
                </div>

              </div>

              <div class="row sideBar chatHis">
                
              </div>

            </div>
          </div>

          
        
          <div class="col-sm-8 conversation">

            <div class="row heading cht-clor">
              <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                <div class="heading-avatar-icon">
                  <img src="<?php echo $op_data->thumbImage; ?>" id="o_image">
                </div>
              </div>
              <div class="col-sm-8 col-xs-7 heading-name pdng-cstm" id="o_name">
                <a href="<?php echo site_url(); ?>home/users/chatRedirect/<?php echo $op_data->id; ?>" id="o_url" class="heading-name-meta cht-redi"><?php echo $op_data->fullName; ?>
                </a>

                <span class="heading-online">Online</span>
              </div>


              <!--dropdown-->
                <div class="col-sm-1 col-xs-1  heading-dot pull-right blk-opt">
                  <div class="dropdown cht-drpdwn">
                    <button class="btn btn-secondary dropdown-toggle chtn-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i></button>
                    <div class="dropdown-menu drop-cht" aria-labelledby="dropdownMenuButton">


                      <a class="dropdown-item blck" id="block" onclick="blockUser();" href="javascript:void(0)">Block</a>

                      <a class="dropdown-item blck" id="unblock" onclick="unblockUser();" href="javascript:void(0)" style="display: none;" >Unblock</a>


                      <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#delete_modal">Delete</a>
                    </div>
                  </div>
                </div>
              <!--/dropdown-->



            </div>

            <div class="row message" id="conversation">

            <div class="no-cht-dt rtzz-cht" style="display: none;">
                <img src="<?php echo $frontend_assets ?>img/no-cht.png" alt="Image" width="80px" />
                <h5>No chat available</h5>
            </div>
            
            <center>
                <div class="scroll_loader cht-loder" style="display:none">
                    <img height="200" width="200" src="<?php echo $frontend_assets ?>img/show_loading.gif"> 
                </div>
            </center>
             <!--  <div class="row message-previous">
                <div class="col-sm-12 previous">
                  <a onclick="previous(this)" id="ankitjain28" name="20">
                  Show Previous Message!
                  </a>
                </div>
              </div> -->
             
            </div>
            <style type="text/css">
                
                textarea{padding:5px 10px; font-family:"Helvetica Neue", "Helvetica", "Arial", sans-serif; font-size:24px; font-weight:300; outline:none; border:none;}
                #emojiPickerWrap {margin:10px 0 0 0;}
            </style>
            <div class="row reply rit">
              <!-- <div class="col-sm-1 col-xs-1 reply-emojis ">
                <i class="fa fa-smile-o fa-2x"></i>
              </div> -->

              <div class="col-sm-9 col-xs-8 reply-main ">
                <textarea class="form-control emojiable-option" rows="2" id="message" name="message" placeholder="Type a message here" ></textarea>
              </div>

              <div class="col-sm-1 col-xs-1 reply-send " onclick="sendMsg('<?php echo $this->session->userdata['id']; ?>','<?php echo $userId; ?>','<?php echo $this->session->userdata['id']; ?>');">
                <i class="fa fa-send fa-2x" aria-hidden="true" id="send-msg-re"></i>
              </div>

              <div class="col-sm-1 col-xs-1 reply-send img-add">
                <i class="fa fa-image fa-2x" aria-hidden="true"><input type="file" name="image" id="image" ></i>

              </div>
            </div>
           
          </div>
        </div>
    </div>
</section>


<!-- Delete chat modal  -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        Are you sure you want to delete this chat ?
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top">
                    <button id="next" onclick="deleteChat();"  type="button" class="btn btn-primary del_btn">Yes</button>
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


<!-- Block modal  -->
<div class="modal fade" id="block_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Block
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        You have currently block this user !
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top" data-dismiss="modal">
                    <button id="next" type="button" class="btn btn-primary del_btn">Ok</button>
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>


<div class="modal fade" id="op_block_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Block
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        You are currently block !
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top" data-dismiss="modal">
                    <button id="next" type="button" class="btn btn-primary del_btn">Ok</button>
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>
<!--/section-->

<script>
  $(function(){
    $(".heading-compose").click(function() {
      $(".side-two").css({
        "left": "0"
      });
    });

    $(".newMessage-back").click(function() {
      $(".side-two").css({
        "left": "-100%"
      });
    });
})

</script>

<script src="<?php echo $frontend_assets ?>custom/js/jquery.emojipicker.js"></script>

<script type="text/javascript"> 
    $('#message').emojiPicker();
    $(".emojiable-option").on("keyup", function () {
    //console.log("emoji added, input val() is: " + $(this).val());
    });

    //$('.emojiPicker').css({left: 577.16 + 'px', top: (684.097 - 360) + 'px'});

     
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
<script>


    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDXppi4rb-OCK5BXuwSFhHlmh-ug6VKjvE",
        authDomain: "tulia-3e45f.firebaseapp.com",
        databaseURL: "https://tulia-3e45f.firebaseio.com",
        projectId: "tulia-3e45f",
        storageBucket: "tulia-3e45f.appspot.com",
        messagingSenderId: "301086763024"
    };
    firebase.initializeApp(config);

    
    //for registration of user into firebase
    firebase.auth().createUserWithEmailAndPassword('<?php echo $this->session->userdata['id'].''."@tulia.com" ?>' ,'123456').catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage);
        console.log(errorCode);
        // ...
      
    });


    //for checking wheather user exist or not
    firebase.auth().signInWithEmailAndPassword('<?php echo $this->session->userdata['id'].''."@tulia.com" ?>' ,'123456').catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage);
        console.log(errorCode);
        // ...
    });

    //get user's data here
    firebase.auth().onAuthStateChanged(function(user) { 
        if (user) {
            // User is signed in.
            var displayName = user.displayName;
            var email = user.email;
            var emailVerified = user.emailVerified;
            var photoURL = user.photoURL;
            var isAnonymous = user.isAnonymous;
            var uid = user.uid;
            var providerData = user.providerData;
            // ...
        } else {
        // User is signed out.
        // ...
        }
    });


    //for checking user's existance
    function checkUser(my_id,op_id,myUserId){ 

        var op_id = $('#op_chat_id').val();
        firebase.database().ref("chat_rooms").child(my_id+'_'+op_id).once('value', function(snapshot) {
            if (snapshot.exists()) {
                $('#chatRoom').val(my_id+'_'+op_id);
                getChat(my_id,op_id,myUserId)
            }else{ 
                $(".scroll_loader").hide();
            }
        });
        firebase.database().ref("chat_rooms").child(op_id+'_'+my_id).once('value', function(snapshot) {
            if (snapshot.exists()) {
                $('#chatRoom').val(op_id+'_'+my_id);
                getChat(op_id,my_id,myUserId)
            }else{
                $(".scroll_loader").hide();
            }
        });

        //getChat(my_id,op_id,myUserId)

    }
    
    //convert timestamp into date/time here
    function getDateFormat(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
            var time = moment(date).format("h:mm A");

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        var date = new Date();
        date.toLocaleDateString();
        return time;
        //return [day, month, year].join('-');
    }

    //get user's chat from here
    function getChat(firstId,secondId,myId){
        
        var optId = $('#op_chat_id').val();

        if(myId == firstId){
            secondId = optId;
        }else{
            firstId = optId;
        }
        
        firebase.database().ref('/chat_rooms/' + firstId+'_'+secondId).once('value').then(function(snapshot) {
                $('#conversation').html('');
               
                $.each( snapshot.val(), function( key, value ) {

                    var d = getDateFormat(value.timestamp)

                    if(value.op_id == myId){

                        if(value.deleteby != myId){
                            if(value.imageURL == ''){
                                $('#conversation').append('<div class="row message-body"><div class="col-sm-12 message-main-sender"><div class="sender"><div class="message-text">'+value.message+'</div><span class="message-time pull-right" > '+d+' </span></div></div></div>');
                            }else{
                                $('#conversation').append('<div class="row message-body"><div class="col-sm-12 message-main-sender"><div class="sender"><div class="message-text"><img onclick="showImage(this.src);" class="cht-img" src='+value.imageURL+' alt="Image"></div><span class="message-time pull-right" > '+d+' </span></div></div></div>');
                            }   
                        }
                        
                    }else{

                        if(value.deleteby != myId){
                            if(value.imageURL == ''){
                                $('#conversation').append('<div class="row message-body"><div class="col-sm-12 message-main-receiver"><div class="receiver"><div class="message-text">'+value.message+'</div><span class="message-time pull-right" > '+d+' </span></div></div></div>');
                            }else{
                                $('#conversation').append('<div class="row message-body"><div class="col-sm-12 message-main-receiver"><div class="receiver"><div class="message-text"><img onclick="showImage(this.src);" class="cht-img" src='+value.imageURL+' alt="Image"></div><span class="message-time pull-right" > '+d+' </span></div></div></div>');
                            }
                        }
                        
                    }

                    var objDiv = document.getElementById("conversation");
                    objDiv.scrollTop = objDiv.scrollHeight;
                });
            });
         getchat_history()
    }      

    //set length of msg here
    function trimMsg(currentText){
        return currentText.substr(0, 10);
    }

    //first letter captial
    function capitalize(s){
        return s[0].toUpperCase() + s.slice(1);
    }

    //for getting user's chat histroy
    function getchat_history(){

        var searchUser = $('#searchText').val(); 
        var my_id = '<?php echo $this->session->userdata['id']; ?>';

        //get user's chat history according to serch name
        if(searchUser.trim() != ''){
            firebase.database().ref("chat_history").child(my_id).orderByChild('op_name').startAt(searchUser).endAt(searchUser+"\uf8ff").once('value', function(snapshot){


                $('.chatHis').html('');
            
                $.each( snapshot.val(), function( key, value ) {

                    var m = trimMsg(value.message);
                    var d = getDateFormat(value.timestamp);
                    var n = capitalize(value.op_name) ;

                    if(value.profilePic == ''){
                        value.profilePic = '<?php echo base_url().USER_DEFAULT_AVATAR; ?>';
                    }





                    if(m != ''){
                        $('.chatHis').append('<a><div onclick="chatChange('+value.op_id+')"  class="row sideBar-body"><div class="col-sm-2 col-xs-3 sideBar-avatar"><div class="avatar-icon"><img src='+value.profilePic+'></div></div><div class="col-sm-9 col-xs-9 sideBar-main"><div class="row"><div class="col-sm-8 col-xs-8 sideBar-name dng-cstm"><span class="name-meta">'+n+'</span><p style="color:#333;" >'+m+'</p></div><div class="col-sm-4 col-xs-4 pull-right sideBar-time"><span class="time-meta pull-right">'+d+'</span></div></div></div></div></a>');
                    }else{
                        $('.chatHis').append('<a><div onclick="chatChange('+value.op_id+')"  class="row sideBar-body"><div class="col-sm-2 col-xs-3 sideBar-avatar"><div class="avatar-icon"><img src='+value.profilePic+'></div></div><div class="col-sm-9 col-xs-9 sideBar-main"><div class="row"><div class="col-sm-8 col-xs-8 sideBar-name dng-cstm"><span class="name-meta">'+value.op_name+'</span><p style="color:#333;" >Image</p></div><div class="col-sm-4 col-xs-4 pull-right sideBar-time"><span class="time-meta pull-right">'+d+'</span></div></div></div></div></a>');
                    }
                });
            });
        }  






        //get user's chat history order by most recent chat
        firebase.database().ref("chat_history").child(my_id).orderByChild('timestamp').once('value', function(snapshot){

            var op_id = $('#op_chat_id').val(); 
            if(snapshot.exists() || (op_id != '' && op_id != 0)){
                $(".rit").show();
                $(".blk-opt").show();
                $(".no-cht-dt").hide();
            }else{ 
                $(".rit").hide();
                $(".blk-opt").hide();
                $(".no-cht-dt").show();
            }

            $('.chatHis').html('');
        

           
            var array = [];
            $.each(snapshot.val(), function( key, value ) {
                array.push(value);
            });

            array.sort(function(a, b){
                var a1= a.timestamp, b1= b.timestamp;
                if(a1 == b1) return 0;
                return a1 < b1? 1: -1;
            });

            var i = 1;
            $.each(array, function( key, value ) {
    
                var m = trimMsg(value.message);
                var d = getDateFormat(value.timestamp)
                var n = capitalize(value.op_name) ;

                if(value.profilePic == ''){
                    value.profilePic = '<?php echo base_url().USER_DEFAULT_AVATAR; ?>';
                }
            


if($('#user_type').val() == 'user'){




var useriidd = value.op_id;

    firebase.database().ref("users").child('vendor').child(useriidd).once('value', function(userData){
    var userDetail2 = userData.val();

    if(userDetail2){
        
        $('#name'+useriidd).html(userDetail2.name);
        $('#img'+useriidd).attr('src',userDetail2.profilePic);

        if($('#op_chat_id').val() == useriidd){
                $('#o_url').html(userDetail2.name);
                $('#o_image').attr('src', userDetail2.profilePic);   
            }

        value.profilePic = userDetail2.profilePic;
        value.op_name  = userDetail2.name;
        var chatKey1 = firebase.database().ref('/chat_history/' + my_id).child(useriidd).set(value);

    }
    });

    


}else{

 

   
    var useriidd = value.op_id;


    
    firebase.database().ref("users").child('user').child(useriidd).once('value', function(userData){
    var userDetail1 = userData.val();

    if(userDetail1){
       
$('#name'+useriidd).html(userDetail1.name);
$('#img'+useriidd).attr('src',userDetail1.profilePic);

            if($('#op_chat_id').val() == useriidd){
                $('#o_url').html(userDetail1.name);
                $('#o_image').attr('src', userDetail1.profilePic);   
            }


        value.profilePic = userDetail1.profilePic;
        value.op_name  = userDetail1.name;
        var chatKey1 = firebase.database().ref('/chat_history/' + my_id).child(useriidd).set(value);



    }


   
    });

    

}





if($('#user_type').val() == 'user'){


firebase.database().ref("users").child('vendor').child(value.op_id).on('child_changed', function(userData23){

var useriidd = value.op_id;

    firebase.database().ref("users").child('vendor').child(useriidd).once('value', function(userData){
    var userDetail2 = userData.val();

    if(userDetail2){
        
        $('#name'+useriidd).html(userDetail2.name);
        $('#img'+useriidd).attr('src',userDetail2.profilePic);

        if($('#op_chat_id').val() == useriidd){
                $('#o_url').html(userDetail2.name);
                $('#o_image').attr('src', userDetail2.profilePic);   
            }

        value.profilePic = userDetail2.profilePic;
        value.op_name  = userDetail2.name;
        var chatKey1 = firebase.database().ref('/chat_history/' + my_id).child(useriidd).set(value);

    }
    });

    
});

}else{

 

    firebase.database().ref("users").child('user').child(value.op_id).on('child_changed', function(userData23){
    var useriidd = value.op_id;


    
    firebase.database().ref("users").child('user').child(useriidd).once('value', function(userData){
    var userDetail1 = userData.val();

    if(userDetail1){
       
$('#name'+useriidd).html(userDetail1.name);
$('#img'+useriidd).attr('src',userDetail1.profilePic);

            if($('#op_chat_id').val() == useriidd){
                $('#o_url').html(userDetail1.name);
                $('#o_image').attr('src', userDetail1.profilePic);   
            }


        value.profilePic = userDetail1.profilePic;
        value.op_name  = userDetail1.name;
        var chatKey1 = firebase.database().ref('/chat_history/' + my_id).child(useriidd).set(value);



    }


   
    });

    
});
}
             
               
                if(m != ''){
                    $('.chatHis').append('<a  ><div id="fC'+i+'" onclick="chatChange('+value.op_id+')"  class="row sideBar-body firstChild"><div class="col-sm-2 col-xs-3 sideBar-avatar"><div class="avatar-icon"><img id="img'+value.op_id+'" src='+value.profilePic+'></div></div><div class="col-sm-9 col-xs-9 sideBar-main"><div class="row"><div class="col-sm-8 col-xs-8 sideBar-name dng-cstm"><span id="name'+value.op_id+'" class="name-meta">'+n+'</span><p style="color:#333;" >'+m+'</p></div><div class="col-sm-4 col-xs-4 pull-right sideBar-time"><span class="time-meta pull-right">'+d+'</span></div></div></div></div></a>');
                }else{
                    $('.chatHis').append('<a  ><div id="fC'+i+'" onclick="chatChange('+value.op_id+')"  class="row sideBar-body firstChild"><div class="col-sm-2 col-xs-3 sideBar-avatar"><div class="avatar-icon"><img id="img'+value.op_id+'" src='+value.profilePic+'></div></div><div class="col-sm-9 col-xs-9 sideBar-main"><div class="row"><div class="col-sm-8 col-xs-8 sideBar-name dng-cstm"><span id="name'+value.op_id+'" class="name-meta">'+value.op_name+'</span><p style="color:#333;" >Image</p></div><div class="col-sm-4 col-xs-4 pull-right sideBar-time"><span class="time-meta pull-right">'+d+'</span></div></div></div></div></a>');
                }

                //for getting first chat on page load
                if(i == 1){
                    var opId = $('#op_chat_id').val(); 
                    if(opId == '' || opId == 0){
                        
                        chatChange(value.op_id);

                        /*setTimeout( function(){ 
                            $('#fC1').click();

                        },100);*/
                    }
                }

                i++;
            });
        }); 
    }  getchat_history()


    //for changing the chat on click
    function chatChange(a){ 
        getBlockUser() 

        $('#op_chat_id').val(a);
        chat_data(a);
       
        checkUser('<?php echo $this->session->userdata['id']; ?>','<?php echo $userId; ?>','<?php echo $this->session->userdata['id']; ?>')
    }        


    //for checking whether the user is block or not
    function getBlockUser(){

        var chatRoom =  $('#chatRoom').val(); 
        var my_id = '<?php echo $this->session->userdata['id']; ?>';
       
        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot){

            if(snapshot.exists()){

                if(snapshot.val().id == my_id || snapshot.val().id == 'both') {
                    document.getElementById("block").style.display = "none";
                    document.getElementById("unblock").style.display = "block";
                }else{
                    document.getElementById("block").style.display = "block";
                    document.getElementById("unblock").style.display = "none";
                }
            }else{

                document.getElementById("block").style.display = "block";
                document.getElementById("unblock").style.display = "none";
            }

        });       
    }

    //block user here
    function blockUser(){
    
        document.getElementById("block").style.display = "none";
        document.getElementById("unblock").style.display = "block";

        var chatRoom =  $('#chatRoom').val(); 
        var op_id = $('#op_chat_id').val(); 
        var my_id = '<?php echo $this->session->userdata['id']; ?>';
       
        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot){

            if(snapshot.exists()){
               
                var updates2 = {};
                var offer = {
                  id: 'both',
                  timestamp: Date.now()
                }
                updates2['/block/' + chatRoom] = offer;
                return firebase.database().ref().update(updates2);

            }else{
                var blockData = {
                    id: my_id,
                    timestamp: Date.now()
                };
                var chatKey2 = firebase.database().ref('block').child(chatRoom).set(blockData);
            }
        });        
      
    }

    //unblock user here
    function unblockUser(){
        
        document.getElementById("block").style.display = "block";
        document.getElementById("unblock").style.display = "none";

        var chatRoom =  $('#chatRoom').val(); 
        var op_id = $('#op_chat_id').val(); 
        var my_id = '<?php echo $this->session->userdata['id']; ?>';
       
          firebase.database().ref("block").child(chatRoom).once('value', function(snapshot){
        
                var block_id = snapshot.val().id;        
                if(block_id == 'both'){

                    block_id = op_id;
                    firebase.database().ref().child('block').child(chatRoom).child('id').set(block_id); 
                }else{
                  
                    if(block_id == my_id){

                        firebase.database().ref().child('block').child(chatRoom).set(null);
                    }

                }
        });     
    }

    //send text msg from here
    function sendMsg(my_id,op_id){


        var chatRoom =  $('#chatRoom').val(); 
        var op_id = $('#op_chat_id').val();

        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot){
            
            if (snapshot.exists()) {
                
                if ((snapshot.val().id == my_id) || (snapshot.val().id == 'both') ) {

                    //swal("You have currently block this user :( !");
                    $('#block_modal').modal('show');
                 
                }else{

                    //swal("You are currently block :( !");
                    $('#op_block_modal').modal('show');
                }

            }else{

                    var userData = {
                        //category_name: "<?php //echo $my_data->category_name; ?>",
                        category: "",
                        email: '<?php echo $this->session->userdata['email']; ?>',
                        firebaseId: "",
                        firebasetoken: "",
                        name: '<?php echo $this->session->userdata['fullName']; ?>',
                        profilePic: '<?php echo $this->session->userdata['image']; ?>',
                        uid: '<?php echo $this->session->userdata['id']; ?>',
                        userType: '<?php echo $this->session->userdata['userType']; ?>'

                    };

                var userType = $('#user_type').val();   
                var uid = '<?php echo $this->session->userdata['id']; ?>';
                if(userType == 'user'){ 

                    var newPostKey = firebase.database().ref('users').child('user').child(uid).set(userData);
                }else{ 

                    var newPostKey = firebase.database().ref('users').child('vendor').child(uid).set(userData);
                }
                

                var op_id = $('#op_chat_id').val();
                var create_chat = 1;
                firebase.database().ref("chat_rooms").child(my_id+'_'+op_id).once('value', function(snapshot) {
                    if (snapshot.exists()) {
                        create_chat = 0;
                        $('#chatRoom').val(my_id+'_'+op_id);
                        writeNewPost(my_id+'_'+op_id)
                    }
                });
                firebase.database().ref("chat_rooms").child(op_id+'_'+my_id).once('value', function(snapshot) {
                    if (snapshot.exists()) { 
                        create_chat = 0;
                        $('#chatRoom').val(op_id+'_'+my_id);
                        writeNewPost(op_id+'_'+my_id)
                    }
                });

                if(create_chat == 1){
                    var user_type = $("#user_type").val(); 

                    if(user_type == 'user'){

                        $('#chatRoom').val(my_id+'_'+op_id);
                        writeNewPost(my_id+'_'+op_id)
                        
                    }else{

                        $('#chatRoom').val(op_id+'_'+my_id);
                        writeNewPost(op_id+'_'+my_id)
                        
                    }

                } 

                $("#message").css("height",'56px');

             }

        });    
    }


    //delete user's chat here
    function deleteChat(){
        
        var myid = "<?php echo $this->session->userdata['id']; ?>";
        var op_id = $('#op_chat_id').val();
        var chatRoom = $('#chatRoom').val();

        firebase.database().ref("chat_rooms").child(chatRoom).once('value', function(snapshot){
        
            $.each(snapshot.val(), function( key, value ) {               

                if(value.deleteby == ''){ 
                    value.deleteby = myid;
                    firebase.database().ref().child('chat_rooms').child(chatRoom).child(key).set(value); 

                    firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                    //firebase.database().ref('/chat_history/' + myid ).child(op_id).update({ message: "Tulia-23081995", imageURL: "" });
                }else{
                    if(value.deleteby == myid){
                          firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                        //firebase.database().ref('/chat_history/' + myid ).child(op_id).update({ message: "Tulia-23081995", imageURL: "" });

                    }else{
                      
                        firebase.database().ref().child('chat_rooms').child(chatRoom).child(key).set(null);
                        firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                       // firebase.database().ref('/chat_history/' + myid ).child(op_id).update({ message: "Tulia-23081995", imageURL: "" }); 
                    }
                }
            });
        }); 
        $('#delete_modal').modal('hide');
       
        setTimeout(function(){ 
            $('#conversation').html('');
        },1000);     

    }


    //send images from here
    document.getElementById("image").onchange = function(e) {


        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
            case 'jpg':
            case 'JPG':
            case 'png':
            case 'PNG':
            case 'jpeg':
            case 'JPEG':
            case 'gif':
            case 'GIF':
                break;
            default:
                toastr.error('Please select png,jpg,gif and jpeg image formats.');
            this.value='';
        }



        var chatRoom = $('#chatRoom').val();
        var my_id = '<?php echo $this->session->userdata['id']; ?>';
        
        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot){
        
            if (snapshot.exists()) {
                
                if ((snapshot.val().id == my_id) || (snapshot.val().id == 'both') ) {

                    //swal("You have currently block this user :( !");
                    $('#block_modal').modal('show');
                 
                }else{

                    //swal("You are currently block :( !");
                    $('#op_block_modal').modal('show');
                }
            }else{

                    var op_id = $('#op_chat_id').val();
                    var a = e.target.files[0],
                        s = firebase.storage().ref("Images/<?php echo $this->session->userdata['id'].'_'?>"+op_id+'/'+Date.now()).put(a);

                        var loadImg = '<?php echo $frontend_assets ?>img/small-new-tulia.gif';
                        $('#conversation').append('<div class="row message-body"><div class="col-sm-12 message-main-sender"><div class="sender"><div class="message-text"><img class="cht-img" height="30px" width="30px" src='+loadImg+' alt="Image"></div><span class="message-time pull-right" >Now</span></div></div></div>');
                        var objDiv = document.getElementById("conversation");
                        objDiv.scrollTop = objDiv.scrollHeight;
                      

                    s.on("state_changed", function(e) {
                        
                        var a = e.bytesTransferred / e.totalBytes * 100;
                        switch (console.log("Upload is " + a + "% done"), e.state) {
                            case firebase.storage.TaskState.PAUSED:
                                console.log("Upload is paused");
                                break;
                            case firebase.storage.TaskState.RUNNING:
                                console.log("Upload is running")
                        }
                    }, function(e) {}, function() {

                        var e = s.snapshot.downloadURL;
                        var name = $('#op_chat_name').val();
                        var image = $('#op_chat_image').val();
                        var op_id = $('#op_chat_id').val();
                        var my_id = '<?php echo $this->session->userdata['id']; ?>';

                        var chatData = {
                            deleteby: "",
                            deviceToken: "website",
                            imageURL: e,
                            message: '',
                            op_id: "<?php echo $my_data->id; ?>",
                            op_name: "<?php echo $my_data->fullName; ?>".toLowerCase(),
                            profilePic: "<?php echo $my_data->thumbImage; ?>",
                            timestamp: Date.now()
                        };

                        var chatRoom = $('#chatRoom').val();

                        if(chatRoom == '' || chatRoom == 0){
                            chatRoom = op_id+"_"+chatData.op_id;
                        }

                        var newPostKey = firebase.database().ref().child('chat_rooms').child(chatRoom).push(chatData); 
                        
                        var chatKey1 = firebase.database().ref('/chat_history/'+ op_id).child(chatData.op_id).set(chatData);
                        var chatData1 = {
                           
                            deleteby: "",
                            deviceToken: "website",
                            imageURL: e,
                            message: '',
                            op_id: op_id,
                            op_name: name.toLowerCase(),
                            profilePic: image,
                            timestamp: Date.now()
                        };

                        var chatKey2 = firebase.database().ref('/chat_history/'+ my_id).child(op_id).set(chatData1);

                        getchat_history()

                    })
                        }
                    });
                        var objDiv = document.getElementById("conversation");
                        objDiv.scrollTop = objDiv.scrollHeight;

    };

    //send msg from here (create node from here)
    function writeNewPost(chatRoom) {

        var msg = $('#message').val().trim(); 
        var name = $('#op_chat_name').val();
        var image = $('#op_chat_image').val();
        var op_id = $('#op_chat_id').val();
        var my_id = '<?php echo $this->session->userdata['id']; ?>';
       
        if(msg != ''){
            var chatData = {
                //category_name: "<?php //echo $my_data->category_name; ?>",
                deleteby: "",
                deviceToken: "website",
                imageURL: "",
                message: msg.trim(),
                op_id: op_id,
                op_name: name.toLowerCase(),
                profilePic: image,
                timestamp: Date.now()
            };

            var chatDatamy = {
                //category_name: "<?php //echo $my_data->category_name; ?>",
                deleteby: "",
                deviceToken: "website",
                imageURL: "",
                message: msg.trim(),
                op_id: "<?php echo $my_data->id; ?>",
                op_name: "<?php echo $my_data->fullName; ?>".toLowerCase(),
                profilePic: "<?php echo $my_data->thumbImage; ?>",
                timestamp: Date.now()
            };

            
            var newPostKey = firebase.database().ref().child('chat_rooms').child(chatRoom).push(chatDatamy);

            
            
            var chatKey1 = firebase.database().ref('/chat_history/'+ my_id).child(op_id).set(chatData);

           var chatData1 = {
                //category_name: "<?php //echo $my_data->category_name; ?>",
                deleteby: "",
                deviceToken: "website",
                imageURL: "",
                message: msg.trim(),
                op_id: "<?php echo $my_data->id; ?>",
                op_name: "<?php echo $my_data->fullName; ?>".toLowerCase(),
                profilePic: "<?php echo $my_data->thumbImage; ?>",
                timestamp: Date.now()
            };

            var chatKey2 = firebase.database().ref('/chat_history/'+ op_id).child(my_id).set(chatData1);


            //var chatRoom = $('#chatRoom').val();
            //firebase.database().ref('chat_rooms').child(chatRoom).limitToLast(1).on('child_added', function(snapshot) {

               //id  = $('#op_chat_id').val();
                //msg = snapshot.val().message;
                time = chatData1.timestamp;

                $.ajax({
                    url: '<?php echo base_url()."/home/users/chat_notification"?>',
                    type: "POST",
                    data:{id:op_id, msg:msg.trim(), time:time},              
                    cache: false,   
                    beforeSend: function() {
                        //$('#loader').hide();
                        //$("div#divLoading").addClass('show');
                    },                          
                    success: function(data){ 
                        //$("div#divLoading").removeClass('show');
                    }
                });
            //});


            var msg = $('#message').val('');
            getchat_history()
            
            var objDiv = document.getElementById("conversation");
            objDiv.scrollTop = objDiv.scrollHeight;
        }
    }


        //get user's chat on page load
        firebase.database().ref().child('chat_rooms').on("value", function(snapshot) {
            var name = $('#op_chat_name').val();
            var image = $('#op_chat_image').val();
            var op_id = $('#op_chat_id').val();
           
            checkUser('<?php echo $this->session->userdata['id']; ?>',op_id,'<?php echo $this->session->userdata['id']; ?>');

        });


    function chat_data(op_id)
    {   
        url = "<?php echo site_url(); ?>home/users/chatChange/"; 
        $.ajax({
                url: url ,
                type: "POST",
                data:{'userId':op_id},              
                cache: false,  
                dataType: "json",
                beforeSend: function() { 
                    $('#loader').hide();
                    //$("div#divLoading").addClass('show');
                },                          
                success: function(data){ 
                    
                    $('#op_chat_name').val(data['fullName']);
                    $('#op_chat_image').val(data['thumbImage']);
                    $('#op_chat_id').val(data['id']);

                    var name = $('#op_chat_name').val();
                    var image = $('#op_chat_image').val();
                    var u_id = $('#op_chat_id').val();
                    $('#o_url').text(name);
                    $('#o_image').attr('src', image);   
                    $("#o_url").attr("href", '<?php echo site_url(); ?>home/users/chatRedirect/'+u_id);

                    checkUser('<?php echo $this->session->userdata['id']; ?>',op_id,'<?php echo $this->session->userdata['id']; ?>');

                    //$("div#divLoading").addClass('hide');
                }
            });

    }


    </script>

    <!-- image preview modal -->
    <div id="myModal" class="pre-img-modal">
        <span class="close-img-modal">&times;</span>
        <img class="modal-content-cht" id="img01">
    </div>
   

<script>
    //for image preview
    function showImage(imgPath){
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");
        modal.style.display = "block";
        modalImg.src = imgPath;

        var span = document.getElementsByClassName("close-img-modal")[0];

        // When the user clicks on <span>, close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
    }


    //click on emoji keypad on page load
    $('.emojiPickerIcon').click();

    var textarea = document.getElementById('message');

    textarea.addEventListener('keydown', autosize);

    function autosize(){
        var el = this; 
        setTimeout(function(){

            $("#message").css("height",el.scrollHeight+'px');

        },0);
    }

    $('html,body').animate({scrollTop: $('#tl_front_body').offset().top},'slow');

</script>