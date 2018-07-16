<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Common_Controller {

    public $data = array();
    
    public function __construct() {
        parent::__construct();
        //$this->is_auth_admin();
        $this->load->model('Image_model');
        $this->form_validation->CI =& $this;  //required for form validation callbacks in HMVC
        $this->name_exists_msg = 'Category name already exist';
        $this->validation_rules = array(
                                array(
                                    'field' => 'cat_name',
                                    'label' => 'Category Name',
                                    'rules' => 'required|trim|min_length[2]|max_length[200]|strip_tags'
                                    ),
                                array(
                                    'field' => 'cat_desc',
                                    'label' => 'Category Description',
                                    'rules' => 'trim|alpha_numeric|max_length[200]|strip_tags'
                                    )
        );
    }
    
    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $data['title'] = 'Add category';
        
        $this->load->view('add_category', $data);
    }
    
    //validation callback for checking alpha_spaces
    public function _alpha_spaces_check($string){
        if(alpha_spaces($string)){
            return true;
        }
        else{
            $this->form_validation->set_message('_alpha_spaces_check','Only alphabets and spaces are allowed in {field} field');
            return FALSE;
        }
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */

  /*  public function index() {
        $data['parent'] = "category";
        
        $user_data = $this->common_model->getAllwhere(CATEGORIES, '', 'cat_order', $order_type = 'ASC', $select = 'all',$limit = '50', $offset = '0'); 
        $data['catList'] = $user_data['result'];
        
        $data['title'] = "Category";
        $this->load->admin_render('category_list', $data, '');
    }

*/

     public function index() {
        $data['parent'] = "category";
        $data['title'] = "Category";
        $user_data = $this->common_model->getAllwhere(CATEGORIES, '', 'cat_order', $order_type = 'ASC', $select = 'all',$limit = '50', $offset = '0'); 
      
        $data['catList'] = $user_data['result'];
        $this->load->admin_render('category_list', $data, '');
    }




    /****selected category****/
    public function singleCategory() {
        $cat_id = $this->input->post('catId'); 
        if(!empty($cat_id)){
            $where = array('id'=> $cat_id);
            $user_data = $this->common_model->getAllwhere(CATEGORIES, $where, 'cat_order', $order_type = 'ASC', $select = 'all',$limit = '50', $offset = '0');            
        }else{
            $user_data = $this->common_model->getAllwhere(CATEGORIES, '', 'cat_order', $order_type = 'ASC', $select = 'all',$limit = '50', $offset = '0'); 
        }
        
        $data['catList'] = $user_data['result'];
        
        $this->load->view('single_category', $data, '');
    }



    /**** update category order ****/
    public function updateOrder()
    {
        if(isset($_GET["order"])) { 
            $order  = explode(",",$_GET["order"]); 
            $order_count = count($order); 
            for($i=0;$i<$order_count;$i++) {
                $data['cat_order'] = $i;
                $where = array('id'=>$order[$i]); 
                $table = CATEGORIES;
                $update_order = $this->common_model->updateData($table, $data, $where); 
                
            }
        }
    }
    
    public function add_category(){
        $v_rules = $this->validation_rules;
        $v_rules[] = array( 
                        'field' => 'cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|min_length[2]|max_length[200]|strip_tags|callback__check_unique[categories.name]'
                    );  //we have check unique category name so redefining cat_name rule here
        $this->form_validation->set_rules($v_rules);
        if ($this->form_validation->run() == FALSE){
            $messages = (validation_errors()) ? validation_errors() : ''; //validation error
            $response = array('status' => 0, 'message' => $messages);
        }
        else{
            $image = array(); $cat_image = '';
            if (!empty($_FILES['cat_image']['name'])) {
                
                $folder     = 'category';
                $hieght = $width = 600;
                $image = $this->Image_model->updateMedia('cat_image',$folder,$hieght,$width,FALSE); //upload media of category
                
                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response); die;
                }
                
                //check for image name if present
                if(array_key_exists("image_name",$image)):
                    $cat_image = $image['image_name'];
                endif;
			
            }
            $cat_name = $this->input->post('cat_name');
            $cat_alias = make_alias($cat_name, CATEGORIES); //make an alias of name(make name lowercase and replace all spaces with underscore)

            $dataInsert = array(
                'name' => $cat_name,
                'alias' => $cat_alias,
                'image' => $cat_image,
                'createdOn' => datetime()
            );
            $cat_id = $this->common_model->insertData(CATEGORIES, $dataInsert);  //insert category data

            if(!empty($image) && $cat_id){
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with category ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$cat_id, 'reference_table'=>CATEGORIES);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachemnt with category id
                    }
                }  
            }
            if($cat_id){
                $response = array('status' => 1, 'message' => 'Successfully Added', 'url' => base_url('admin/category')); //success msg
            }
            else{
                $response = array('status' => 0, 'message' => 'Something went wrong'); //Cat ID not found- error msg
            }  
        }  
        echo json_encode($response);
    }
    
    //validation callback fn to check unique category name
    function _check_unique($str, $tb_data){
        $tb_arr = explode(".",$tb_data);
        $where = array($tb_arr[1]=>$str);
        $result = $this->common_model->getsingle($tb_arr[0], $where);
       
        if(!empty($result)){
            $this->form_validation->set_message('_check_unique',$this->name_exists_msg);
            return FALSE;
        }
        else{
            return TRUE;
        }     
    }
    
    
    //Edit category modal load
    public function edit() {
        $data['title'] = 'Edit Category';
        $id = decoding($this->input->post('id'));
        $where = array('id'=>$id);
        $user_data = $this->common_model->getsingle(CATEGORIES, $where);
       
        if(!empty($user_data)){
            $data['results'] = $user_data;
            $this->load->view('edit_category', $data);
        }
    }
    
    //update category
    public function update(){
        $v_rules = $this->validation_rules;  //category validation  rules
        $this->form_validation->set_rules($v_rules); //set rules
        $where_id = $this->input->post('id');
        if ($this->form_validation->run($v_rules) == FALSE){
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        else{
            //check for unique name skipping current category name
            $cat_name = $this->db->escape($this->input->post('cat_name'));
            $where = 'id != '.$where_id.' AND name = '.$cat_name; 
            $result = $this->common_model->getsingle(CATEGORIES, $where);
            if(!empty($result)){
                $response = array('status' => 0, 'message' => $this->name_exists_msg);  //category name already exists
                echo json_encode($response); die;
            }
            
            $image = array(); $existing_img = $this->input->post('exists_image');
            if (!empty($_FILES['cat_image']['name'])) {
                
                $folder     = 'category';
                $height = $width = 600;
                $image = $this->Image_model->updateMedia('cat_image',$folder,$height,$width,FALSE); //upload media of category
                
                //check for error
                if(array_key_exists("error",$image) && !empty($image['error'])){
                    $response = array('status' => 0, 'message' => $image['error']);
                    echo json_encode($response); die;
                }
            }
            
            $cat_name = $this->input->post('cat_name');
            $cat_alias = make_alias($cat_name, CATEGORIES); //make an alias of name(make name lowercase and replace all spaces with underscore)

            $update_data = array(
                'name' => $cat_name,
                'alias' => $cat_alias,
            );
                
            //check for image name if present
            $new_file = 0;
            if(array_key_exists("image_name",$image)){
                $cat_img = $image['image_name'];
                if(!empty($cat_img)){
                    $update_data['image'] = $cat_img;
                    //delete old attachment from server
                    $new_file = 1;
                    if(!empty($existing_img)){
                        $this->common_model->delete_attachment($where_id, CATEGORIES, $existing_img);
                    }
                }
            }
                
            $update_where = array('id'=>$where_id);
            $cat_id = $this->common_model->updateFields(CATEGORIES, $update_data, $update_where);  //update category data

            if(!empty($new_file)){
                if(array_key_exists("attachments",$image) && !empty($image['attachments']) ){
                    //update attachement with category ID
                    foreach($image['attachments'] as $att_id){
                        $where = array('id'=>$att_id);
                        $update = array('reference_id'=>$where_id, 'reference_table'=>CATEGORIES);
                        $this->common_model->updateFields(ATTACHMENTS, $update, $where);  //update attachment with category id
                    }
                }  
            }
            $response = array('status' => 1, 'message' => ResponseMessages::getStatusCodeMessage(135), 'url'=>base_url('admin/category')); //success msg
            
        }
        
        echo json_encode($response);
    }
    
    //category delete
    public function delete() {
        $id = decoding($this->input->post('id')); // delete id
        $table = $this->input->post('table'); //table name
        $id_name = $this->input->post('id_name'); // table field name
        if (!empty($table) && !empty($id) && !empty($id_name)) {
            $this->common_model->delete_attachment($id, $table); //delete all attachments related to category
            $where = array($id_name => $id);
            $delete = $this->common_model->deleteData($table, $where);
            if ($delete) {
                $response = array('status'=>1,'message'=>'Record deleted successfully'); //success
            } 
            else{
                $response = array('status'=>0,'message'=>'Record not found. Please try again'); //record not found
            }
        }
        else {
            $response = array('status'=>0,'message'=>'Something went wrong. Unable to delete record. Please try again'); //post data missing
        }
        echo json_encode($response); die;
    }
}
