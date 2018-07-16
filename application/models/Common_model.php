<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {
    
    /* Check user login and set session */
    function isLogin($data, $table){
        $email      = $data['email'];
        // check if e-mail address is well-formed
        $where = array('email'=>$email);
     
        $sql = $this->db->select('*')->where($where)->get($table);
        if($sql->num_rows()){
            $user = $sql->row();
            //verify password- It is good to use php's password hashing functions so we are using password_verify fn here
            if(password_verify($data['password'], $user->password)){
                $session_data['id']         = $user->id ;
                $session_data['fullName']   = $user->fullName ;
                $session_data['email']		= $user->email ;
                $session_data['image']      = make_user_img_url($user->image) ;
                $session_data['isLogin'] 	= TRUE ;
                $this->session->set_userdata($session_data);
                return TRUE;
            }
            else{
               return FALSE; 
            }
        }
        
       return FALSE;
    }//End Function


    function generate_token()
    {
        $this->load->helper('security');
        $res = do_hash(time().mt_rand());
        $new_key = substr($res,0,config_item('rest_key_length'));
        return $new_key;

    }

    function check_exist($where,$table)
    {
        $res = $this->db->select('id')->where($where)->get($table); 
        return $res->result_array();
    }


    // for creating session
    function createSession($isRegister, $table)
    {
        $where = array('id'=>$isRegister);
        $sql = $this->db->select('*')->where($where)->get($table);
        if($sql->num_rows()){

            $user = $sql->row();
            $session_data['id']         = $user->id ;
            $session_data['fullName']   = $user->fullName ;
            $session_data['email']      = $user->email ;
            $session_data['image']      = $user->image ;
            $session_data['userType']      = $user->userType ;

            $this->session->set_userdata($session_data);
            return TRUE;
        }
        return FALSE;
    }

    /* <!--INSERT RECORD FROM SINGLE TABLE--> */

    function insertData($table, $dataInsert) {
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }

    /* <!--UPDATE RECORD FROM SINGLE TABLE--> */

    function updateFields($table, $data, $where) {
        $this->db->update($table, $data, $where);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function updateData($table, $data, $where){
        $result = $this->db->update($table, $data, $where);
        if($result > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function deleteData($table,$where)
    {
        $this->db->where($where);
        $this->db->delete($table); 
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }   
    }

    function customGet($select,$where,$table){
        $this->db->select($select);
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql->row_array();
    }


    function getMultipleData($select,$where,$table){
        $this->db->select($select);
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql->result_array();
    }
    
    /* ---GET SINGLE RECORD--- */
    function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = '') {

        if ($fld != NULL) {
            $this->db->select($fld);
        }
        $this->db->limit(1);

        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
        if ($where != '') {
            $this->db->where($where);
        }

        $q = $this->db->get($table);
        //$num = $q->num_rows();
        return $q->row();
    }
    
    //get single record using join
    function GetSingleJoinRecord($table, $field_first, $tablejointo, $field_second,$field_val='',$where="") {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","inner");
        if(!empty($where)){
            $this->db->where($where);
        }

        $q = $this->db->get();
        return $q->row();  //return only single record
    }

    /* <!--Join tables get single record with using where condition--> */
    
    function GetJoinRecord($table, $field_first, $tablejointo, $field_second,$field_val='',$where="",$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","inner");
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    /* ---GET MULTIPLE RECORD--- */
    function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    /* ---GET MULTIPLE RECORD--- */
    function getAll($table, $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }
        $this->db->from($table);

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }


    /* <!--GET ALL COUNT FROM SINGLE TABLE--> */
    function getcount($table, $where="") {
        if(!empty($where)){
           $this->db->where($where);
        }
        $q = $this->db->count_all_results($table);
        return $q;
    }

    function getTotalsum($table, $where, $data) {
        $this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->row();
    }

    function GetSingleJoin($table, $field_first, $tablejointo, $field_second, $where = '', $field_val,$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        if(!empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }
    
    function GetJoinRecordNew($table, $field_first, $tablejointo, $field_second, $field, $value, $field_val,$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        $this->db->where("$table.$field", "$value");
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    function GetJoinRecordThree($table, $field_first, $tablejointo, $field_second,$tablejointhree,$field_three,$table_four,$field_four,$field_val='',$where="" ,$group_by="",$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first",'inner');
        $this->db->join("$tablejointhree", "$tablejointhree.$field_three = $table_four.$field_four",'inner');
        if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    function getAllwhereIn($table,$where = '',$column ='',$wherein = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($wherein != '') {
            $this->db->where_in($column,$wherein);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    public function custom_query($myquery)
    {
        $query = $this->db->query($myquery);
        return $query->result_array();
    }


    

    //check if any value exists in and return its ID table
    public function is_id_exist($table,$key,$value){
        
        $this->db->select("id");
        $this->db->from($table);
        $this->db->where($key,$value);
        $ret = $this->db->get()->row();
        if(!empty($ret)){
            return $ret->id;
        }
        else
            return FALSE;
    }
    
    //get single value based on key
    public function get_field_value($table, $where, $key){
        
        $this->db->select($key);
        $this->db->from($table);
        $this->db->where($where);
        $ret = $this->db->get()->row();
        if(!empty($ret)){
            return $ret->$key;
        }
        else
            return FALSE;
    }
    
    //get total records of any table
    function get_total_count($table, $where=''){
        $this->db->from($table);
        if(!empty($where))
            $this->db->where($where);
        
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }
    
    //delete attachment file from folder and table 
    function delete_attachment($ref_id, $ref_table, $att_name=''){
        $del_where = array('reference_id'=>$ref_id, 'reference_table'=>$ref_table); $file_folder = '';
        switch ($ref_table){
            case USERS:
            $file_folder = USER_AVATAR_PATH;
            break;
            case CATEGORIES:
            $file_folder = CATEGORY_IMAGE_PATH;
            break;
            case ALBUMS:
            $file_folder = ALBUM_IMAGE_PATH;
            break;
        }
        
        if(empty($file_folder))
            return;
        
        $att_data = $this->getAllwhere(ATTACHMENTS, $del_where);  //get all attachments of reference
        if(!empty($att_data['result'])){
            foreach($att_data['result'] as $row){
                delete_file($file_folder.$row->attachment_name, FCPATH);  //delete attachment from server
            }
        }
        $this->deleteData(ATTACHMENTS,$del_where);  //delete attachment entries from table
    }
    
    //get user category details
    function get_user_category_details($user_id){
         
        $cat_where = array('map.user_id'=>$user_id);
        $sql = $this->db->select('cat.id as catId, cat.name as categoryName')->from(USR_CAT_MAPPING .' as map')->join(CATEGORIES. ' as cat', "map.category_id = cat.id")->where($cat_where);
        $q = $this->db->get();
        return $q->row();
    }
    
    //get all category data
    function get_category_data($select, $record, $offset=0){
        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $default_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $img_field = "IF(image_size = 'large', concat('".$cat_img_path."',att.attachment_name) , '".$default_img."') as cat_image"; //for image field
        $select = $select.', '.$img_field;
        $res = $this->db->select($select)->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id", "left")->where(array('att.reference_table'=>CATEGORIES, 'att.image_size'=>'large'))->limit($record, $offset)->order_by('cat_order')->get(CATEGORIES.' as cat');
        return $res->result_array();
    }
    
    //check if given data exists in table
    function is_data_exists($table, $where){
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        if($rowcount==0){
            return false;
        }
        else {
            return true;
        }
    }
    
    //get user details by ID
    function user_details($user_id, $check_status=true){

        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(AVG(r.rating), "") as rating, COUNT(r.id) as total_rating');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to user review details 
        $where = array('u.id'=>$user_id, 'u.status'=>1);
        
        if(!$check_status)
            $where = array('u.id'=>$user_id);
        
        $this->db->group_by('u.id');
        $this->db->where($where);
        $result = $this->db->get();
        $u_detail = $result->row();

        if(!empty($u_detail)){

            //for vendor return category
            if($u_detail->userType == 'vendor'){
                $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
                $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;

                $cat_where = array('map.user_id'=>$u_detail->id, 'att.reference_table'=>CATEGORIES, 'att.image_size'=>'large');

                $sql = $this->db->select('cat.id as catId, cat.name as category_name, att.attachment_name')->from(USR_CAT_MAPPING .' as map')->join(CATEGORIES. ' as cat', "map.category_id = cat.id","left")->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id","left")->where($cat_where);
                $result2 = $this->db->get();
                $cat_result = $result2->row();
                if(!empty($cat_result)){
                    $u_detail->category_id = $cat_result->catId;
                    $u_detail->category_name = $cat_result->category_name;
                    $cat_image = $cat_result->attachment_name;
                    if(!empty($cat_image)){
                        $u_detail->cat_image = $cat_img_path.$cat_image;
                    }
                    else{
                        $u_detail->cat_image = $default_cat_img;
                    }
                    
                    /* Not required as of now- Kept for future use
                    //get all vendor albums
                    $alb_img_path = base_url('/uploads/user_album/');
                    $img_field = "concat('".$alb_img_path."',att.attachment_name) as album_image"; //category image
                    $sql_alb = $this->db->select('alb.*')->from(ALBUMS .' as alb')->join(ATTACHMENTS. ' as att', "alb.id = att.reference_id","left")->where(array('alb.user_id'=>$user_id, 'att.reference_table'=>ALBUMS, 'att.image_size'=>'large'));
                    $result3 = $this->db->get();
                    $u_detail->album_details = $result3->result();
                    
                    //get all vendor reviews
                    $sql_rev = $this->db->select('r.*')->from(REVIEWS .' as r')->where(array('r.review_for'=>$user_id));
                    $result4 = $this->db->get();
                    $u_detail->review_details = $result4->result();
                     */
                }
            }
            
            //user profile image
            $u_detail->thumbImage = make_user_img_url($u_detail->image); //make url from image name
        } 	
        return $u_detail;	
    } 
    
    //get user list by type
    function user_list($user_type, $category_id, $limit, $offset=0, $check_status=true){
        
        $where = array();
        if($check_status)
            $where['u.status']= 1;       
        else
            $where['u.status']= 0;
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(AVG(r.rating), "") as rating, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(cat.name, "") as category_name');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to get user review details 
        
        switch ($user_type) {
            case "user":
                $where['u.userType']= $user_type; 
                $this->db->where($where);
            break;
            case "vendor":
                $where['u.userType']= $user_type;
                if(!empty($category_id))
                    $where['map.category_id']= $category_id;
                
                $this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
                $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
                $this->db->where($where); 
            break;
            default:
                //$this->db->where(array('u.user_type'=>$user_type)); 
            break;    
        } 
        $this->db->group_by('u.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('u.id', 'DESC');
        $result = $this->db->get();
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){
                $v->user_image = make_user_img_url($v->image);
            }
        }
        return $res;	
    } 

    //get user list by type
    function user_list_count($user_type, $category_id, $limit, $offset=0, $check_status=true){
        
        $where = array();
        if($check_status)
            $where['u.status']= 1;       
        else
            $where['u.status']= 0;
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(AVG(r.rating), "") as rating, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(cat.name, "") as category_name');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to get user review details 
        
        switch ($user_type) {
            case "user":
                $where['u.userType']= $user_type; 
                $this->db->where($where);
            break;
            case "vendor":
                $where['u.userType']= $user_type;
                if(!empty($category_id))
                    $where['map.category_id']= $category_id;
                
                $this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
                $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
                $this->db->where($where); 
            break;
            default:
                //$this->db->where(array('u.user_type'=>$user_type)); 
            break;    
        } 
        $this->db->group_by('u.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('u.id', 'DESC');
        $result = $this->db->get();
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){
                $v->user_image = make_user_img_url($v->image);
            }
        }
        return $res;    
    } 
    

    //filter user list by name
    function search_user_list_count($user_type, $category_id, $search_str,$check_status=true){
        
        $where = array();
        if($check_status)
            $where['u.status']= 1;       
        else
            $where['u.status']= 0;
        
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(AVG(r.rating), "") as rating, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(cat.name, "") as category_name');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to get user review details 
        
        switch ($user_type) {
            case "user":
                $where['u.userType']= $user_type; 
                $this->db->where($where);
            break;
            case "vendor":
                $where['u.userType']= $user_type;
                if(!empty($category_id))
                    $where['map.category_id']= $category_id;
                
                $this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
                $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
                $this->db->where($where); 
            break;
            default:
                //$this->db->where(array('u.user_type'=>$user_type)); 
            break;    
        }
        $this->db->like('u.fullName', $search_str);
        $this->db->group_by('u.id');
        $this->db->order_by('u.id', 'DESC');
        $result = $this->db->get();
        $res = $result->num_rows(); 
        return $res;
           
    } 
    
   //filter user list by name
    function search_user_list($user_type, $category_id, $search_str,  $limit, $offset=3, $check_status=true){
        
        $where = array();
        if($check_status)
            $where['u.status']= 1;       
        else
            $where['u.status']= 0;
        
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(AVG(r.rating), "") as rating, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(cat.name, "") as category_name');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to get user review details 
        
        switch ($user_type) {
            case "user":
                $where['u.userType']= $user_type; 
                $this->db->where($where);
            break;
            case "vendor":
                $where['u.userType']= $user_type;
                if(!empty($category_id))
                    $where['map.category_id']= $category_id;
                
                $this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
                $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
               // $this->db->join(ATTACHMENTS. ' as att ',"u.id = att.reference_id AND image_size = 'medium' AND reference_table ='users'","left");

                $this->db->where($where); 
            break;
            default:
                //$this->db->where(array('u.user_type'=>$user_type)); 
            break;    
        }
        $this->db->like('u.fullName', $search_str);
        $this->db->group_by('u.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('u.id', 'DESC');
        $result = $this->db->get(); 
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){ 
                $v->user_image = make_user_img_url($v->image);
                //$v->attachment_name = make_user_img_url($v->attachment_name);
            }
        }
        return $res;    
    } 
    
    //get user reviews by user ID
    function get_user_reviews($user_id, $limit, $offset=0, $check_status=true){
        
        $where['r.review_for'] =  $user_id;
        $where['u.status'] =  1;
        
        if(!$check_status)
            $where['u.status'] = 0;
        
        $this->db->select('r.*, u.fullName, u.image');
        $this->db->from(REVIEWS .' as r'); //reviews
        $this->db->join(USERS. ' as u', "r.review_by = u.id"); //to get user meta details
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('r.id', 'DESC');
        $result = $this->db->get();
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){
                $v->user_image = make_user_img_url($v->image);
                $v->time_elapsed = time_elapsed_string($v->created_on); //add time_elapsed key to show time elapsed in user friendly string
            }
        }
        return $res;
    }
    

    //get user reviews count by user ID
    function get_user_reviews_count($user_id, $check_status=true){
        
        $where['r.review_for'] =  $user_id;
        $where['u.status'] =  1;
        
        if(!$check_status)
            $where['u.status'] = 0;
        
        $this->db->select('r.*, u.fullName, u.image');
        $this->db->from(REVIEWS .' as r'); //reviews
        $this->db->join(USERS. ' as u', "r.review_by = u.id"); //to get user meta details
        $this->db->where($where);
          $this->db->order_by('r.id', 'DESC');
        $result = $this->db->get();
        $res = $result->num_rows(); 
        return $res;
    }
    
    
   //related vendor according to cat_id
    function related_vendor($user_type,$vendor_id,$category_id,$check_status=true){
        
        $where = array();
        $where = array('u.id !='=>$vendor_id);

        if($check_status)
            $where['u.status']= 1;       
        else
            $where['u.status']= 0;
        
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(AVG(r.rating), "") as rating, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(cat.name, "") as category_name');
        $this->db->from(USERS .' as u'); //users
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left"); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left"); //to get user review details 
        
        switch ($user_type) {
            case "user":
                $where['u.userType']= $user_type; 
                $this->db->where($where);
            break;
            case "vendor":
                $where['u.userType']= $user_type;
                if(!empty($category_id))
                    $where['map.category_id']= $category_id;
                
                $this->db->join(USR_CAT_MAPPING. ' as map', "u.id = map.user_id","left"); //to get user category
                $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id", "left"); //to get category details
                $this->db->where($where); 
                //$this->db->having('rating = 5 OR rating = 4');
            break;
            default:
                //$this->db->where(array('u.user_type'=>$user_type)); 
            break;    
        }

        $this->db->group_by('u.id');
        $this->db->order_by('u.id', 'DESC');
        //$this->db->limit(2, 0);
        $result = $this->db->get(); 
        $res = $result->result();
        if(!empty($res)){
            foreach($res as $v){
                $v->user_image = make_user_img_url($v->image);
            }
        }
        return $res;    
    } 



    //get all details related to post
    function get_user_post_list($user_id, $limit, $offset=0){
        if(empty($limit))
           $limit = 1;

        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $user_img_path =  base_url().USER_AVATAR_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $default_user_img = base_url().USER_DEFAULT_AVATAR;
        $img_arr = array('thumbnail', 'medium', 'large');


        $img_field3 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image

        //check if user has image or image url(in case of social login) and set user_image accordingly
        //$prof_img_field = "IF(usr.image != '', IF(usr.image REGEXP '^(https?:\/\/|www\.)[\.A-Za-z0-9\-]+\.[a-zA-Z]{2,4}', concat('".$user_img_path."',usr.image), usr.image) , '".$default_user_img."') as user_image"; //user profile image

        $this->db->select('p.*, eve.id as eventId, eve.event_name, usr.fullName, usr.email, usr.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field3);
        $this->db->from(POSTS .' as p');
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id","left"); //to get event type details
        $this->db->join(DOING_EVENT. ' as doi', "p.id = doi.post_id","left"); //to get doing event count
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id","left"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id","left"); //to category details
        $this->db->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id","left"); //to get post attachment
        $this->db->join(USERS. ' as usr', "p.post_author = usr.id","left"); //to get post author details 

        if(!empty($where))
            $this->db->where($where);

        $this->db->where(array('att.reference_table'=>CATEGORIES, 'att.image_size'=>'large','p.post_author'=>$user_id));
        $this->db->group_by('p.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('p.updated_on', 'DESC');
        $result = $this->db->get();
        $res = $result->result_array();
        $filtered_res = array();
        //pr($res);
        if(!empty($res)){
            foreach($res as  $k=>$v){

        //check if post is already interested by user(vendor) and skip that post from list. Those posts will be shown under 'my events' 
                $is_exists = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$v['id'], 'user_id'=>$user_id));
                if(!$is_exists){
                    $v['user_image'] = make_user_img_url($v['user_image']);  //make image url from image name and store in same key
                    $v['time_elapsed'] = time_elapsed_string($v['updated_on']); //add time_elapsed key to show time elapsed in user friendly string
                    $filtered_res[] = $v;
                }
            }
        }
        return $filtered_res;
    }
    
    function get_my_post($user_id, $limit, $offset, $check_status=true){
        
        $where['u.status'] =  1;
        if(!$check_status)
            $where['u.status'] = 0;
        
        $user_type  = $this->common_model->get_field_value(USERS, array('id'=>$user_id), 'userType'); //get user type by user ID
        
        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $img_field1 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image
        $where['att.reference_table'] = CATEGORIES;
        $where['att.image_size'] = 'large';
        $where['p.status'] = 1;
        $this->db->select('p.*, eve.id as eventId, eve.event_name, u.fullName, u.email, u.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count,'.$img_field1);
        $this->db->from(POSTS .' as p');
        $this->db->join(DOING_EVENT. ' as doi', "p.id = doi.post_id", 'left'); //to get doing event count - for user join will be LEFT and for vendor it will be INNER
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id"); //to get event type details
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id"); //to category details
        $this->db->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id"); //to get post attachment
        $this->db->join(USERS. ' as u', "p.post_author = u.id"); //to get post author details 
        
        switch ($user_type) {
            case "user":
                $where['p.post_author'] = $user_id; 
            break;
            case "vendor":
                $where['doi.user_id'] = $user_id;
            break;
        }
        
            $this->db->where($where);
            $this->db->group_by('p.id');
            $this->db->limit($limit, $offset);
            $this->db->order_by('p.updated_on', 'DESC');
            $result = $this->db->get(); 
            $res = $result->result_array();
            
        if(!empty($res)){
            foreach($res as  $k=>$v){
                $res[$k]['user_image'] = make_user_img_url($v['user_image']);  //make image url from image name and store in same key
                $res[$k]['time_elapsed'] = time_elapsed_string($v['updated_on']); //add time_elapsed key to show time elapsed in user friendly string
            }
        }
        
        return $res;
    }
    

    //for getting post count
    function get_my_post_count($user_id, $limit, $offset, $check_status=true){
        
        $where['u.status'] =  1;
        if(!$check_status)
            $where['u.status'] = 0;
        
        $user_type  = $this->common_model->get_field_value(USERS, array('id'=>$user_id), 'userType'); //get user type by user ID
        
        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $img_field1 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image
        $where['att.reference_table'] = CATEGORIES;
        $where['att.image_size'] = 'large';
        $where['p.status'] = 1;
        $this->db->select('p.*, eve.id as eventId, eve.event_name, u.fullName, u.email, u.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field1);
        $this->db->from(POSTS .' as p');
        $this->db->join(DOING_EVENT. ' as doi', "p.id = doi.post_id", 'left'); //to get doing event count
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id"); //to get event type details
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id"); //to category details
        $this->db->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id"); //to get post attachment
        $this->db->join(USERS. ' as u', "p.post_author = u.id"); //to get post author details 
        switch ($user_type) {
            case "user":
                $where['p.post_author'] = $user_id; 
            break;
            case "vendor":
                $where['doi.user_id'] = $user_id;
            break;
        }
        
            $this->db->where($where);
            $this->db->group_by('p.id');
            $this->db->limit($limit, $offset);
            $this->db->order_by('p.updated_on', 'DESC');
            $result = $this->db->get();
            $res = $result->num_rows(); 
            return $res;
    }

   

    //get single post details for admin
    function get_post_detail($where){
        
        $limit = 1; $offset =0;

        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $user_img_path =  base_url().USER_AVATAR_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $default_user_img = base_url().USER_DEFAULT_AVATAR;
        $img_arr = array('thumbnail', 'medium', 'large');

        $img_field3 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image

        //check if user has image or image url(in case of social login) and set user_image accordingly
        //$prof_img_field = "IF(usr.image != '', IF(usr.image REGEXP '^(https?:\/\/|www\.)[\.A-Za-z0-9\-]+\.[a-zA-Z]{2,4}', concat('".$user_img_path."',usr.image), usr.image) , '".$default_user_img."') as user_image"; //user profile image

        $this->db->select('p.*, eve.id as eventId, eve.event_name, usr.fullName, usr.email, usr.userType, usr.contactNumber as user_contact_number, usr.address as user_address, usr.deviceToken, usr.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field3);
        $this->db->from(POSTS .' as p');
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id","left"); //to get event type details
        $this->db->join(DOING_EVENT. ' as doi', "p.id = doi.post_id","left"); //to get doing event count
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id","left"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id","left"); //to category details
        $this->db->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id","left"); //to get post attachment
        $this->db->join(USERS. ' as usr', "p.post_author = usr.id","left"); //to get post author details 

        if(!empty($where))
            $this->db->where($where);

        $this->db->where(array('att.reference_table'=>CATEGORIES, 'att.image_size'=>'large'));
        $this->db->limit($limit, $offset);
        $result = $this->db->get();
        $res = $result->row();
        if(!empty($res)){
            $res->user_image = make_user_img_url($res->user_image); //make image url from image name
            $res->time_elapsed = time_elapsed_string($res->updated_on); //add time_elapsed key to show time elapsed in user friendly string
        }
        return $res;
    }
    
    
    
    //get user album list by user ID
    function get_user_album_list($user_id, $limit, $offset=0){
        
        $alb_img_path = base_url().ALBUM_IMAGE_PATH;
        $img_field = "concat('".$alb_img_path."',attachment_name) as album_image"; //category image
        $where['a.user_id'] =  $user_id;
        
        $this->db->select('a.*');
        $this->db->from(ALBUMS .' as a'); //albums
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.id', 'DESC');
        $result = $this->db->get(); 
        $res = $result->result();
        
        if(!empty($res)){
            $fields = 'id, '.$img_field;
            foreach($res as $v){
                $alb_where = array('reference_id'=> $v->id, 'reference_table'=>ALBUMS, 'image_size'=>'large');
                $album = $this->getAllwhere(ATTACHMENTS, $alb_where, 'id', 'ASC', $fields, 5); 
                $v->album_attachments = $album['result'];
                $v->time_elapsed = time_elapsed_string($v->updated_on); //add time_elapsed key to show time elapsed in user friendly string
            }
        }
        return $res;
    }
    
    //get user album detail by album ID
    function get_user_album_by_id($album_id){
        
        $alb_img_path = base_url().ALBUM_IMAGE_PATH;
        $img_field = "concat('".$alb_img_path."',attachment_name) as album_image"; //category image
        $where['a.id'] =  $album_id;
        
        $this->db->select('a.*');
        $this->db->from(ALBUMS .' as a'); //albums
        $this->db->where($where);
        $result = $this->db->get();
        $res = $result->row();
        if(!empty($res)){
            $fields = 'id, '.$img_field;
            $alb_where = array('reference_id'=> $album_id, 'reference_table'=>ALBUMS, 'image_size'=>'large');
            $album = $this->getAllwhere(ATTACHMENTS, $alb_where, 'id', 'ASC', $fields, 5);
            //pr($album);
            $res->album_attachments = $album['result'];
            $res->time_elapsed = time_elapsed_string($res->updated_on); //add time_elapsed key to show time elapsed in user friendly string    
        }
        return $res;
    }
    
    //get list of users who are doing event(post) by post ID
    function get_doing_user_list($post_id, $limit, $offset=0, $check_status=true){
        
        $where['u.status'] =  1;
        if(!$check_status)
            $where['u.status'] = 0;
        
        $this->db->select('u.*, COALESCE(um.description, "") as description, COALESCE(um.price, "") as price, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol, COALESCE(AVG(r.rating), "") as rating, COALESCE(cat.name, "") as category_name');
        
        $this->db->from(DOING_EVENT .' as doi'); //to get doing event
        $this->db->join(USERS. ' as u', "doi.user_id = u.id"); //to user details
        $this->db->join(USER_META. ' as um', "u.id = um.user_id","left" ); //to get user meta details
        $this->db->join(REVIEWS. ' as r', "u.id = r.review_for","left" ); //to get user review details
        $this->db->join(USR_CAT_MAPPING. ' as usrcat', "u.id = usrcat.user_id","left" ); //to get user category
        $this->db->join(CATEGORIES. ' as cat', "usrcat.category_id = cat.id","left" ); //to get category details
        $where['doi.post_id'] = $post_id;
        $this->db->where($where);
        $this->db->group_by('u.id');
        $this->db->limit($limit, $offset);
        $q = $this->db->get();
        $res = $q->result();
       
        $count = $q->num_rows();
        //pr($count); 
        if(!empty($res)){
            foreach($res as $v){
               $v->user_image = make_user_img_url($v->image); //make image url from image name
            }
        }
        return $res;
    }
}