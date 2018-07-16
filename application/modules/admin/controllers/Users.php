<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Common_Controller {

    public $data = array();
    public $file_data = "";

    public function __construct() {
        parent::__construct();
        //$this->is_auth_admin();
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        if(!empty($_GET['userType'])){
            $user_type = $_GET['userType'];
            $data['user_type'] = $user_type;
            switch ($user_type) {
                case 'user':
                    $where = array('userType'=>$user_type);
                    $data['parent'] = "users";
                    $data['title'] = "Users";
                    break;
                case 'vendor':
                    $where = array('userType'=>$user_type);
                    $data['title'] = "Vendors";
                    $data['parent'] = "vendor";
                    break;
                default:
                    $where = array('userType !='=>'administrator');
                    $data['title'] = "All users";
                    $data['parent'] = "all_users";
                    
            }
        }
        else{
            $where = array('userType !='=>'administrator');
            $data['title'] = "All users";
            $data['parent'] = "all_users";
            $data['user_type'] = "all_users";
        }
        
        $user_data = $this->common_model->getAllwhere(USERS, $where, 'id', $order_type = 'DESC', $select = 'all');  //lq();
        $data['userList'] = $user_data['result'];
        
        
        $this->load->admin_render('user_list', $data, '');
    }
    
    //display user profile and related data

    public function profile($user_id){
        $select = 'userType';
        $where  = array('id'=>$user_id);
        $table  = USERS;
        $user_type = $this->common_model->customGet($select,$where,$table);
        if($user_type['userType'] == 'vendor'){
            $data['parent'] = "vendor";
            $data['title'] = "Profile";
        }else{
            $data['parent'] = "users";
            $data['title'] = "Profile";
        }
       
        $data['userDetail'] = $this->common_model->user_details($user_id, false); //get user details
        
        
        //pr($data);
        $this->load->admin_render('user_profile', $data, '');
        //echo $user_id; die;
    }


    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $this->data['title'] = lang("add_user");
        $option = array('table' => ORGANIZATION,
            'select' => 'name,id'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->view('add', $this->data);
    }

    public function reset_password() {
        $user_id_encode = $this->uri->segment(3);

        $data['id_user_encode'] = $user_id_encode;

        if (!empty($_POST) && isset($_POST)) {

            $user_id_encode = $_POST['user_id'];

            if (!empty($user_id_encode)) {

                $user_id = base64_decode(base64_decode(base64_decode(base64_decode($user_id_encode))));


                $this->form_validation->set_rules('new_password', 'Password', 'required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('reset_password', $data);
                } else {


                    $user_pass = $_POST['new_password'];

                    $data1 = array('password' => md5($user_pass));
                    $where = array('id' => $user_id);

                    $out = $this->common_model->updateFields(USERS, $data1, $where);



                    if ($out) {

                        $this->session->set_flashdata('passupdate', 'Password Successfully Changed.');
                        $data['success'] = 1;
                        $this->load->view('reset_password', $data);
                    } else {

                        $this->session->set_flashdata('error_passupdate', 'Password Already Changed.');
                        $this->load->view('reset_password', $data);
                    }
                }
            } else {

                $this->session->set_flashdata('error_passupdate', 'Unable to Change Password, Authentication Failed.');
                $this->load->view('reset_password');
            }
        } else {
            $this->load->view('reset_password', $data);
        }
    }

    /*public function get_user_list_ajax(){
        $this->load->model('tableList');
        //pr($_POST);
        $user_type = $_POST['user_type'];
        switch ($user_type) {
            case 'user':
                $where = array('userType'=>$user_type);
                break;
            case 'vendor':
                $where = array('userType'=>$user_type);
                break;
            default:
                $where = array('userType !='=>'administrator');
                
        }
        $this->tableList->set_data( USERS, array(null, 'id', 'fullName', 'email', 'contactNumber', 'userType', 'image', 'status'), array('fullName', 'email', 'contactNumber'), array('id', 'DESC'), $where ); 
        $list = $this->tableList->get_list();      
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
	   // print_r($data);die;
            $action ='';
		$no++;
		$row = array();
		$row[] = $no;
		$row[] = display_placeholder_text($user->fullName); 
		$row[] = display_placeholder_text($user->email); 
		$row[] = display_placeholder_text($user->contactNumber);
        $row[] = display_placeholder_text($user->userType); 
               
                if($user->status == 1) { $row[] =  '<p class="text-success">Active</p>'; } else { $row[] =  '<p  class="text-danger">Inactive</p>'; }
                $img = (!empty($user->image))? (filter_var($user->image, FILTER_VALIDATE_URL))? $user->image : base_url().USER_AVATAR_PATH.$user->image : base_url().USER_DEFAULT_AVATAR;
                $row[] = '<img width="80" class="img-circle" src="'.$img.'" />';
                $clk_event = "statusFn('".USERS."','id','".encoding($user->id)."','".$user->status."')";
                if($user->status == 1){ $title = 'Inactive user'; $icon = INACTIVE_ICON; } else{ $title = 'Active user'; $icon = ACTIVE_ICON; }
                $action = '<a href="javascript:void(0)" class="on-default edit-row table_action" onclick="'.$clk_event.'"  title="'.$title.'">'.$icon.'</a>';
                $link = base_url('admin/users/profile/'.$user->id);
                $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
                $row[] = $action;
		$data[] = $row;

        //$_POST['draw']='';
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tableList->count_all(),
			"recordsFiltered" => $this->tableList->count_filtered(),
			"data" => $data,
		);
        //output to json format
       echo json_encode($output);
    }*/


    public function get_user_list_ajax(){
        $this->load->model('tableList');
        //pr($_POST);
        $user_type = $_POST['user_type'];
        switch ($user_type) {
            case 'user':
                $where = array('u.userType'=>$user_type);
                break;
            case 'vendor':
                $where = array('u.userType'=>$user_type);
                break;
            default:
                $where = array('u.userType !='=>'administrator');
                
        }
        $this->tableList->set_data($where); 
        $list = $this->tableList->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) { 
       // print_r($data);die;
            $action ='';
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = display_placeholder_text($user->fullName); 
        $row[] = display_placeholder_text($user->email); 
        $row[] = display_placeholder_text($user->contactNumber);
        //$row[] = display_placeholder_text($user->userType);
        if($user->userType == 'vendor'){ 
            $row[] = display_placeholder_text($user->name); 
        }       
                if($user->status == 1) { $row[] =  '<p class="text-success">Active</p>'; } else { $row[] =  '<p  class="text-danger">Inactive</p>'; }
                $img = (!empty($user->image))? (filter_var($user->image, FILTER_VALIDATE_URL))? $user->image : base_url().USER_AVATAR_PATH.$user->image : base_url().USER_DEFAULT_AVATAR;
                $row[] = '<img width="80" class="img-circle" src="'.$img.'" />';
                $clk_event = "statusFn('".USERS."','id','".encoding($user->id)."','".$user->status."')";
                if($user->status == 1){ $title = 'Inactive user'; $icon = INACTIVE_ICON; } else{ $title = 'Active user'; $icon = ACTIVE_ICON; }
                $action = '<a href="javascript:void(0)" class="on-default edit-row table_action" onclick="'.$clk_event.'"  title="'.$title.'">'.$icon.'</a>';
                $link = base_url('admin/users/profile/'.$user->id);
                $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
                $row[] = $action;
        $data[] = $row;

        //$_POST['draw']='';
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tableList->count_all(),
            "recordsFiltered" => $this->tableList->count_filtered(),
            "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }







    //users post list ajax

    public function get_my_post_list_ajax(){ 
         //pr($_POST);
        $user_id = $_POST['user_id'];
        $table = USERS;
        $where_in = array('id'=>$user_id);
        $key = 'userType';
        $user_type = $this->common_model->get_field_value($table, $where_in, $key);

        switch ($user_type) {
            case "user":
                $where['p.post_author'] = $user_id; 
            break;
            case "vendor":
                $where['doi.user_id'] = $user_id;
            break;
        }
        $this->load->model('my_post_list_model');
        $this->my_post_list_model->set_data($where);
        $list = $this->my_post_list_model->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            //print_r($user);die;
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = display_placeholder_text($user->event_name); 
            $row[] = display_placeholder_text($user->name);
            $row[] = display_placeholder_text($user->event_date); 
            
            /*$link = base_url('admin/users/profile/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';*/

            $link = base_url('admin/posts/detail/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
            $row[] = $action;
            $data[] = $row;
            //$_POST['draw']='';
        }

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->my_post_list_model->count_all(),
                    "recordsFiltered" => $this->my_post_list_model->count_filtered(),
                    "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }
    
    /****post list****/
    public function get_post_list_ajax(){ 
         //pr($_POST);
        $user_id = $_POST['user_id'];
        $where_in = array('user_id'=>$user_id);
        $select = 'category_id';
        $select_cat = $this->common_model->customGet($select,$where_in,'user_category_mapping');
        //pr($select_cat);
        $cat_id = $select_cat['category_id'];
        $table = POST_CAT_MAPPING; 
        $where_cat = array('category_id'=>$cat_id);
        $select = '*';
        $user_post = $this->common_model->getMultipleData($select,$where_cat,$table);
        //pr($user_post);

        $this->load->model('post_list_model');
        $where['map.category_id'] = $cat_id; 
        $this->post_list_model->set_data($where); 
        $list = $this->post_list_model->get_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            //print_r($user);die;
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = display_placeholder_text($user->event_name); 
            $row[] = display_placeholder_text($user->name);
            $row[] = display_placeholder_text($user->event_date); 

            $link = base_url('admin/posts/detail/'.$user->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
            $row[] = $action;
            $data[] = $row;
            //$_POST['draw']='';
        }

        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->post_list_model->count_all(),
                    "recordsFiltered" => $this->post_list_model->count_filtered(),
                    "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }

} //End class
