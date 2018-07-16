<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//General service API class 
class Service extends CommonService{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Image_model'); //load image model
    }
    function registration_post(){

        $this->form_validation->set_rules('fullName', 'Name', 'trim|required|min_length[2]|max_length[100]|callback__alpha_spaces_check');
        $this->form_validation->set_rules('userType', 'User Type', 'trim|required|min_length[2]|max_length[100]|callback__alpha_spaces_check');
        
        if (empty($_POST['socialId']) && empty($_POST['socialType'])){
            //if not social login- make these fields mandatory
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]', array('is_unique' => 'This email already exist'));
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]');
            $this->form_validation->set_rules('contactNumber', 'Mobile Number', 'trim|required|numeric|is_unique[users.contactNumber]',  array('is_unique' => 'This Contact number already exist')); 
            
            if($this->input->post('userType') == 'vendor'){
                //for normal register and user type vendor only
                $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric'); 
            }
        }
        

        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
            $this->response($response);
        }
        else{
            ///$this->load->library('encrypt');
            $authtoken = $this->service_model->generate_token();
            $image = array();
            if(!empty($_FILES['image']['name'])){
                
                $folder     = 'user_avatar';
                $hieght = $width = 600;
                $image = $this->Image_model->updateMedia('image',$folder,$hieght,$width,FALSE);
            }
            if(array_key_exists("error",$image) && !empty($image['error'])){
                $response = array('status' => FAIL, 'message' =>$image['error']);
                $this->response($response);
            }


            $authtoken = $this->service_model->generate_token();
            $data = array();
            $set = array('fullName','email','userType','countryCode','contactNumber','deviceToken','deviceType','socialType','socialId');
            foreach ($set as $key => $val) {
                $post= $this->post($val);
                $data[$val] = (isset($post) && !empty($post)) ? $post :''; 
            }

            $data['password'] =  password_hash($this->post('password'), PASSWORD_DEFAULT);  //it is goood to use php's password hashing algo
            $date             = date("Y-m-d h:i:s");
            $data['createdOn'] = $date;

            if(array_key_exists("image_name",$image)){
                $data['image'] = $image['image_name'];
            }
            elseif (filter_var($this->input->post('image'), FILTER_VALIDATE_URL)) {
                $data['image'] = $this->input->post('image');
            }
            $data['authToken'] 		= $authtoken;
            $result = $this->service_model->registration($data);
            if(is_array($result)){
                
                //check if returndata array exists in restult array 
                if(array_key_exists("returnData",$result)){
                    $user_id = $result['returnData']->id;  //user id of last inserted user
                    if(array_key_exists("attachments",$image) && !empty($image['attachments'])){
                        //update attcahement with user ID

                        foreach($image['attachments'] as $att_id){
                            $where = array('id'=>$att_id);
                            $update = array('reference_id'=>$user_id, 'reference_table'=>USERS);
                            $this->common_model->updateFields(ATTACHMENTS, $update, $where);
                        }
                    }
                    //insert vendor category
                    if(!empty($this->input->post('category'))){

                        $category = $this->input->post('category');
                        $is_exists = $this->common_model->is_data_exists(USR_CAT_MAPPING, array('category_id'=>$category, 'user_id'=>$user_id)); 
                        if(!$is_exists){
                            $dataInsert = array('category_id'=>$category, 'user_id'=>$user_id, 'created_on'=>datetime());
                            $this->common_model->insertData(USR_CAT_MAPPING, $dataInsert);
                        }
                        $result['returnData'] = $this->service_model->userInfo(array('id' => $user_id)); //get user data again after inserting category
                    }
                }
                
                switch ($result['regType']){
                    case "NR":
                    $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(110), 'messageCode'=>'normal_reg','userDetail'=>$result['returnData']);
                    break;
                    case "AE":
                    $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(117),'userDetail'=>array());
                    break;
                    case "IU":
                    $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(133));
                    break;
                    case "SL":
                    $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(106),'messageCode'=>'social_login','userDetail'=>$result['returnData']);
                    break;
                    case "SR":
                    $response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(110),'messageCode'=>'social_reg','userDetail'=>$result['returnData']);
                    break;
                    default:
                    $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(121),'userDetail'=>array());
                }
            }
            else{
                $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118),'userDetail'=>array());
            }
            $this->response($response);
        }
    } //End Function

    //validation callback for checking alpha_spaces
    function _alpha_spaces_check($string){
        if(alpha_spaces($string)){
            return true;
        }
        else{
            $this->form_validation->set_message('_alpha_spaces_check','Only alphabets and spaces are allowed in {field} field');
            return FALSE;
        }
    }
        
    function login_post(){
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required');

        if($this->form_validation->run() == FALSE)
        {
                $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
                $this->response($response);
        }
        else
        {
            $authtoken = $this->service_model->generate_token();
            $this->load->library('encrypt');
            $data = array();
            $data['email'] = $this->post('email');
            $data['password'] = $this->post('password');
            $data['deviceToken'] = $this->post('deviceToken');
            $data['deviceType'] = $this->post('deviceType');
            $data['userType'] = $this->post('userType');
            $data['authToken'] = $authtoken;
            $result = $this->service_model->login($data,$authtoken);
            if(is_array($result)){
                switch ($result['returnType']) {
                    case "SL":
                    $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(106), 'userDetail' => $result['userInfo']);
                    break;
                    case "WP":
                    $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(124));
                    break;
                    case "WE":
                    $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(122));
                    break;
                    case "IU":
                    $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(133));
                    break;
                    case "WS":
                    $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(134));
                    break;
                    default:
                    $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(106), 'userDetail' => $result['userInfo']);
                }
            }
            else{
                $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(122));
            }
            $this->response($response);
        }
    } //End Function
          
    //show event data list- category, event type etc
    function getEventData_get(){
        $offset = $this->get('offset'); $records = $this->get('limit');
        
        if(!isset($offset) || empty($records)){
            $offset = 0; $records= 50;
        }
        
        $cat_result = $this->common_model->get_category_data('cat.id, cat.name', $records, $offset);  //get all category data
        $eve_type_data = $this->common_model->getAllwhere(EVENT_TYPE, '', 'id', $order_type = 'ASC', $select = 'id, event_name', $records, $offset);
        $response = array('status' => SUCCESS, 'category' => $cat_result, 'event_type'=>$eve_type_data['result']);
        $this->response($response);  
    }

    //user forgot password
    function forgotPassword_post(){
        $email = $this->post('email');
        $response = $this->service_model->forgotPassword($email);
        //print_r($response); die;
        if($response['emailType'] == 'ES'){
            $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(106), 'userInfo' => $response['email']);
        }
        else{
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(131));
        }

        $this->response($response);
    } //End function

    function aboutUS_get(){
        $result = $this->service_model->aboutUS();
        if($result){
            $response = array('status' => SUCCESS, 'message' => ResponseMessages::getStatusCodeMessage(126), 'about_us' => $result['content']);
        }else{
            $response = array('status' => FAIL, 'message' => ResponseMessages::getStatusCodeMessage(131), 'about_us' => $result['content']);
        }
    
        $this->response($response);
    }

   

}//End Class 

