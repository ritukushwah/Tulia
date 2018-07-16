<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends FrontCommon_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct() {

        parent::__construct();
        $this->load->model('service/notification_model'); //load push notification model
       
    }
    

	public function index()
	{ 
        $this->check_user_session();
        $data['front_scripts'] = $data['front_styles'] = '';
        $user_id = $this->session->userdata['id']; 
        $where = array('post_author'=>$user_id,'status'=>1);
        $is_exist = $this->common_model->is_data_exists(POSTS, $where); 
        if($is_exist){ 
            $this->load->front_render('my_post', $data, '');
        }else{
            $this->load->front_render('no_post', $data, '');
        }
                
	}

    function addPost()
    { 
        $this->check_user_session();
    	$this->load->model('home_model'); //load home model
        $data['category'] = $this->home_model->getAllData(CATEGORIES);
        $data['event_type']    = $this->home_model->getAllData(EVENT_TYPE);
        $data['front_scripts'] = $data['front_styles'] = '';
        $this->load->front_render('add_post', $data, '');
                
    }


    function postList()
    {
    	$user_id = $this->session->userdata['id']; 
        $this->load->library('Ajax_pagination');
        $like = $this->input->post('search') ;
        $like = !empty($like) ? trim($like) : '' ;
        $total = $this->common_model->get_my_post_count($user_id, $limit='', $offset='', $check_status=true); 

        $config['base_url'] = base_url().'home/posts/postList/';
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
  
        $data['post_detail']     = $this->common_model->get_my_post($user_id, $limit, $offset, $check_status=true);
        $data['pagination'] = $this->ajax_pagination->create_links();
    	
        $data['startFrom']  = $offset + 1;
       //pr($data);
       $this->load->view('post_list',$data);
    } //End function

    
    //post create
    function create_post()
    { 
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        $user_id = $this->session->userdata['id']; //user id
        $this->form_validation->set_rules('event_type', 'Event type', 'trim|required');
        $this->form_validation->set_rules('event_date', 'Event date', 'trim|required');
        $this->form_validation->set_rules('event_time', 'Event time', 'trim|required');
        $this->form_validation->set_rules('guest_number', 'Guest number', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
        $this->form_validation->set_rules('budget_from', 'Budget from', 'trim|required');
        
        $this->form_validation->set_rules('currency_symbol', 'Currency symbol', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');

        if($this->input->post('budget_from') != '10000+'){

           $this->form_validation->set_rules('budget_to', 'Budget to', 'trim|required');
        }
        
        if ($this->form_validation->run() == FALSE){ 
            $response = array('status' => FAIL , 'url' => base_url(), 'message' => strip_tags(validation_errors()));
        }else{ 

            $currency_code = $this->input->post('currency_symbol');
            $url = APPPATH.'third_party/currency.json'; 
            $jsonData = json_decode(file_get_contents($url));  
            foreach ($jsonData as $key => $val) {
                if($val->code == $currency_code)
                {   
                    $currency_symbol = $val->symbol; 
                }
            }

            if($this->input->post('budget_from') >= $this->input->post('budget_to')){
                $response = array('status' => 0, 'message' => 'Please select valid budget'); 
                echo json_encode($response); exit;
            }

            $set = array('event_type', 'event_date', 'guest_number', 'contact_number', 'budget_from', 'budget_to', 'address', 'latitude', 'longitude', 'description');
            foreach ($set as $key => $val) {
                $post= $this->input->post($val);
                if(!empty($post))
                $dataInsert[$val] = $post;
            }

            
            $today_time =  date("H:i"); ;
            $today_date =  date("Y-m-d");
           
            if($this->input->post('event_date') == $today_date){
 
                if($this->input->post('event_time') <= $today_time){  
                    $response = array('status' => 0, 'message' => 'Please select valid time');
                    echo json_encode($response); exit;
                } 
            }
        
            $dataInsert['event_time'] = $this->input->post('event_time');
            $dataInsert['currency_symbol'] = $currency_symbol;
            $dataInsert['currency_code'] = $currency_code;
            $dataInsert['post_author'] = $user_id;  //post user id
            $dataInsert['created_on'] = datetime();
            $dataInsert['updated_on'] = datetime();
           
            $add_post = $this->common_model->insertData(POSTS, $dataInsert);

            if($add_post > 0){
                $cat_id = $this->input->post('category'); //category ID
                $cat_data = array('post_id'=>$add_post, 'category_id'=>$cat_id, 'created_on'=>datetime());
                $this->common_model->insertData(POST_CAT_MAPPING, $cat_data);
                $this->load->model('service/service_model'); //load push notification model
                $post_data = $this->service_model->get_post_list(array('p.id' => $add_post), $user_id, 1); //get last inserted post details
                //send notification
                $notif_where = array('category_id'=>$cat_id, 'status'=>1, 'deviceToken !=' => '');
                
                //get users(vendors) of this category
                $all_users = $this->common_model->GetJoinRecord(USR_CAT_MAPPING, 'user_id', USERS, 'id', 'user_id,deviceToken', $notif_where); 
                //get comma separated device tokens of above users
                $all_tokens = $this->common_model->GetJoinRecord(USR_CAT_MAPPING, 'user_id', USERS, 'id', 'GROUP_CONCAT(deviceToken) as deviceToken', $notif_where);
               
                if(!empty($all_users['result']) && !empty($all_tokens['result'])){
                    
                    //prepare notification payload
                    $registrationIds = explode(",", $all_tokens['result'][0]->deviceToken); 
                   
                    $title = "New post created";
                    //body to be sent with current notification
                    $body_send = $this->session->userdata['fullName'].' posted event '.$post_data[0]['event_name']; 
                    //body to be saved in DB
                    $body_save = '[UNAME] posted event [ENAME]';
                    $notif_type = 'post_create';
                    $this->load->model('post_model');
                    $notif_msg = $this->post_model->send_push_notification($registrationIds, $title, $body_send, $add_post, $notif_type);
                    
                    if($notif_msg){

                      
                        $notif_msg['body'] = $body_save; //replace body text with placeholder text
                        foreach($all_users['result'] as $u){
                            //save notification
                            $insertdata = array('notification_by'=>$user_id, 'notification_for'=>$u->user_id, 'notification_message'=>json_encode($notif_msg), 'notification_type'=>$notif_type, 'reference_id'=>$notif_msg['reference_id'] ,'created_on'=>datetime());
                           
                            if($u->deviceToken == 'system'){
                                $insertdata['is_show'] = '0';
                            }

                            $this->notification_model->save_notification(NOTIFICATIONS, $insertdata); 
                        }
                    }
                }
                
                $response = array('status' => 1, 'message' => 'Added successfully', 'url' => base_url("home/posts")); //success msg
            }
        }//End if
        echo json_encode($response);
    }

    // for getting post detail 
    function postDetail($post_id)
    { 
        $this->check_user_session();
        //check if post exist
        $post_id = decoding($post_id);
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id,'status'=>1));
        if(!$is_exist){
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('pageNotFound',$data);
        }else{
            $this->load->model('post_model');
            //get post detail by ID
            $data['post_detail'] = $this->post_model->get_post_detail(array('p.id'=>$post_id));
            $offset = $this->input->get('offset'); $limit = $this->input->get('limit');
            if(empty($offset) || empty($limit)){
                $limit= 10; $offset = 0;
            }
            $data['doing_users'] = $this->common_model->get_doing_user_list($post_id, $limit, $offset=0);
           
            $data['front_scripts'] = $data['front_styles'] = '';
            $this->load->front_render('my_post_detail', $data, ''); 
        }        
    }

    //delete an existing post
    function deletePost()
    {
    
        $current_user_id = $this->session->userdata['id']; 
        $post_id = $this->input->post('id');  // delete id
        //check if post belongs to user
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id, 'post_author'=>$current_user_id)); 
        if(!$is_exist){
            $response = array('status' => 0, 'message' => 'No Record found'); //fail- not authorised
            echo json_encode($response); exit;
        }

        $up_data = array('status'=>0); 
        $where = array('id'=> $post_id);
        $delete_post = $this->common_model->updateFields(POSTS, $up_data, $where); //do not delete posts- just change status to 0

        if(!$delete_post)
        { 
           $response = array('status'=>0,'message'=>'Something went wrong. Please try again'); //success
            echo json_encode($response); exit;
        }

        $response = array('status'=>1,'message'=>'Post deleted successfully','url'=>base_url("home/posts/")); //success
        $this->common_model->deleteData(NOTIFICATIONS,array('reference_id'=>$post_id));
        echo json_encode($response); exit;

    }


    // update post view load here
    function editPost($post_id)
    {
        $this->check_user_session();
        //get post detail by ID
        $post_id = decoding($post_id);
        $this->load->model('post_model');
        $this->load->model('home_model'); //load home model
        $data['event_type']    = $this->home_model->getAllData(EVENT_TYPE);
        $data['post_detail'] = $this->post_model->get_post_detail(array('p.id'=>$post_id));
        $data['front_scripts'] = $data['front_styles'] = '';
        $this->load->front_render('update_post', $data, '');  
    }

    //update user's post here
    function updatePost()
    {
        $check_auth = $this->check_ajax_auth(); 
        if($check_auth !== TRUE){ 
            echo $check_auth;
            exit;
        }
        //check for user id
        $current_user_id = $this->session->userdata['id']; 
        $post_id = $this->input->post('id');
        $this->form_validation->set_rules('event_type', 'Event type', 'trim|required');
        $this->form_validation->set_rules('event_date', 'Event date', 'trim|required');
        $this->form_validation->set_rules('event_time', 'Event time', 'trim|required');
        $this->form_validation->set_rules('guest_number', 'Guest number', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
        $this->form_validation->set_rules('budget_from', 'Budget from', 'trim|required');
      
        $this->form_validation->set_rules('currency_symbol', 'Currency symbol', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');


        if($this->input->post('budget_from') != '10000+'){
            
            $this->form_validation->set_rules('budget_to', 'Budget to', 'trim|required');
        }

        //check if post belongs to user
        $is_exist = $this->common_model->is_data_exists(POSTS, array('id'=>$post_id, 'post_author'=>$current_user_id));
        if(!$is_exist){
            $response = array('status' => FAIL, 'message' => 'Cannot edit this post');
            echo json_encode($response); die;
        }
       
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            echo json_encode($response); die;
        }
        
        if($this->input->post('budget_from') >= $this->input->post('budget_to')){
            $response = array('status' => 0, 'message' => 'Please select valid budget'); 
            echo json_encode($response); exit;
        }


        $set = array('event_type', 'event_date', 'guest_number', 'contact_number', 'budget_from', 'budget_to', 'currency_code', 'currency_symbol', 'address', 'latitude', 'longitude', 'description');
        foreach ($set as $key => $val) {
            $post = $this->input->post($val);
            $update_data[$val] = $post;
        }
        //for getting currency symbol from currency code
        $currency_code = $this->input->post('currency_symbol');
        $url = APPPATH.'third_party/currency.json'; 
        $jsonData = json_decode(file_get_contents($url));  
        foreach ($jsonData as $key => $val) {
            if($val->code == $currency_code)
            {   
                $currency_symbol = $val->symbol; 
            }
        }
        $update_data['currency_code'] = $currency_code;
        $update_data['currency_symbol'] =  $currency_symbol;
        $update_data['updated_on'] = datetime();
        
        $today_time =  date("H:i"); ;
        $today_date =  date("Y-m-d");
       
        if($this->input->post('event_date') == $today_date){

            if($this->input->post('event_time') <= $today_time){  
                $response = array('status' => 0, 'message' => 'Please select valid time');
                echo json_encode($response); exit;
            } 
        }
        
        $update_data['event_time'] = $this->input->post('event_time');
        
        $where = array('id'=>$post_id);
        $is_updated = $this->common_model->updateFields(POSTS, $update_data, $where);  //insert new post data
        if($is_updated){
            $this->load->model('service/service_model');
            $response = array('status'=>1,'message'=>'Updated successfully','url'=>base_url("home/posts/postDetail/").encoding($post_id));
        }
        else{
            $response = array('status'=>0,'message'=>'Something went wrong. Please try again'); //fail- something went wrong
        }
        echo json_encode($response);
    }


}

