 <?php  
    define('API_ACCESS_KEY','AAAARhoraBA:APA91bF60FScjvb-3LkAo5zyMMn24xfNRIPLA1Pc0rYI-ijRz0a1ITij6keKaz37SjVP1D5qq9Kl5FXwXaHj2fXs1qo9wkDEA4NjyXxApXFcQkqrQ7n1luy-HUElSOYTJZ8LU8w_1Vlz');
    
    $msg = $notificationMsg;
    $message = array('title'=>"Tulia",'body'=> "Test for tulia! Yes it is working!" ,'postId'=>1,'type'=> 'post');
    $ios_message = array( "title"=>"Elite",
            "subtitle"=>"" ,"body"=>"Test for notifications again!","points"=>"0","businessId"=>1,"isFavourite"=> "no"
          );

    $reg_ids = array('cWZ5ju2lXnw:APA91bHtkCh1-ISEfSyQ7dGKJJ7jpABfRL3vbp1IiLtPDLXsxAYCB-2KEEGr44jPleoiYfx81jI1O4LQDxaSf2G5OQ0SRjC5fzziINYW2c8jXeEqHET0TVAn-rYeEAUZE9_sPGzTKO4K');

    $fields = array('registration_ids'=>$reg_ids, 'data'=>$message, 'notification'=>$message);
    //echo '<pre>'; print_r($fields);
    /*$fields = array(
        'to' 	=> 'ee26e1837f2c6170569e253cc5b496eea01904b48e3c526e4b9181c3cefc1123', //firebase ID or device token
        'data' => array('message'=>'hello ios'),
        'notification'=> array('body' => 'Enter your message')
    );*/
    //$messageBody['aps'] = array('alert' => $message,'badge' => 1, 'sound' => 'default','mutable-content'=>1,'data'=> $attrs);

    //'data'=> array('title'=>"Elite",'message'=> "Test for elite! Is it working?" ,'postId'=>1,'type'=> 'post')   -- for andriod
    //'aps'=> array('alert' => $message,'badge' => 1, 'sound' => 'default','mutable-content'=>1,'data'=> array("attachment-url"=>""))   -- for ios
    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    //curl request
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    //curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );

    print_r($result);
    die('check');
 ?>
