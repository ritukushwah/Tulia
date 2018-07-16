<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	//get single post details
    function get_post_detail($where){
        
        $limit = 1; $offset =0;
        $user_id = $this->session->userdata['id']; 
        $cat_img_path = base_url().CATEGORY_IMAGE_PATH;
        $user_img_path =  base_url().USER_AVATAR_PATH;
        $default_cat_img = base_url().CATEGORY_DEFAULT_IMAGE;
        $default_user_img = base_url().USER_DEFAULT_AVATAR;
        $img_arr = array('thumbnail', 'medium', 'large');

        $img_field3 = "IF(image_size = 'large',concat('".$cat_img_path."',att.attachment_name) , '".$default_cat_img."') as cat_image"; //category image

        $this->db->select('p.*, eve.id as eventId, eve.event_name, usr.fullName, usr.email, usr.deviceToken, usr.image as user_image, cat.id as catId, cat.name as category_name, COUNT(doi.id) as interested_count, '.$img_field3);
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
            $is_exists = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$res->id, 'user_id'=>$user_id));
            if($is_exists){
                $res->is_doing = 1;
            }
        }
        return $res;
    }

     //send push notifications
    public function send_push_notification($token_arr, $title, $body, $reference_id, $type){
        if(empty($token_arr)){
            return false;
        }
        //prepare notification message array
        $notif_msg = array('title'=>$title, 'body'=> $body, 'reference_id'=>$reference_id, 'type'=> $type, 'click_action'=>'ChatActivity', 'sound'=>'default');
        $this->notification_model->send_notification($token_arr, $notif_msg);  //send andriod and ios push notification
        return $notif_msg;  //return message array
    }




}