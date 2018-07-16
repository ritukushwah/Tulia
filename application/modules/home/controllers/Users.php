<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends FrontCommon_Controller {


    function __construct() {
        parent::__construct();
        $this->load->model('service/notification_model'); //load push notification model
      
    }

    public function index()
    {   
        $this->check_user_session();
        $data['front_scripts'] = $data['front_styles'] = '';
        $user_id = $this->session->userdata['id'];
        $data['vendorData'] = $this->common_model->user_details($user_id, $check_status=true); //user information
        $where = array('id'=>$user_id);
        $user_type = $this->common_model->customGet('userType',$where,USERS); 

        if($user_type['userType'] == 'vendor'){
            $this->load->front_render('vendor_profile', $data, '');
        }else{ 
            $this->load->front_render('user_profile', $data, '');            
        }
    }


    public function chatRedirect($user_id)
    {   
        $this->check_user_session();
        $data['front_scripts'] = $data['front_styles'] = '';
     
        $data['vendorData'] = $this->common_model->user_details($user_id, $check_status=true); //user information
        $where = array('id'=>$user_id);
        $user_type = $this->common_model->customGet('userType',$where,USERS); 

        if($user_type['userType'] == 'vendor'){
     
            $data['vendor_data'] = $this->common_model->user_details($user_id, $check_status=true);
            $this->load->front_render('vendor_detail', $data, '');
        }else{ 
            $this->load->front_render('chat_user_profile', $data, '');            
        }
    }

    function editProfile()
    {
        $this->check_user_session();
        $user_id = $this->session->userdata['id'];
        $data['userData'] = $this->common_model->user_details($user_id, $check_status=true); //user information
        $data['front_scripts'] = $data['front_styles'] = '';
        $where = array('id'=>$user_id);
        $user_type = $this->common_model->customGet('userType',$where,USERS); 

        if($user_type['userType'] == 'vendor'){
            $this->load->model('home_model'); //load home model here
            $data['category'] = $this->home_model->getAllData(CATEGORIES);
            $this->load->front_render('edit_vendor_profile', $data, '');
            
        }else{ 
           $this->load->front_render('edit_profile', $data, '');            
        }
        
    }

    function check_unique_email($str, $data)
    { 
        $user_id = $this->session->userdata['id'];
        if(!empty($user_id)){
            $tb_arr = explode(".",$data);
            $str = preg_replace("/[\'']+/", " ", $str); 
            $where = " $tb_arr[1] = '".$str."' AND  id != $user_id";
            $result = $this->common_model->check_exist($where,USERS);
            if(!empty($result)){
                $this->form_validation->set_message('check_unique_email','This email is already exist');
                return FALSE;
            }
            else{
                return TRUE;
            } 
        }   
    }//End function 


    function check_unique_contactNumber($str, $data)
    { 
        $user_id = $this->session->userdata['id'];
        if(!empty($user_id)){
            $tb_arr = explode(".",$data);
            $str = preg_replace("/[\'']+/", " ", $str); 
            $where = " $tb_arr[1] = '".$str."' AND  id != $user_id";
            $result = $this->common_model->check_exist($where,USERS);
            if(!empty($result)){
                $this->form_validation->set_message('check_unique_contactNumber','This contact number is already exist');
                return FALSE;
            }
            else{
                return TRUE;
            } 
        }   
    }//End function 

    //user and vendor profile update here
    function update_profile()
    { 
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $this->form_validation->set_rules('fullName', 'First name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_unique_email[users.email]');
        $this->form_validation->set_rules('contactNumber', 'Contact number', 'trim|required|callback_check_unique_contactNumber[users.contactNumber]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');

        $user_id = $this->session->userdata['id'];
        $where = array('id'=>$user_id);
        $user_type = $this->common_model->customGet('userType',$where,USERS); 

        if($user_type['userType'] == 'vendor'){

            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('currency_code', 'Currency', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[200]');
            $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric'); 
            $meta_arr = array('price','currency_code','currency_symbol','description'); 
        }


        if ($this->form_validation->run() == FALSE)
        { 
            $requireds = strip_tags($this->form_validation->error_string()) ? strip_tags($this->form_validation->error_string()) : ''; //validation error
            $response = array('status' => 0, 'message' => $requireds);  
            echo json_encode($response);  
        }
        else
        { 
            $image = array(); 
            $this->load->model('Image_model');
            if (!empty($_FILES['image']['name'])) { 
                $height = $width = 600;
                $folder = 'user_avatar';
                $image = $this->Image_model->updateMedia('image', $folder, $height, $width,FALSE); //upload media of category
                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response); exit;
                }
            }

            $set = array('fullName','email', 'contactNumber','address');
            foreach ($set as $key => $val) {
                $post= $this->input->post($val);
                if(!empty($post))
                    $update_data[$val] = $post;   //take data if it is not empty
            }

            //check for image name if present
            $new_file = 0;
            if(array_key_exists("image_name",$image)){
                $user_image = $image['image_name'];
                if(!empty($user_image)){
                    $update_data['image'] = $user_image;
                    $new_file = 1;
                    //delete old attachment from server
                    if(!empty($existing_img)){
                        $this->common_model->delete_attachment($user_id, USERS, $existing_img);
                    }
                }
            }
            
            //update user data
            $update_where = array('id'=>$user_id); 
            $this->common_model->updateFields(USERS, $update_data, $update_where);  

            //update user category
            $meta_where = array('user_id'=>$user_id);
            $cat_id = $this->input->post('category');
            $this->common_model->updateFields(USR_CAT_MAPPING, array('category_id'=>$cat_id), $meta_where);  

            //to update user(vendor) meta data
            if(!empty($meta_arr)){
              
                //for getting currency symbol
               
                foreach ($meta_arr as $val) { 
                    $meta = $this->input->post($val);
                   
                    if(!empty($post))
                    $meta_data[$val] = $meta;   //take data if it is not empty
                }
                
                //check if meta data exist for current user
                $is_exist = $this->common_model->is_data_exists(USER_META, $meta_where);
                if($is_exist){
                    //update user meta data
                    $this->common_model->updateFields(USER_META, $meta_data, $meta_where);  //update user meta data
                } else{
                    //insert user meta data
                    $meta_data['user_id'] = $user_id;
                    $this->common_model->insertData(USER_META, $meta_data);
                }
            }

            if(!empty($new_file)){
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with category ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$user_id, 'reference_table'=>USERS);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachemnt with category id
                    }
                }  
            }

           //$user_data = $this->common_model->getsingle(USERS, $where); 
            $user_data = $this->common_model->user_details($user_id, $check_status=true); 
           
            $response = array('status' => 1, 'message' => 'Successfully updated', 'url' => base_url('home/users'),'userData' => $user_data); //success msg
            echo json_encode($response);
        }
    }

    function check_password()
    {
        $user_id = $this->session->userdata['id'];
        $current_password = $this->input->get('password'); 
        $where = array('id'=>$user_id);
        $isCheck = $this->common_model->customGet('password',$where,USERS);
        if(password_verify($current_password, $isCheck['password'])){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    function check_email()
    {
        $email = $this->input->get('email'); 
        $where = array('email'=>$email);
        $is_exist = $this->common_model->is_data_exists(USERS, $where);
        if($is_exist){
            echo 'false';
        }else{
            echo 'true';
        }
    }

    function check_user_email()
    {
        $user_id = $this->session->userdata['id'];
        $email = $this->input->get('email'); 
        $where = array('email'=>$email,'id !='=>$user_id);
        $is_exist = $this->common_model->is_data_exists(USERS, $where);
        if($is_exist){
            echo 'false';
        }else{
            echo 'true';
        }
    }


    function check_contact()
    {
        $user_id = $this->session->userdata['id'];
        $contactNumber = $this->input->get('contactNumber'); 
        $where = array('contactNumber'=>$contactNumber,'id !='=>$user_id);
        $is_exist = $this->common_model->is_data_exists(USERS, $where);
        if($is_exist){
            echo 'false';
        }else{
            echo 'true';
        }
    }


    //change user and vendor password here
    function changePassword()
    {
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]',array('required'=>'Please enter current password','min_length'=>'Password Should be atleast 6 Character Long'));
        $this->form_validation->set_rules('npassword', 'new password', 'trim|required|matches[rnpassword]|min_length[6]',array('required'=>'Please enter new password','min_length'=>'Password Should be atleast 6 Character Long','matches'=>'New Password does not match with retype password'));
        $this->form_validation->set_rules('rnpassword', 'retype new password ', 'trim|required|min_length[6]',array('required'=>'Please retype new password','min_length'=>'Password Should be atleast 6 Character Long'));

        $this->form_validation->set_error_delimiters('<div class="err_msg">', '</div>');
        if ($this->form_validation->run() == FALSE)
        { 
            $error = validation_errors(); 
            $res['status']=0; $res['message']= $error; 
            echo json_encode($res);      
        }
        else 
        {
            $password =$this->input->post('password');
            $npassword =$this->input->post('npassword');
            $where = array('id' => $this->session->userdata('id')); 
            $admin = $this->common_model->customGet('password',$where,USERS);
            
            if(password_verify($password, $admin['password'])){
                $set =array('password'=> password_hash($this->input->post('npassword') , PASSWORD_DEFAULT)); 
                $update = $this->common_model->updateData(USERS, $set, $where);
                if($update){
                    $res = array();
                    if($update){
                        $res['url']= base_url('home/users'); $res['status']=1; $res['message']='Password Updated successfully';
                    }
                    else{
                        $res['status']=0; $res['message']='Failed! Please try again';
                    }
                    echo json_encode($res); die;
                } 
            }else{
                $res['message']= "Your Current Password is Wrong !";
                echo json_encode($res); die;    
            }
        }  
    }//End Function


    function vendorMedia()
    {
        $this->check_user_session();
        $user_id = $this->session->userdata['id'];
        $data['front_scripts'] = $data['front_styles'] = ''; 
        $is_exist = $this->common_model->is_data_exists(ALBUMS, array('user_id'=>$user_id));
        if($is_exist){
            $this->load->front_render('vendor_media', $data, '');
        }else{
            $this->load->front_render('no_vendor_media', $data, '');
        }

    }


    function albumList()
    {
        $user_id = $this->session->userdata['id']; 
        $this->load->library('Ajax_pagination');
       
        $total = $this->common_model->get_total_count(ALBUMS, array('user_id'=>$user_id));
        $config['base_url'] = base_url().'home/users/albumList/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 6;
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
  
        $data['album_list']     = $this->common_model->get_user_album_list($user_id, $limit, $offset); //get all albums of user by userIDq

        $data['pagination'] = $this->ajax_pagination->create_links();
        
        $data['startFrom']  = $offset + 1;
       //pr($data);
       $this->load->view('media_list',$data);
    } //End function


    function vendorList()
    {
        $this->check_user_session();
        $this->load->model('home_model'); //load home model
        $data['category'] = $this->home_model->getAllData(CATEGORIES);
        $data['front_scripts'] = $data['front_styles'] = '';
        $this->load->front_render('vendor_category', $data, '');
    }

    //get user list by user type
    function vendor_cat_list()
    {
        $current_user_id = $this->session->userdata['id'];
        $search_name = $this->input->post('search_name') ;
        $category_id = $this->input->post('id') ;

        $this->load->library('Ajax_pagination');
        
        $total = $this->common_model->search_user_list_count('vendor', $category_id, $search_name,$check_status=true); 
        $config['base_url'] = base_url().'home/users/vendor_cat_list/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 6;
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
        $offset = $page > 0 ? $page : 0;
        $this->ajax_pagination->initialize($config);
  
        $data['vendor_list']     = $this->common_model->search_user_list('vendor', $category_id, $search_name, $limit, $offset, $check_status=true); 

        $data['pagination'] = $this->ajax_pagination->create_links();
       
        $data['startFrom']  = $offset + 1; 
       
       $this->load->view('vendor_cat_list',$data);
    }
 
    function vendorProfile($ven_id)
    {
        $this->check_user_session();
        $ven_id = decoding($ven_id);
        $data['front_scripts'] = $data['front_styles'] = '';
        $data['vendor_data'] = $this->common_model->user_details($ven_id, $check_status=true);
        $this->load->front_render('vendor_detail', $data, '');
    }

    function vendor_album_list()
    {
        $this->load->library('Ajax_pagination');
        $user_id = $this->input->post('id') ; 
        $total = $this->common_model->get_total_count(ALBUMS, array('user_id'=>$user_id));
        $config['base_url'] = base_url().'home/users/vendor_album_list/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 4;
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
        $config['paginate_call'] = 'vendorAlbum';
        $page = $this->uri->segment(4); 
        $limit = $config['per_page'];
        $offset = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);
  
        $data['album_list']     = $this->common_model->get_user_album_list($user_id, $limit, $offset); //get all albums of user by userIDq

        $data['pagination'] = $this->ajax_pagination->create_links();
        
        $data['startFrom']  = $offset + 1;
      
       $this->load->view('vendor_media_list',$data);
    } //End function

    function showAlbumData(){
        
        $data['album']     = $this->common_model->get_user_album_by_id($_POST['id']); //get all albums of user by userIDq
        $this->load->view('mediaPop',$data);
    }

    function albumData()
    {
        $album_id = $this->input->post('id') ; 
        $data['album_data'] = $this->common_model->get_user_album_by_id($album_id);
        $this->load->view('media_modal', $data);

    }

    function vendor_review_list()
    {
        $this->load->library('Ajax_pagination');
        $user_id = $this->input->post('id') ; 
        $total = $this->common_model->get_user_reviews_count($user_id,$check_status=true);
        $config['base_url'] = base_url().'home/users/vendor_review_list/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 3;
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
       
        $data['user_reviews'] = $this->common_model->get_user_reviews($user_id, $limit, $offset, $check_status=true);

        $data['pagination'] = $this->ajax_pagination->create_links();
        $data['startFrom']  = $offset + 1;

        $this->load->view('vendor_review',$data);
    } //End function


    //add review for user(vendor)
    function addReview()
    {
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $current_user_id = $this->session->userdata['id'];

        $this->form_validation->set_rules('rating', 'rating', 'trim|required|numeric',array('required'=>'Please select rating'));
        $this->form_validation->set_rules('review_description', 'Feedback', 'trim|required|min_length[2]|max_length[200]');
        $this->form_validation->set_rules('review_for', 'Review', 'required', array('required'=>'Please select user to review for'));
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            echo json_encode($response); exit;
        }
        else{
            $set = array('review_for', 'rating', 'review_description');
            foreach ($set as $key => $val) {
                $post= $this->input->post($val);
                if(!empty($post))
                    $insert_data[$val] = $post;
            }
            $insert_data['review_by'] = $current_user_id;
            $insert_data['created_on'] = datetime();
        }
       
        $review_id = $this->common_model->insertData(REVIEWS, $insert_data);  //insert new post data
        if($review_id)
        { 
            $review_for = $insert_data['review_for'];
            $review_data = $this->common_model->get_user_reviews($review_for, 1, $offset=0, $check_status=true); //get last inserted review data
            $user_info =  $this->common_model->getsingle(USERS, array('id'=>$review_for), 'id, deviceToken');
            if(!empty($user_info))
            {
                //prepare notification payload
                $registrationIds[] = $user_info->deviceToken; $title = "Reviewed your profile";
                $body_send = $this->session->userdata['fullName'].' posted a review';  //body to be sent with current notification
                $body_save = '[UNAME] posted a review'; //body to be saved in DB
                $notif_type = 'user_review';
                $this->load->model('post_model');
                $notif_msg = $this->post_model->send_push_notification($registrationIds, $title, $body_send, $review_for, $notif_type);

                if($notif_msg)
                {   
                    $notif_msg['body'] = $body_save; //replace body text with placeholder text
                    //save notification
                    $insertdata = array('notification_by'=>$current_user_id, 'notification_for'=>$review_for, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type,'reference_id'=>$notif_msg['reference_id'] , 'created_on'=>datetime());
                    $this->notification_model->save_notification(NOTIFICATIONS, $insertdata);
                }
            }
            
            $response = array('status' => 1, 'message' => 'Review added successfully', 'url' => base_url("home/users/vendorProfile/").encoding($review_for)); //success msg
        }
        else
        {
            $response = array('status'=>0,'message' => 'Something went wrong. Please try again'); //fail- something went wrong
        }
        
        echo json_encode($response); exit;
    }



    function realated_vendor()
    {
        $category_id = $this->input->post('cat_id') ; 
        $vendor_id = $this->input->post('id') ; 

        $data['realated_vendor'] = $this->common_model->related_vendor('vendor',$vendor_id, $category_id,$check_status=true); 
        
        $data['front_scripts'] = $data['front_styles'] = '';
        $this->load->view('related_vendor', $data);
    }


    function vndrReview($vendor_id)
    {
        $this->check_user_session();
        $vendor_id = decoding($vendor_id);
        $data['ven_id'] = $vendor_id;
        $data['front_scripts'] = $data['front_styles'] = '';
        $is_exist = $this->common_model->is_data_exists(REVIEWS, array('review_for'=> $vendor_id));
        if($is_exist){
            $this->load->front_render('vendor_review_list', $data, '');
        }else{
            $this->load->front_render('pageNotFound',$data);
        }
    }

    function review_list()
    {
        $this->load->library('Ajax_pagination');
        $user_id = $this->input->post('id') ; 
        $total = $this->common_model->get_user_reviews_count($user_id,$check_status=true);
        $config['base_url'] = base_url().'home/users/review_list/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4; 
        $config['per_page'] = 3;
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
       
        $data['user_reviews'] = $this->common_model->get_user_reviews($user_id, $limit, $offset, $check_status=true);

        $data['pagination'] = $this->ajax_pagination->create_links();
        $data['startFrom']  = $offset + 1;

        $this->load->view('review_list',$data);
    }

    function noReview(){

        $this->check_user_session();
        $data['front_scripts'] = $data['front_styles'] = '';
        $this->load->front_render('no_review', $data, '');
    }


    //delete review
    function deleteReview()
    {
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $current_user_id = $this->session->userdata['id']; 
        $review_id = $this->input->post('id');
        
        //check if we have review ID
        if(empty($review_id)){
            $response = array('status' => 0, 'message' =>'No Record found');
            echo json_encode($response); exit;
        }
        
        //check if review is for current user
        $is_exist = $this->common_model->is_data_exists(REVIEWS, array('id'=>$review_id, 'review_for'=>$current_user_id));
        if(!$is_exist){
            $response = array('status' => 0, 'message' => 'You are not authorised for this action'); 
            echo json_encode($response); exit;
        }
        
        $is_del = $this->common_model->deleteData(REVIEWS, array('id'=>$review_id));
        if($is_del){
 
            $this->common_model->deleteData(NOTIFICATIONS,array('reference_id'=>$current_user_id));
            $is_data_exists = $this->common_model->is_data_exists(REVIEWS, array('review_for'=>$current_user_id));
            if(!$is_data_exists){
                $response = array('status' => 1, 'message' => 'Deleted successfully','url'=>base_url("home/users/noReview/"));
            }else{
                $response = array('status' => 1, 'message' => 'Deleted successfully','url'=>base_url("home/users/vndrReview/").encoding($current_user_id)); 
            }

        } else{
            $response = array('status' => 0, 'message' => 'Something went wrong. Please try again');


        }
        echo json_encode($response); exit;
    }


    //get all notifications of user
    function notification_list()
    {
        $current_user_id = $this->session->userdata['id']; 
        $this->load->model('service/service_model');
        //get latest 50 notifications of user and detail of notification_by user
        $res_arr = $this->common_model->GetJoinRecord(NOTIFICATIONS, 'notification_by', USERS, 'id', 'notification_for, notification_message, notification_type, notification_by, created_on, fullName, image', array('notification_for'=>$current_user_id) , '', 'created_on', 'DESC', 20, 0);
        
        $all_notif = $res_arr['result']; $u_name = $e_name = '';
        if($all_notif){
            $this->common_model->updateFields(NOTIFICATIONS, array('is_show'=>1),array('notification_for'=>$current_user_id));
        }
        foreach($all_notif as $k=>$v)
        {
            $notif_payload = json_decode($v->notification_message);
            //if notification is related to post then get event name
            if($v->notification_type=='post_doing' || $v->notification_type=='post_create')
            {
                //replace placeholder name with real event name
                $notif_payload->body = $this->service_model->replace_event_placeholder_name($notif_payload->reference_id, $notif_payload->body);
            }

            //get fullName of user
            $notif_payload->body = $this->service_model->replace_user_placeholder_name($v->notification_by, $notif_payload->body);

            $all_notif[$k]->notification_message = $notif_payload;
            $v->user_image = make_user_img_url($v->image); //make url from image name
            $v->time_elapsed = time_elapsed_string($v->created_on); //add time_elapsed key to show time elapsed in user friendly string
        }
        
        $data['notify_list'] = $all_notif;
        $this->load->view('notification list', $data);
  
    }


    function chat($userId)
    {   
        $this->check_user_session();
        $data['userId'] =  decoding($userId);
        if($data['userId'] == 'z1'){
            $data['userId'] = '';
        }
        $data['op_data'] = $this->common_model->user_details($data['userId'], $check_status=true);
        $data['my_data'] = $this->common_model->user_details($this->session->userdata['id'], $check_status=true);
        $data['front_scripts'] = $data['front_styles'] = ''; 
        $this->load->front_render('chat', $data, '');             
    }

    function chatChange(){  
        $userId =  $this->input->post('userId');
        $data['op_data'] = $this->common_model->user_details($userId, $check_status=true);
        
        print_r(json_encode((array)$data['op_data']))  ;die();
    }

    function chat_notification(){

        $id  = $this->input->post('id');
        $reference_id = $this->input->post('chatRoom');
        $info = $this->common_model->user_details($id, $check_status=true);

        if(!empty($info->deviceToken) && $info->deviceToken != 'system' ){

            $msg = $this->input->post('msg');
            $time = $this->input->post('time');
            $title = 'New message from'.' '.$info->fullName;
            

            $body  = $msg;

            $notif_msg = array('title'=>$title, 'body'=> $body,'type'=> 'chat',

                'sender_name'=> $info->fullName,
                'message'=> $msg,
                'time'=> $time,
                'reference_id'=>$reference_id,
                'click_action'=>'ChatActivity',
                'sound'=>'default'


                );
            $this->notification_model->send_notification(array($info->deviceToken), $notif_msg);  //send andriod and ios push notification
            print_r($v);
            return $notif_msg;  //return message array
        }

        
    }


     //forgot(reset) password
    public function resetPassword(){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if($this->form_validation->run() == FALSE){
            $response = array('status' => 0, 'message' => strip_tags(validation_errors()));
            echo json_encode($response); exit;
        }
        
        $email = $this->input->post('email');
        $userType = $this->input->post('userType');

        $user = $this->common_model->getsingle(USERS, array('email'=>$email,'userType'=>$userType), '*');
        if(empty($user)){
            $response = array('status' => 0, 'message' => 'This email address is not associated with your user type');
            echo json_encode($response); exit;
        }
        
        if($user->socialType && $user->socialId){
            $response = array('status' => 0, 'message' => 'This email address is associated with social account');
            echo json_encode($response); exit;
        }
        
        
        $new_pass = mt_rand(100000, 999999); //generate a random 6 digit number
        
        //update new password of user
        $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);  //it is goood to use php's password hashing algo
        $is_updated = $this->common_model->updateFields(USERS, array('password'=> $new_pass_hash), array('id'=>$user->id)); 
        if($is_updated){
            //send mail to user
            
            $data['full_name'] = $user->fullName; $data['new_password'] = $new_pass; 
            $message = $this->load->view('email/reset_password', $data, true); 
            $this->load->library('smtp_email');
            $subject = 'Tulia- Reset Password'; 
            $isSend = $this->smtp_email->send_mail($email,$subject,$message); 
            if($isSend){
                $response = array('status' => 1, 'message' => 'We have send you a mail, please check your mail inbox or spam.'); //email sent
            }
            else{
                $response = array('status' => 0, 'message' => 'Error, not able to send email'); //email not sent
            }
            
        } else{
            $response = array('status' => 0, 'message' => ResponseMessages::getStatusCodeMessage(118)); //failed to update
        }
        
        echo json_encode($response); exit;
    }

    

}
