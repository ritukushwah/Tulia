<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    { 
        $data['front_scripts']  = array('init-round.js');
        $data['front_styles'] = '';
        $this->load->front_render('home', $data, '');
                
    }

    function sendMail(){
        $email = $this->input->post('email');

        $this->load->model('home_model');
        $checkEmail = $this->home_model->checkEmail($this->input->post('email'));
        if($checkEmail == 1){
            echo 1;
        }else{
            echo 0;
        }

        
    }

    public function addFeedback(){
     
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|max_length[200]');
        
        if ($this->form_validation->run() == FALSE){ 
            $response = array('status' => FAIL , 'url' => base_url(), 'message' => strip_tags(validation_errors()));
        }else{ 
             
            $dataInsert = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message')
            );
      
            $table  = FEEDBACK;
            $add_feedback = $this->common_model->insertData($table, $dataInsert);

            if($add_feedback > 0):
                $response = array('status' => 1, 'message' => 'Added successfully', 'url' => base_url()); //success message
            endif;
        }//End if
        echo json_encode($response);
    }

 
    public function login(){   
        if(!empty($this->session->userdata('id'))){
            redirect('/home/users');
        }

        $this->load->model('home_model'); //load image models
        $data['category'] = $this->home_model->getAllData(CATEGORIES);
        $data['front_scripts'] = array('facebook.js');
        $data['front_styles'] = '';
        $this->load->front_render('login', $data, '');      
    }

    public function userLogin()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() == FALSE){ 
            $response = array('status' => FAIL , 'url' => base_url(), 'msg' => strip_tags(validation_errors()));
        }else{ 

            $data_val['email']      = $this->input->post('email');
            $data_val['password']   = $this->input->post('password');
            $data_val['userType']   = $this->input->post('userType');
            $this->load->model('home_model'); //load image models

            $isLogin = $this->home_model->isLogin($data_val, USERS);
            if($isLogin['status'] == 1){
                $current_user_type = $this->session->userdata['userType']; 
                if($current_user_type == 'user'){
                    $response = array('status' => 1, 'message' => 'logged in successfully', 'url' => base_url("home/posts/")); //success message
                }else{
                    $response = array('status' => 1, 'message' => 'logged in successfully', 'url' => base_url('home/vendorpost/allEvents')); //success message
                }
                
            }else if($isLogin['status'] == 2){
                $response = array('status' => 2, 'message' => 'Password is incorrect'); 
            }else if($isLogin['status'] ==4){
                $response = array('status' => 4, 'message' => 'You are currently inactive from admin');
            }
            else{
                $response = array('status' => 3, 'message' => 'Invalid email or user type');
            }
        }//End if
        echo json_encode($response);
    }

    public function userRegistration(){
        $this->form_validation->set_rules('fullName', 'First name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('contactNumber', 'Contact number', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
       
        if ($this->form_validation->run() == FALSE){
            $messages = (validation_errors()) ? validation_errors() : ''; //validation error
            $response = array('status' => 0, 'msg' => $messages);
        }
        else{

            $this->load->model('home_model');
            $checkEmail = $this->home_model->checkEmail($this->input->post('fullName'),$this->input->post('email'),$this->input->post('contactNumber'));
            if($checkEmail == 1){
                $this->load->model('Image_model'); //load image models
                $image = array(); $image_name = $image = '';
                if (!empty($_FILES['image']['name'])) {
                    
                    $folder     = 'user_avatar';
                    $hieght = $width = 600;
                    $image = $this->Image_model->updateMedia('image',$folder,$hieght,$width,FALSE); //upload user profile image
                    
                    //check for error
                    if(array_key_exists("error",$image) && !empty($image['error'])){
                        $response = array('status' => 0, 'message' => $image['error']);
                        echo json_encode($response); die;
                    }
                    
                    //check for image name if present
                    if(array_key_exists("image_name",$image)):
                        $image_name = $image['image_name']; 
                    endif;
                }

                $password =  password_hash($this->input->post('password'), PASSWORD_DEFAULT);  //it is goood to use php's password hashing algorithm
                $dataInsert = array(
                    'fullName'      => $this->input->post('fullName'),
                    'email'         => $this->input->post('email'),
                    'contactNumber' => $this->input->post('contactNumber'),     
                    'password'      => $password,
                    'image'         => $image_name,
                    'userType'      => $this->input->post('userType'),
                    'address'       => $this->input->post('address'),
                    'deviceToken'   => 'system'
                    
                );

                $isRegister = $this->common_model->insertData(USERS, $dataInsert);  //insert user data
               
                if($isRegister){
                    if(!empty($image)){
                        if(array_key_exists("attachments",$image) && !empty($image['attachments'])){
                        //update attcahement with user ID
                            foreach($image['attachments'] as $att_id){ 
                                $where = array('id'=>$att_id);
                                $update = array('reference_id'=>$isRegister, 'reference_table'=>USERS);
                                $this->common_model->updateFields(ATTACHMENTS, $update, $where);
                            }
                        }
                    }
                
                if($this->input->post('userType') == 'vendor'){
                     //check category here
                    if(!empty($this->input->post('category'))){
                        $category = $this->input->post('category'); 
                            $is_exists = $this->common_model->is_data_exists(USR_CAT_MAPPING, array('category_id'=>$category, 'user_id'=>$isRegister)); 
                            if(!$is_exists){
                                $dataInsert = array('category_id'=>$category, 'user_id'=>$isRegister, 'created_on'=>datetime());
                                $this->common_model->insertData(USR_CAT_MAPPING, $dataInsert);
                        }
                    }
                }
                    
                    $isSession = $this->common_model->createSession($isRegister,USERS);
                    if($isSession){

                        $current_user_type = $this->session->userdata['userType']; 
                        if($current_user_type == 'user'){
                            $res = array('status'=>1,'message'=>'Registration successfully done', 'url' => base_url("home/posts/")); //success message
                        }else{
                            $res = array('status'=>1,'message'=>'Registration successfully done', 'url' => base_url('home/vendorpost/allEvents')); //success message
                        }
        
                    }
                     echo json_encode($res); exit;
                }
                else{
                    $response = array('status' => 0, 'message' => 'Something went wrong'); //Cat ID not found- error message
                }  


            }else{
                $response = array('status' => 0, 'message' => $checkEmail);
            }


        }  


        echo json_encode($response);
    }

   function create_session($id)
   {
        $session_data['id']  = $id;
        $this->session->set_userdata($session_data);
   }


   function socialRegister(){
        if(empty($this->input->post('socialType')) || empty($this->input->post('socialId'))){
            $res = array('status'=>0,'message'=>'Something went worng. Please try again');
            echo json_encode($res); exit;
        }

        /*$where = array('socialType'=>$this->input->post('socialType'), 'socialId'=>$this->input->post('socialId'));
        $is_exists = $this->common_model->is_data_exists(USERS, $where);*/
        $is_id_exist = $this->common_model->is_id_exist(USERS,'socialId',$this->input->post('socialId'));
        
        $checkTypeFB = 1;
        
        if($is_id_exist){
            $this->load->model('home_model');
            $checkTypeFB = $this->home_model->checkTypeFB($is_id_exist,$this->input->post('userType'));
        }


        if($checkTypeFB == 1){
       

            if($is_id_exist){

                $where = array('socialId'=>$this->input->post('socialId'),'status'=>1,'userType'=>$this->input->post('userType'));
                $is_data_exists = $this->common_model->is_data_exists(USERS, $where);
                if(!$is_data_exists){
                    $res = array('status'=>-1,'message'=>'You are currently inactive from admin'); 
                    echo json_encode($res); exit;
                }

                $isSession = $this->common_model->createSession($is_id_exist,USERS);
                $current_user_type = $this->session->userdata['userType']; 
                if($current_user_type == 'user'){
                    $res = array('status'=>1,'message'=>'Logged in successfully', 'url' => base_url("home/posts/")); //success message
                }else{
                    $res = array('status'=>1,'message'=>'Logged in successfully', 'url' => base_url('home/vendorpost/allEvents')); //success message
                }
               
                echo json_encode($res); exit;
            }

            if($this->input->post('userType')=='vendor'){ 
                $res = array('status'=>2,'msg'=>'Please select category');
                echo json_encode($res); exit;
            }

            //register user here and create session

            $data_val['fullName']       = $this->input->post('fullName');
            $data_val['email']          = $this->input->post('email');
            $data_val['socialId']       = $this->input->post('socialId');
            $data_val['socialType']     = $this->input->post('socialType');
            $data_val['image']          = $this->input->post('image');
            $data_val['userType']       = $this->input->post('userType');
            $data_val['authToken']      = $this->common_model->generate_token();
            $data_val['deviceToken']    = 'system';
            $is_register = $this->common_model->insertData(USERS, $data_val); 
            if($is_register){
                $isSession = $this->common_model->createSession($is_register,USERS);
                $current_user_type = $this->session->userdata['userType']; 
                if($current_user_type == 'user'){
                    $res = array('status'=>3,'message'=>'Regsitered Successfully', 'url' => base_url("home/posts/")); //success message
                }else{
                    $res = array('status'=>3,'message'=>'Regsitered Successfully', 'url' => base_url('home/vendorpost/allEvents')); //success message
                }
                
                echo json_encode($res); exit;
            }

        }else{
            $res = array('status'=>4,'message'=>'Please select correct user type.','url' => base_url('home/users'));
            echo json_encode($res); exit;
        }
     
    }//end FUnction


    //vendor registration with category
    function registerVendor(){
      
        //register vendor here and create session
        $userData = $_POST['t'];
        $data_val['fullName']       =  $userData['fullName'];
        $data_val['email']          =  $userData['email'];
        $data_val['socialId']       =  $userData['socialId'];
        $data_val['socialType']     =  $userData['socialType'];
        $data_val['image']          =  $userData['image'];
        $data_val['userType']       =  $userData['userType'];
        $data_val['authToken']      = $this->common_model->generate_token();
        $data_val['deviceToken']    = 'system';
        $is_register = $this->common_model->insertData(USERS, $data_val); 
        if($is_register){

             $isSession = $this->common_model->createSession($is_register,USERS);
            //check category here
            if(!empty($_POST['cat_name'])){
                $category = $_POST['cat_name']; 
                    $is_exists = $this->common_model->is_data_exists(USR_CAT_MAPPING, array('category_id'=>$category, 'user_id'=>$is_register)); 
                    if(!$is_exists){
                        $dataInsert = array('category_id'=>$category, 'user_id'=>$is_register, 'created_on'=>datetime());
                        $this->common_model->insertData(USR_CAT_MAPPING, $dataInsert);
                    }
            }
            $current_user_type = $this->session->userdata['userType']; 
                if($current_user_type == 'user'){
                    $res = array('status'=>1,'message'=>'Regsitered Successfully', 'url' => base_url("home/posts/")); //success message
                }else{
                    $res = array('status'=>1,'message'=>'Regsitered Successfully', 'url' => base_url('home/vendorpost/allEvents')); //success message
                }
           
            echo json_encode($res); exit;
        }
       
    }

     public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Sign out successfully done! ');
        redirect(site_url());
    }

} //End class
