<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Common_Controller {

    public $data = "";

    function __construct() {
        parent::__construct();
        
    }

    public function index() {
        if(!empty($this->session->userdata('id')))
            redirect('admin/dashboard');
        
        $data['title'] = "Login | Register";
       
        $data['email'] = array('name' => 'email',
            'id' => 'email',
            'class'=> 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
            'placeholder' => 'Email Id',
        );
        $data['password'] = array('name' => 'password',
            'id' => 'password',
            'class'=> 'form-control',
            'type' => 'password',
            'placeholder' => 'Password',
        );
        $this->load->view('login', $data);
        //$this->load->admin_render('login', $data, 'login_process');
    }

    /**
     * @method login
     * @description login authentication
     * @return array
     */
    public function login() {
        //$this->data['title'] = $this->lang->line('login_heading');
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            redirect('admin/');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() == FALSE){ 
            $errors = validation_errors();
            $this->session->set_flashdata('login_err', $errors);
            redirect('admin','refresh');
        } 
        else { 
            $data_val['email']  	= $this->input->post('email');
            $data_val['password'] 	= $this->input->post('password'); 
           
            $isLogin = $this->common_model->isLogin($data_val, USERS);
            if($isLogin){
                $this->session->set_flashdata('success', 'User authentication successfully done!. ');
                redirect('admin/dashboard');
            }
            else{
                $error = 'Invalid email or password';
                $this->session->set_flashdata('login_err', $error);
                redirect('admin','refresh');
            }
        }
        
    }

    /**
     * @method logout
     * @description logout
     * @return array
     */
    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Sign out successfully done! ');
        $response = array('status' => 1);
        echo json_encode($response);
        die;
    }
    
    public function dashboard() {
        if(empty($this->session->userdata('id')))
            redirect(site_url().'admin');
        
        $data['parent'] = "Dashboard";
        $data['title'] = "Dashboard";
        
        $this->load->admin_render('dashboard', $data, '');
    }
    
    /**** for about us ****/
    public function about_us(){
        //$this->data['parent'] = "Profile";
        $data['parent'] = "about_us";       
        $data['title'] = "about_us"; 
        $select = '*';
        $where = array('content_type' => 'about_us'); 
        $table = CONTENT;
        $data['content'] = $this->common_model->customGet($select,$where,$table); 
        $this->load->admin_render('about_us', $data, '');
    }

    public function updateContent(){

        $this->form_validation->set_rules('content', 'content', 'required');
        
        if ($this->form_validation->run() == FALSE){ 
            $requireds = strip_tags($this->form_validation->error_string()) ? strip_tags($this->form_validation->error_string()) : ''; //validation error
            $response = array('status' => 0, 'message' => $requireds , 'url' => base_url('admin/about_us'));    
        } else { 
             
            $additional_data = array(
                'content' => $this->input->post('content')
            );
      
            $table  = CONTENT;
            $where  = array('content_type' => 'about_us'); 
            $update = $this->common_model->updateData($table, $additional_data, $where);
            //pr($update);
            if($update > 0):
                $response = array('status' => 1, 'message' => 'updated successfully', 'url' => base_url('admin/about_us')); //success msg
            endif;
        }//End if
        echo json_encode($response);
    }


    /**
     * @method profile
     * @description profile display
     * @return array
     */
    public function profile() {
        //$this->data['parent'] = "Profile";
        $data['parent'] = "Profile";
        $select = '*';
        $where = array('id' => $this->session->userdata('id'),'userType'=>'administrator'); 
        $table = USERS;

        $data['admin'] = $this->common_model->customGet($select,$where,$table); 
        //$this->data['title'] = "Profile";
        $data['title'] = "Profile"; 
        $this->load->admin_render('admin_profile', $data, '');
    }

    /**
     * @method updateProfile
     * @description user profile update
     * @return array
     */

    function updateProfile()
    { 
        $this->form_validation->set_rules('fullName', 'Full Name', 'required');
        
        if ($this->form_validation->run() == FALSE){ 
            $requireds = strip_tags($this->form_validation->error_string()) ? strip_tags($this->form_validation->error_string()) : ''; //validation error
            $response = array('status' => 0, 'message' => $requireds , 'url' => base_url('admin/profile'));    
        } else { 
             
            $additional_data = array(
                'fullName' => $this->input->post('fullName')
            );
            $image['image_name'] = '';
            if(!empty($_FILES['image']['tmp_name'])):

                $this->load->model('image_model');
                $folder  = 'profile';
                $hieght  = $width = 215;
                $image = $this->image_model->updateMedia('image',$folder,$hieght,$width,FALSE);
                //pr($image['image_name']);
                if(is_array($image['image_name'])):
                    $error = $this->upload->display_errors();
                    $response['status']=0; $response['message']= $error; 
                    echo json_encode($response); die;
                endif;
            endif;
            if(is_string($image['image_name'])&& !empty($image['image_name'])){
            
                $additional_data['image']       = $image['image_name'];
            }
            //pr($additional_data);
            $table = USERS;
            $where = array('id' => $this->session->userdata('id'),'userType'=>'administrator');
            $update =  $this->common_model->updateData($table, $additional_data, $where);
          

            $select = '*';
            $where_in = array('id' => $this->session->userdata('id'),'userType'=>'administrator');
            $updated_session = $this->common_model->customGet($select,$where_in,$table);

            $session_data['fullName']   = $updated_session['fullName'] ;
            $session_data['image']      = $updated_session['image'] ;
            $this->session->set_userdata($session_data);
            //pr($update);
            if($update > 0):
                $response = array('status' => 1, 'message' => 'Your profile updated successfully', 'url' => base_url('admin/profile')); //success msg
            endif;
        }//End if
        echo json_encode($response);
    }


    /**
     * @method password
     * @description change password dispaly
     * @return array
     */
    public function password() {
        $this->data['parent'] = "Password";
        $this->adminIsAuth();
        $this->data['error'] = "";
        $this->data['message'] = "";
        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        $this->data['old_password'] = array(
            'name' => 'old',
            'id' => 'old',
            'type' => 'password',
            'class' => 'form-control'
        );
        $this->data['new_password'] = array(
            'name' => 'new',
            'id' => 'new',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            'class' => 'form-control'
        );
        $this->data['new_password_confirm'] = array(
            'name' => 'new_confirm',
            'id' => 'new_confirm',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            'class' => 'form-control'
        );
        $this->data['user_id'] = array(
            'name' => 'user_id',
            'id' => 'user_id',
            'type' => 'hidden',
            'value' => $this->session->userdata('user_id'),
        );
        $this->data['title'] = "Password";
        $this->load->admin_render('changePassword', $this->data);
    }

    /**
     * @method change_password
     * @description change password
     * @return array
     */

    function changePassword()
    {
        $this->load->library('form_validation');
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
            $table  = USERS;
            $select = "password";
            $where = array('id' => $this->session->userdata('id'),'userType'=>'administrator'); 
            $admin = $this->common_model->customGet($select,$where,$table);
            
            if(password_verify($password, $admin['password'])){
                $set =array('password'=> password_hash($this->input->post('npassword') , PASSWORD_DEFAULT)); 
                $update = $this->common_model->updateData($table, $set, $where);
                if($update){
                    $res = array();
                    if($update){
                        $res['url']= base_url('admin/profile'); $res['status']=1; $res['message']='Password Updated successfully';
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


    /**
     * @method forgot_password
     * @description forgot password
     * @return array
     */

    public function forgot_password() {
        $data['parent'] = "Profile";
        $data['title'] = "Profile"; 
        $this->load->view('forgot_password', $data, '');
    }

    public function reset_password(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email',array('required'=>'Please Enter Email'));
        

        $this->form_validation->set_error_delimiters('<div class="err_msg">', '</div>');
        if ($this->form_validation->run() == FALSE)
        { 
            $error = validation_errors(); 
            $res['status']=0; $res['message']= $error; 
            echo json_encode($res);      
        }
        else 
        {
            $email =$this->input->post('email');
            $table  = USERS;
            $select = "password";
            $where = array('email' =>$email); 
            $admin = $this->common_model->customGet($select,$where,$table);
            pr($admin);
            if(password_verify($password, $admin['password'])){
                $set =array('password'=> password_hash($this->input->post('npassword') , PASSWORD_DEFAULT)); 
                $update = $this->common_model->updateData($table, $set, $where);
                if($update){
                    $res = array();
                    if($update){
                        $res['url']= base_url('admin/profile'); $res['status']=1; $res['message']='Password Updated successfully';
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
    }






 /*   public function forgot_password() {
        $this->data['parent'] = "Forgot Password";
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }
        if ($this->form_validation->run() == false) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'placeholder' => 'Email',
                'class' => 'form-control'
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }


            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->load->view('forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("admin/forgot_password", 'refresh');
            }


            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/login", 'refresh'); //we should display a confirmation 
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("admin/forgot_password", 'refresh');
            }
        }
    }
*/
    /**
     * @method reset_password
     * @description reset password
     * @return array
     */
  /*  public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {


            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[6]|max_length[14]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {

                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password', $this->data);
            } else {

                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {


                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {

                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {

                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("admin/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('admin/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', "Token has been expired");
            redirect("admin/forgot_password", 'refresh');
        }
    }*/

    public function resetPasswordApp($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {


            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[6]|max_length[14]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {

                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password_app', $this->data);
            } else {

                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {


                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    if ($change) {
                        $this->session->set_flashdata('success', $this->ion_auth->messages());
                        redirect('admin/passConfirmAuth/');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('admin/resetPasswordApp/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("admin/forgot_password", 'refresh');
        }
    }
    
    public function passConfirmAuth(){
       $this->load->view('admin/success_view'); 
    }

    /**
     * @method _get_csrf_nonce
     * @description generate csrf
     * @return array
     */
    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    /**
     * @method _valid_csrf_nonce
     * @description valid csrf
     * @return array
     */
    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }



}
