<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendorpost_model extends CI_Model {




    public function __construct() {
        parent::__construct();  
        $this->notify_log = FCPATH.'notification_log.txt';    //notifcation file path
        $this->load->helper('string');
    }
    /* Firebase notification for Andriod and ios */
    function send_notification($registrationIds, $notificationMsg){     
        $msg = $notificationMsg;
        $fields = array(
            'registration_ids'  => $registrationIds,  //firebase token array
            'data'      => $msg ,  //msg for andriod
            'notification'      => $msg   //msg for ios
        );

        $headers = array(
            'Authorization: key=' . NOTIFICATION_KEY, //firebase API key
            'Content-Type: application/json'
        );
        
        //curl request
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );  //firebase end url
        //curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        log_event($result, $this->notify_log);  //create log of notifcation
        return $result;
    }
    
    //store notifcation in DB
    function save_notification($table, $data){
        return $this->common_model->insertData($table, $data);
    }

    //get all details related to post
    function get_post_list($where, $user_id, $limit, $offset=0){
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

        $this->db->select('doi.*,p.*, eve.id as eventId, eve.event_name, usr.fullName, usr.email, usr.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field3);
        $this->db->from(POSTS .' as p');
        $this->db->join(EVENT_TYPE. ' as eve', "p.event_type = eve.id","left"); //to get event type details
        $this->db->join(DOING_EVENT. ' as doi', "p.id = doi.post_id","left"); //to get doing event count
        $this->db->join(POST_CAT_MAPPING. ' as map', "p.id = map.post_id","left"); //to get post category
        $this->db->join(CATEGORIES. ' as cat', "map.category_id = cat.id","left"); //to category details
        $this->db->join(ATTACHMENTS. ' as att', "cat.id = att.reference_id","left"); //to get post attachment
        $this->db->join(USERS. ' as usr', "p.post_author = usr.id","left"); //to get post author details 
       

        if(!empty($where))
            $this->db->where($where);

        $this->db->where(array('att.reference_table'=>CATEGORIES, 'att.image_size'=>'large', 'p.status'=>1, 'usr.status'=>1));
        $this->db->group_by('p.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('p.updated_on', 'DESC');
        $result = $this->db->get();
        $res = $result->result_array();
        

//return $res;


        $filtered_res = array();
        if(!empty($res)){
            foreach($res as  $k=>$v){

        //check if post is already interested by user(vendor) and skip that post from list. Those posts will be shown under 'my events' 
                $is_exists = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$v['id'], 'user_id'=>$user_id));
                if(!$is_exists){

                    $image = make_user_img_url($v['user_image']); //make url from image name
                    $v['user_image'] = $image;  //overide user_image key based on above checks
                    $v['time_elapsed'] = time_elapsed_string($v['updated_on']); //add time_elapsed key to show time elapsed in user friendly string
                    $filtered_res[] = $v;
                }
            }
        }
        return $filtered_res;
    }

    function get_post_detail($where){  
       
        $limit = 1; $offset =0;
        $current_user_id = $this->session->userdata['id']; //user id

        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $user_img_path =  base_url().USER_AVATAR_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $default_user_img = base_url().USER_DEFAULT_AVATAR;
        $img_arr = array('thumbnail', 'medium', 'large');

        $img_field3 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image

        $this->db->select('p.*, eve.id as eventId, eve.event_name, usr.fullName, usr.address as usrAdd, usr.email, usr.deviceToken, usr.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field3);
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
             $res->is_doing = 0;
            //check if current user is doing this event
            $is_exists = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$res->id, 'user_id'=> $current_user_id));
            if($is_exists){
                $res->is_doing = 1;
            }
        }
        return $res;
    }

    function add_image_data($att_data){
        $this->db->insert(ATTACHMENTS, $att_data);
        $last_id = $this->db->insert_id();
        if($last_id){
            return $last_id;
        }
        else{
            return FALSE;
        }
    }
    
    function image_sizes(){
        $img_sizes = array();
        $img_sizes['thumbnail'] = array('width'=>150,'height'=>150);
        $img_sizes['medium'] = array('width'=>300,'height'=>300);
        return $img_sizes;
    }
    function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)) {

            mkdir(FCPATH . $defaultFolder, $mode);
        }
        if(!empty($folder)) {

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }//End Function
    function makedirsBk($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='../uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)) {

            mkdir(FCPATH . $defaultFolder, $mode);
        }
        if(!empty($folder)) {

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }//End Function
    function updateMedia($image,$folder,$height=250,$width=250,$path=FALSE){
        if($path){
             $this->makedirsBk($folder);
        }else{
             $this->makedirs($folder);
        }
        $realpath = $path ?'../uploads/':'uploads/';

        $allowed_types = "jpg|png|jpeg|JPG|PNG|JPEG"; 
        
                $img_name = random_string('alnum', 16);  //generate random string for image name
        $config = array(
            'upload_path'       => $realpath.$folder,
            'allowed_types'     => $allowed_types,
            'max_size'              => "24800000",   // Can be set to particular file size , for now it is 5mb
                        //'max_height'            => "4000",
                        //'max_width'             => "4000",
                        //'min_width'             => "200",
                       // 'min_height'            => "200",
            'file_name'     => $img_name,
            'overwrite'     => false,
            'remove_spaces'     => TRUE,
            'quality'       => '100%',
        );
        
        $this->load->library('upload');
        $this->upload->initialize($config);

        if(!$this->upload->do_upload($image)){
                    ini_set('memory_limit', '-1');
                    $error = array('error' => $this->upload->display_errors());
                    return $error;

        } else {

                    $image_data = $this->upload->data();

                    //store default image size attachement data
                    $att_data = array('attachment_name'=>$image_data['file_name'], 'attachment_type'=>'image','image_size'=>'default', 'created_on'=>datetime());
                    $att_id = $this->add_image_data($att_data);
                    if($att_id)
                        $attachments[] =  $att_id;

                    $this->load->library('image_lib');
                    $folder_thumb = $folder.'/';

                    $img_sizes_arr = $this->image_sizes();  //predefined sizes in model
                        $thumb_img = '';
                        foreach($img_sizes_arr as $k=>$v){
                            
                            $resize_str = random_string('alnum', 5);
                            $new_img_name = $v['width']. 'x'. $v['height'].'_'. $resize_str.$image_data['file_name'];
                            $real_path = realpath(FCPATH .$realpath .$folder_thumb);
                            $resize['image_library']    = 'gd2';
                            $resize['source_image']     = $image_data['full_path'];
                            $resize['new_image']        = $real_path.'/'.$new_img_name;
                            $resize['maintain_ratio']           = FALSE;
                            $resize['width']            = $v['width'];
                            $resize['height']           = $v['height'];
                            $resize['quality']          = '100%';
                            $this->image_lib->initialize($resize);
                            if($this->image_lib->resize()){
                                $att_data = array('attachment_name'=>$new_img_name, 'attachment_type'=>'image','image_size'=>$k, 'created_on'=>datetime());
                                $att_id = $this->add_image_data($att_data);
                                if($att_id)
                                    $attachments[] =  $att_id;
                                
                                if($k=='thumbnail')
                                    $thumb_img = $new_img_name;
                            }
                        }
                        
                        //custom size 
                        $new_img_name = $width. 'x'. $height.'_'.random_string('alnum', 5).$image_data['file_name'];
                        $real_path = realpath(FCPATH .$realpath .$folder_thumb);
                        $resize1['source_image']    = $image_data['full_path'];
                        $resize1['new_image']       = $real_path.'/'.$new_img_name;
                        $resize1['maintain_ratio']  = FALSE;
                        $resize1['width']               = $width;
                        $resize1['height']      = $height;
                        $resize1['quality']         = '100%';
                        $this->image_lib->initialize($resize1);
                        if($this->image_lib->resize()){
                            $att_data = array('attachment_name'=>$new_img_name, 'attachment_type'=>'image','image_size'=>'large', 'created_on'=>datetime());
                            $att_id = $this->add_image_data($att_data);
                            if($att_id)
                                $attachments[] =  $att_id;
                        }
            
                        $this->image_lib->clear();
                        if(empty($thumb_img))
                            $thumb_img = $image_data['file_name'];
                        
            return array('image_name'=>$thumb_img, 'attachments'=>$attachments);
        }

    } // End Function
}