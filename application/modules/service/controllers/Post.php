<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Event Post API class 
class Post extends CommonService{
    
    public function __construct(){
        parent::__construct();
        
        //common validation rules for post
        $this->validation_rules = array(
            array(
                'field' => 'event_category',
                'label' => 'Category',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'guest_number',
                'label' => 'Number of guest',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'event_date',
                'label' => 'Event date',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'event_time',
                'label' => 'Event time',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'contact_number',
                'label' => 'Contact number',
                'rules' => 'trim|required|numeric'
                ),
            array(
                'field' => 'budget_from',
                'label' => 'Budget from',
                'rules' => 'trim|required|callback__compare_budget'
                ),
            array(
                'field' => 'currency_code',
                'label' => 'Currency',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'currency_symbol',
                'label' => 'Currency',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'event_type',
                'label' => 'Event',
                'rules' => 'trim|required'
                ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required|min_length[2]|max_length[200]'
                )
        );
        
        $this->list_limit = 20;  //limit record
    }
    
    //create new post
    function createPost_post(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $v_rules = $this->validation_rules;
        if($this->post('budget_from') != '10000+')
            $v_rules[] = array('field' => 'budget_to','label' => 'Budget to','rules' => 'trim|required');
        
        
        $this->form_validation->set_rules($v_rules); //set validation rules
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response); die;
        }
        
        $set = array('event_type', 'event_date', 'event_time', 'guest_number', 'contact_number', 'budget_from', 'budget_to', 'currency_code', 'currency_symbol', 'address', 'latitude', 'longitude', 'description');
        foreach ($set as $key => $val) {
            $post= $this->post($val);
            if(!empty($post))
                $insert_data[$val] = $post;
        }
        $insert_data['post_author'] = $current_user_id;  //post user id
        $insert_data['created_on'] = datetime();
        $insert_data['updated_on'] = datetime();
        
        $post_id = $this->common_model->insertData(POSTS, $insert_data);  //insert new post data
        if($post_id){  
            //insert post category data
            $cat_id = $this->input->post('event_category'); //category ID
            $cat_data = array('post_id'=>$post_id, 'category_id'=>$cat_id, 'created_on'=>datetime());
            $this->common_model->insertData(POST_CAT_MAPPING, $cat_data);
            
            $post_data = $this->service_model->get_post_list(array('p.id' => $post_id), $current_user_id, 1); //get last inserted post details
            
            //send notification
            $notif_where = array('category_id'=>$cat_id, 'status'=>1, 'deviceToken !=' => '');
            
            //get users(vendors) of this category
            $all_users = $this->common_model->GetJoinRecord(USR_CAT_MAPPING, 'user_id', USERS, 'id', 'user_id', $notif_where); 
            //get comma separated device tokens of above users
            $all_tokens = $this->common_model->GetJoinRecord(USR_CAT_MAPPING, 'user_id', USERS, 'id', 'GROUP_CONCAT(deviceToken) as deviceToken', $notif_where);
            
            if(!empty($all_users['result']) && !empty($all_tokens['result'])){
                
                //prepare notification payload
                $registrationIds = explode(",", $all_tokens['result'][0]->deviceToken); $title = "New post created";
                //body to be sent with current notification
                $body_send = $this->authData->fullName.' posted event '.$post_data[0]['event_name']; 
                //body to be saved in DB
                $body_save = '[UNAME] posted event [ENAME]';
                $notif_type = 'post_create';

                $notif_msg = $this->send_push_notification($registrationIds, $title, $body_send, $post_id, $notif_type);
                if($notif_msg){
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    foreach($all_users['result'] as $u){
                        //save notification
                        $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$u->user_id, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type, 'reference_id'=>$notif_msg['reference_id'] ,'created_on'=>datetime());
                        $this->notification_model->save_notification(NOTIFICATIONS, $insertdata);
                    }
                }
            }
            
            $response = array('status'=>SUCCESS, 'message'=>ResponseMessages::getStatusCodeMessage(125), 'postDetail'=>$post_data);
        }
        else{
            $response = array('status'=>FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
        }
        
        $this->response($response);
    }
    
    //callback validation fn to compare budget 
    function _compare_budget(){
        $b_from = $this->input->post('budget_from');
        $b_to = $this->input->post('budget_to');
        if(empty($b_from) || $b_from == '10000+' || $b_to == '10000+'){
            return TRUE;
        }
        if($b_from>=$b_to && !empty($b_from)){
            $this->form_validation->set_message('_compare_budget','Please select correct estimation of your budget');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    //show post list
    public function getPostList_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        
        $offset = $this->get('offset'); $limit = $this->get('limit'); $post_id = $this->get('post_id');
        if(!isset($offset) || empty($limit)){
            $limit= $this->list_limit; $offset = 0;
        }
        
        $post_for = $this->get('type');
        switch ($post_for) {
            case "user":
                $where = array('post_author' => $current_user_id);
            break;
            case "vendor":
                //get category of vendor here 
                $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));
                
                if(empty($cat_details)){
                    $response = array('status'=>SUCCESS, 'message'=>'Please select a category'); //vendor has not yet selected category
                    $this->response($response);
                }
                $where = array('category_id' => $cat_details->category_id);
            break;
            case "single":
                //get category of vendor here
                $where = array('id' => $post_id);
            break;
            default:
                $where = '';
        }
        
        $post_details = $this->service_model->get_post_list($where,$current_user_id, $limit, $offset); 
        $response = array('status'=>SUCCESS, 'postDetail'=>$post_details);
        $this->response($response);
    }
    
    
    //show post list related to user by user ID
    public function getMyPostList_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        
        $offset = $this->get('offset'); $limit = $this->get('limit'); //$user_id = $this->get('user_id');
        if(!isset($offset) || empty($limit)){
            $limit= $this->list_limit; $offset = 0;
        }
        
        $post_details = $this->common_model->get_my_post($current_user_id, $limit, $offset, $check_status=true); 
        
        $response = array('status'=>SUCCESS, 'postDetail'=>$post_details);
        $this->response($response);
    }
    
    //update post
    public function updatePost_post(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $post_id = $this->post('post_id'); //post id of post which is to be updated
        
        $v_rules = $this->validation_rules;
        if($this->post('budget_from') != '10000+')
            $v_rules[] = array('field' => 'budget_to','label' => 'Budget to','rules' => 'trim|required');
        
        //check if post belongs to user
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id, 'post_author'=>$current_user_id));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message' => 'Cannot edit this post');
            $this->response($response); die;
        }
        
        $this->form_validation->set_rules($v_rules); //set validation rules
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response); die;
        }
        
        $set = array('event_type', 'event_date', 'event_time', 'guest_number', 'contact_number', 'budget_from', 'budget_to', 'currency_code', 'currency_symbol', 'address', 'latitude', 'longitude', 'description');
        foreach ($set as $key => $val) {
            $post= $this->post($val);
            $update_data[$val] = $post;
        }
        $update_data['updated_on'] = datetime();
        $where = array('id'=>$post_id);
        $is_updated = $this->common_model->updateFields(POSTS, $update_data, $where);  //insert new post data
        if($is_updated){
            /* Post category update is required, so disabled
            //update post category data
            $up_cat_data = array('post_id'=>$post_id, 'category_id'=>$this->post('event_category')); $up_where = array('post_id'=>$post_id);
            $this->common_model->updateFields(POST_CAT_MAPPING, $up_cat_data, $up_where);
            */
            
            $post_data = $this->service_model->get_post_list(array('p.id' => $post_id),$current_user_id, 1); //get last inserted post details
            $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(135), 'postDetail'=>$post_data);
        }
        else{
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
        }
        $this->response($response);
    }
    
    //vendor is doing/interested on an event
    public function doingEvent_post(){
        //check for auth
        if(!$this->check_service_auth()){
           $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        
        $current_user_id = $this->authData->id;
        $current_user_type = $this->authData->userType;
        //check if user is vendor 
        if($current_user_type != 'vendor'){
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(136)); //fail- not authorised
            $this->response($response);
        }
        $post_id = $this->post('post_id'); //post id of post which is to be updated
        if(empty($post_id)){
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(137)); //fail- record does not exist
            $this->response($response); die;
        }
        //check if post exist
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id, 'status'=>1));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message'=>ResponseMessages::getStatusCodeMessage(137));
            $this->response($response); die;
        }
        
        //check if vendor already dooing this event
        $is_doing = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$post_id, 'user_id'=>$current_user_id));
        if($is_doing){
            $response = array('status' => FAIL, 'message'=>"You have already applied on this event");
            $this->response($response);
        }
        
        $insert_data['post_id'] = $post_id;
        $insert_data['user_id'] = $current_user_id;
        $insert_data['created_on'] = datetime();
        $last_id = $this->common_model->insertData(DOING_EVENT, $insert_data);  //insert new data
        if($last_id){
            
            //send notification
            $post_info = $this->service_model->get_post_detail(array('p.id'=>$post_id));
            
            if(!empty($post_info)){
                //prepare notification payload
                $registrationIds[] = $post_info->deviceToken; $title = "Doing your event";
                //body to be sent with current notification
                $body_send = $this->authData->fullName.' is interested in doing your event '.$post_info->event_name; 
                //body to be saved in DB
                $body_save = '[UNAME] is interested in doing your event [ENAME]';
                $notif_type = 'post_doing';
                
                $notif_msg = $this->send_push_notification($registrationIds, $title, $body_send, $post_id, $notif_type);
                
                if($notif_msg){
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    //save notification
                    $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$post_info->post_author, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type,'reference_id'=>$notif_msg['reference_id'] ,'created_on'=>datetime());
                    $this->notification_model->save_notification(NOTIFICATIONS, $insertdata);
                }
            }
            
            $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(140));
        }
        else{
            $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
        }
        $this->response($response);
    }
    
    //get doing users list
    public function getDoingUserList_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $current_user_id = $this->authData->id;
        $offset = $this->get('offset'); $limit = $this->get('limit');
        if(empty($offset) || empty($limit)){
            $limit= $this->list_limit; $offset = 0;
        }
        $post_id = $this->get('post_id'); //post id of post for which we need to get doing users list
        
        
        $doing_users = $this->common_model->get_doing_user_list($post_id, $limit, $offset=0);
        $response = array('status'=>SUCCESS, 'userList'=>$doing_users);  
        $this->response($response);
        //Left join posts table with doing_event and with users
    }
    
    //get post detail by ID
    public function getPostDetail_get(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        
        $post_id = $this->get('post_id'); //post id of post for which we need to get detail
        if(empty($post_id)){
            $response = array('status' => FAIL, 'message' => 'Please select post');  //post ID not found
            $this->response($response);
        }
        
        //check if post exist
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(141)); //fail- no record found
            $this->response($response);
        }
        
        //get post detail by ID
        $post_detail = $this->service_model->get_post_detail(array('p.id'=>$post_id));
        
        $response = array('status' => SUCCESS, 'postDetail' => $post_detail);
        $this->response($response);
    }
    
    //delete an existing post
    public function deletePost_post(){
        //check for auth
        if(!$this->check_service_auth()){
            $this->response($this->token_error_msg(), SERVER_ERROR); //authentication failed
        }
        $post_id = $this->post('post_id'); //post id of post which is to be updated
        $current_user_id = $this->authData->id;
        
        //check if post belongs to user
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id, 'post_author'=>$current_user_id));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(137)); //fail- not authorised
            $this->response($response);
        }
        
        $up_data = array('status'=>0); $where = array('id'=> $post_id);
        $this->common_model->updateFields(POSTS, $up_data, $where); //do not delete posts- just change status to 0
        $this->common_model->deleteData(NOTIFICATIONS,array('reference_id'=>$post_id));
        $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(138));
        $this->response($response);
    }
    
} //End of Class