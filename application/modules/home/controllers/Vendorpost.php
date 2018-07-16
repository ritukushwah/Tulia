<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendorpost extends FrontCommon_Controller {

    function __construct() {
        parent::__construct();
        
    }

    function checklogin(){
        $current_user_id = $this->session->userdata('id');
        
        if($current_user_id){
            $this->load->model('service/service_model');
            //get latest 50 notifications of user and detail of notification_by user
            $res_arr = $this->common_model->GetJoinRecord(NOTIFICATIONS, 'notification_by', USERS, 'id', '*,notifications.id as n_id', array('notification_for'=>$current_user_id,'is_show'=>0) , '', 'created_on', 'DESC', 1, 0);

            
            $all_notif = $res_arr['result']; $u_name = $e_name = '';
            if($all_notif){
                $this->common_model->updateData('notifications',array('status' => 1), array( 'id' => $all_notif[0]->n_id));

                    $v = $all_notif[0];
                    $notif_payload = json_decode($v->notification_message);
                    //if notification is related to post then get event name
                    if($v->notification_type=='post_doing' || $v->notification_type=='post_create')
                    {
                        //replace placeholder name with real event name
                        $notif_payload->body = $this->service_model->replace_event_placeholder_name($notif_payload->reference_id, $notif_payload->body);
                    }

                    //get fullName of user
                    $notif_payload->body = $this->service_model->replace_user_placeholder_name($v->notification_by, $notif_payload->body);

                    $all_notif[0]->notification_message = $notif_payload;
                    $v->user_image = make_user_img_url($v->image); //make url from image name
                    $v->time_elapsed = time_elapsed_string($v->created_on); //add time_elapsed key to show time elapsed in user friendly string
                echo json_encode($all_notif); die;
            }
            
        }else{
            echo '0';
        }

    }
    
    
    function allEvents(){

        $this->check_user_session();

        $user_id =  $current_user_id = $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $limit= '999999'; $offset = 0;
      
        $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));

        if(empty($cat_details)){
            redirect('/login');
        }
        $where = array('category_id' => $cat_details->category_id,'doi.post_id' => null);
        $total = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset);
       
        $data['total'] = count($total);
        $data['front_scripts'] = $data['front_styles'] = '';
        
        if($data['total'] == 0){
            $data['title'] = 'Currently, No event available for your business category';
            $data['description'] = 'While any user will post an event then you will notice it, So keep waiting for doing some new work around you.';
            $this->load->front_render('vendorNoPost', $data, '');
        }else{
            $this->load->front_render('allEvent', $data, '');
        }
    }

    function event(){
        $user_id =  $current_user_id = $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');
        $this->load->library('Ajax_pagination');
       
        $cat_details = $this->common_model->getsingle(USR_CAT_MAPPING, array('user_id'=>$current_user_id));
        $where = array('category_id' => $cat_details->category_id,'doi.post_id' => null);
        
        $total = $this->input->get('totalCount');
        $config['base_url'] = '/home/Vendorpost/event';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(4); 
        $limit = $config['per_page'];
        $offset = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);

        $data['data']     = $this->Vendorpost_model->get_post_list($where,$current_user_id, $limit, $offset);
     /* echo "<pre>";
       print_r($data);die;
*/
        $data['pagination'] = $this->ajax_pagination->create_links();
        $this->load->view('event',$data); 
    }

    function myAllEvents(){
        $this->check_user_session();
        $current_user_id = $this->session->userdata['id']; //user id
        $limit= 999999; $offset = 0;
        $total = $this->common_model->get_my_post($current_user_id, $limit, $offset, $check_status=true);
       
        $data['total'] = count($total);
        $data['front_scripts'] = $data['front_styles'] = '';
        
        if($data['total'] == 0){
            $data['title'] = 'Currently, You are not interested in doing any event';
            $data['description'] = 'You need to go to all event page from where you can see all new posts around you.';
            $this->load->front_render('vendorNoPost', $data, '');
        }else{
            $this->load->front_render('myAllEvent', $data, '');
        }
    }

    function myEvent(){
        $current_user_id = $this->session->userdata['id']; //user id
        $this->load->library('Ajax_pagination');
        
        $total = $this->input->get('totalCount');
        $config['base_url'] = base_url().'home/Vendorpost/myEvent';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(4); 
        $limit = $config['per_page'];
        $offset = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);
        $data['data']     = $this->common_model->get_my_post($current_user_id, $limit, $offset, $check_status=true);
        $data['pagination'] = $this->ajax_pagination->create_links();
        $this->load->view('myEvent',$data); 
    }

    function eventDetail(){
        $this->check_user_session();
        $customer_id  = $this->uri->segment(4);
        $post_id = decoding($customer_id);
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1 ));
        if($is_exist){

            $this->load->model('Vendorpost_model');
            $data['data'] = $this->Vendorpost_model->get_post_detail(array('p.id'=>$post_id));
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('eventDetail',$data); 
        }else{
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('pageNotFound',$data);
        }

    }

    function eventDoing(){ 

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        
        $post_id = $this->input->post('post_id');
        $is_data_exists = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1 ));
        if(!$is_data_exists){
            
            $response = array('status' => 0, 'message' => 'This event does not exist'); //success msg
            echo json_encode($response); exit;
        }
        $this->load->model('Vendorpost_model');
        $insert_data['post_id'] = $post_id;
        $current_user_id = $insert_data['user_id'] = $this->session->userdata('id');
        $insert_data['created_on'] = datetime();
        $last_id = $this->common_model->insertData(DOING_EVENT, $insert_data);  //insert new data
        
        if($last_id){
            
            //send notification
            $post_info = $this->Vendorpost_model->get_post_detail(array('p.id'=>$post_id));
            
            if(!empty($post_info)){
                //prepare notification payload
                $registrationIds[] = $post_info->deviceToken; $title = "Doing your event";
                 //body to be saved in DB //body to be sent with current notification
                $body_send = $this->session->userdata('fullName').' is interested in doing your event '.$post_info->event_name; 
               
                $body_save = '[UNAME] is interested in doing your event [ENAME]';
                $notif_type = 'post_doing';
                
                $notif_msg = $this->send_push_notification($registrationIds, $title, $body_send, $post_id, $notif_type);
                
                if($notif_msg){
                   
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    //save notification
                    $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$post_info->post_author, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type,'reference_id'=>$notif_msg['reference_id'] , 'created_on'=>datetime());
                    $this->Vendorpost_model->save_notification(NOTIFICATIONS, $insertdata);
                }
            }
            
            $response = array('status' => 1, 'message' => 'Successfully added to my events',  'url' => base_url('home/vendorpost/myAllEvents')); //success msg
            echo json_encode($response);
        }
    }

    function send_push_notification($token_arr, $title, $body, $reference_id, $type){
        if(empty($token_arr)){
            return false;
        }
        $this->load->model('Vendorpost_model');
        //prepare notification message array
        $notif_msg = array('title'=>$title, 'body'=> $body, 'reference_id'=>$reference_id, 'type'=> $type, 'click_action'=>'ChatActivity', 'sound'=>'default');
        $this->Vendorpost_model->send_notification($token_arr, $notif_msg);  //send andriod and ios push notification
        return $notif_msg;  //return message array
    }

    function addAlbum(){  

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $current_user_id =  $this->session->userdata['id']; //user id
        $this->load->model('Vendorpost_model');

            if(!empty($_FILES['album_images']['name'])){
                  $alb_img_key = 'album_images'; $files = $_FILES; $filesCount = 0; $error_details = array(); $att_arr = array();
            
                $filesCount =  count($_FILES['album_images']['name']);
              
                
                for($i = 0; $i < $filesCount; $i++){

                    $_FILES['album_image']['name'] = $files['album_images']['name'][$i];
                    $_FILES['album_image']['type'] = $files['album_images']['type'][$i];
                    $_FILES['album_image']['tmp_name'] = $files['album_images']['tmp_name'][$i];
                    $_FILES['album_image']['error'] = $files['album_images']['error'][$i];
                    $_FILES['album_image']['size'] = $files['album_images']['size'][$i];

                    //upload each image and insert data in attachemnt table
                    $image = $this->Vendorpost_model->updateMedia('album_image', 'user_album', 600, 600, FALSE);  

                    //check if attachment ID exists for last upload
                    if(array_key_exists("attachments",$image) && !empty($image['attachments'])){
                        $att_arr = array_merge($att_arr, $image['attachments']);  //merge attachments  
                    }
                    else{
                       //check for error
                        if(array_key_exists("error",$image) && !empty($image['error'])){
                            $response = array('status' => 0, 'message' => $image['error']);
                            echo json_encode($response); die;
                        }
                    }
                }
                
                $set = array('album_title','album_description'); //set insert data
                foreach ($set as $key => $val) {
                    $post= $this->input->post($val);
                    $insert_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
                }
                $insert_data['user_id'] = $current_user_id;
                $insert_data['created_on'] = $insert_data['updated_on'] = datetime();
                $album_id = $this->common_model->insertData(ALBUMS, $insert_data);  //insert album data and get album ID
                
                //check if album ID created
                if(!$album_id){
                    $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118)); //fail- something went wrong
                    $this->response($response);
                }
                if(!empty($att_arr)){
                    //update attachment with album ID
                    foreach($att_arr as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$album_id, 'reference_table'=>ALBUMS);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);
                    }
                }


                $alb_detail = $this->common_model->get_user_album_list($current_user_id, 1, $offset=0); //get last inserted album detail


                if(isset($alb_detail[0]->id)){
                    $response = array('status' => 1, 'message' => 'Successfully added', 'url' => base_url('home/users/vendorMedia')); //success msg
                }else{
                    $response = array('status' => 0, 'message' => 'something went wrong!', 'url' => base_url('home/users/vendorMedia')); //success msg
                }
                echo json_encode($response);

            }else{
                $response = array('status' => 0, 'message' => 'Please select atleast one image'); 
                echo json_encode($response);
            }
 

    }

    function deleteAlbum(){
       
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $current_user_id = $this->session->userdata['id']; //user id
        $album_id = $this->input->post('id');
        
        if(empty($album_id)){
            echo "0";
            die();
        }
        
        //check if album exists and belongs to current user
        $is_exist = $this->common_model->is_data_exists(ALBUMS, array('id'=>$album_id, 'user_id'=>$current_user_id));
        if(!$is_exist){
            echo "0";
            die();
        }
        
        $this->common_model->delete_attachment($album_id, ALBUMS, $att_name=''); //delete attachment entires from table and folder
        $this->common_model->deleteData(ALBUMS, array('id'=>$album_id)); //delete album row from table
        
        
        $response = array('status' => 1, 'message' => 'Deleted Successfully', 'url' => base_url('home/users/vendorMedia')); //success msg
        echo json_encode($response);
    }

    function updateAlbum(){

        $current_user_id = $this->session->userdata['id']; //user id
        $album_id = $this->input->post('id');
        $data['album_images'] = $this->common_model->get_user_album_by_id($album_id);
        $this->load->view('update_media',$data);

    }


    function update_media(){

        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }

        $this->load->model('Image_model');
        $current_user_id = $this->session->userdata['id']; //user id

       
            $album_id = $this->input->post('album_id'); 
            
            $alb_img_key = 'album_images'; $files = $_FILES; $filesCount = 0; $error_details = array(); 
            $att_arr = array();

            if(!empty($_FILES[$alb_img_key]['name'])){
                $filesCount = count($_FILES[$alb_img_key]['name']);   //check image count
                if($filesCount>5){
                    $response = array('status' => 0, 'message' => 'Select maximum 4 images');
                    echo json_encode($response); exit;
                }
            }
            
            //loop through images array and upload single image in each iteration 
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['album_image']['name'] = $files[$alb_img_key]['name'][$i];
                $_FILES['album_image']['type'] = $files[$alb_img_key]['type'][$i];
                $_FILES['album_image']['tmp_name'] = $files[$alb_img_key]['tmp_name'][$i];
                $_FILES['album_image']['error'] = $files[$alb_img_key]['error'][$i];
                $_FILES['album_image']['size'] = $files[$alb_img_key]['size'][$i];

                //upload each image and insert data in attachemnt table
                $image = $this->Image_model->updateMedia('album_image', 'user_album', 600, 600, FALSE);  



                //check if attachment ID exists for last upload
                if(array_key_exists("attachments",$image) && !empty($image['attachments'])){
                    $att_arr = array_merge($att_arr, $image['attachments']);  //merge attachments   
                }
                else{
                    //check for error
                    if(array_key_exists("error",$image) && !empty($image['error'])){
                        $response = array('status' => 0, 'message' => $image['error']);
                        echo json_encode($response); die;
                    }
                }
            }
            
            
            //all is fine update album now
            
            //check if there is any attachment in request
            if(!empty($att_arr)){
                //delete old attachments for this album if there is any
                $this->common_model->delete_attachment($album_id, ALBUMS); 
                
                //update attachment with album ID
                foreach($att_arr as $att_id){
                    $where = array('id'=>$att_id);
                    $update = array('reference_id'=>$album_id, 'reference_table'=>ALBUMS);
                    $this->common_model->updateFields(ATTACHMENTS, $update, $where);
                }
            }
            
            $set = array('album_title','album_description');  //set update data
            foreach ($set as $key => $val) {
                $post= $this->input->post($val);
                $update_data[$val] = (isset($post) && !empty($post)) ? $post :''; 
            }
            $update_data['user_id'] = $current_user_id;
            $update_data['updated_on'] = datetime();
            $this->common_model->updateFields(ALBUMS, $update_data, array('id'=>$album_id));  //update album data

            $response = array('status' => 1, 'message' => 'Successfully updated', 'url' => base_url('home/users/vendorMedia')); //success msg
            echo json_encode($response);
          
    }





}

