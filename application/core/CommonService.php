<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//load rest library
require APPPATH . '/libraries/REST_Controller.php';
class CommonService extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('service_model');
        $this->load->model('notification_model'); //load push notification model
    }
    
    //check auth token of request
    public function check_service_auth(){
        /*Authtoken*/
        $this->authData = '';
        $header = $this->input->request_headers();
        
        //check if key exist as different server may have different types of key (case sensitive) 
        if(array_key_exists ( 'authToken' , $header )){
            $key = 'authToken';
        }
        elseif(array_key_exists ( 'Authtoken' , $header )){
            $key = 'Authtoken';
        }
        elseif(array_key_exists ( 'AuthToken' , $header )){
            $key = 'AuthToken';
        }
        else{
            return false;
        }
       
        //print_r( $header);die;
        $authToken = isset($header[$key]) ? $header[$key] : '';
        $userAuthData =  !empty($authToken) ? $this->service_model->isValidToken($authToken) : '';

        if(!empty($userAuthData)){
            $this->authData = $userAuthData;
            return true;    
        } 
        else {
            return false;     
        }
    }
    
    //send push notifications
    public function send_push_notification($token_arr, $title, $body, $reference_id, $type){
        if(empty($token_arr)){
            return false;
        }
        //prepare notification message array
        $notif_msg = array('title'=>$title, 'body'=> $body, 'reference_id'=>$reference_id, 'type'=> $type, 'click_action'=>'ChatActivity', 'sound'=>'default');
        $this->notification_model->send_notification($token_arr, $notif_msg);  //send andriod and ios push notification
        return $notif_msg;  //return message array
    }
    
    //show auth token error message
    public function token_error_msg(){
        return array( 'message'=>ResponseMessages::getStatusCodeMessage(101),'authToken'=>'','responseCode'=>300);
    }

}//End Class 

