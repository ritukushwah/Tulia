<?php
class Service_model extends CI_Model {
	
	/**
	* Generate token for users
	*/
	function generate_token()
	{
		$this->load->helper('security');
		$res = do_hash(time().mt_rand());
		$new_key = substr($res,0,config_item('rest_key_length'));
		return $new_key;

	}
	/**
	* Update users deviceid and auth token while login
	*/
	function checkDeviceToken()
	{
		$sql = $this->db->select('id')->where('deviceToken', $deviceToken)->get('users');
		if($sql->num_rows())
		{
			$id = array();
			foreach($sql->result() as $result)
			{
				$id[] = $result->id;
			}
			$this->db->where_in('id', $id);
			$this->db->update('users',array('deviceToken'=>''));

			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		return true;
	} //Function for check Device Token
	
	/*
	Function for check provided token is resultid or not
	*/
	function isValidToken($authToken)
	{
		$this->db->select('*');
		$this->db->where('authToken',$authToken);
		if($sql = $this->db->get('users'))
		{
			if($sql->num_rows() > 0)
			{
				return $sql->row();
			}
		}
		return false;
	}

	function registration($data)
	{	
		if(!empty($data['socialId']) && !empty($data['socialType']))
		{  // social registration or social login
			$query = $this->db->select('*')->where(array('socialId'=>$data['socialId'],'socialType'=>$data['socialType']))->get('users');
			if($query->num_rows()==1)
			{ 
				$result = $query->row();
				$status_check = $result->status ;
				if ( $status_check == 1){
                                    //user is active
                                    
                                    //check user type
                                    $user_type = $result->userType;
                                    if($user_type != $data['userType']){
                                        return array('regType'=>'IU'); // Invalid user
                                    }
                                    
                                    $id = $result->id;
                                    //updating users deviceId and authToken
                                    $updateToken = $this->updateDeviceIdToken($id,$data['deviceToken'],$data['authToken'],$data['deviceType']);
                                    return array('regType'=>'SL','returnData'=>$this->userInfo(array('id' => $id)));
                                    //login successfully
				}
				else
				{
                                    return array('regType'=>'NA'); //Inactive
				}
			}
			else
			{	
				$this->db->insert('users',$data);
				return array('regType'=>'SR','returnData'=>$this->userInfo(array('id' => $this->db->insert_id())));//social registration	
			}
		}
		else
		{
			$res = $this->db->select('email')->where(array('email'=>$data['email']))->get('users');
			
			if($res->num_rows() == 0)
			{
                            $this->db->insert('users',$data);
                            $last_id = $this->db->insert_id();
                            return array('regType'=>'NR','returnData'=>$this->userInfo(array('id' => $last_id)));
                            // Normal registration
			}
			else
			{	
                            return array('regType'=>'AE'); //already exist
			}
			return FALSE;
		}
		
	} //End Function users Register

	function updateDeviceIdToken($id,$deviceToken,$authToken,$deviceType='')
	{
		$req = $this->db->select('id')->where('id',$id)->get('users');
		if($req->num_rows())
		{
			$this->db->update('users',array('deviceToken'=>''),array('id !='=>$id,'deviceToken'=>$deviceToken));
			$this->db->update('users',array('deviceToken'=>$deviceToken,'authToken'=>$authToken,'deviceType'=>$deviceType),array('id'=>$id));
			return TRUE;
		}
		return FALSE;
	}//End Function Update Device Token 
        
        //get user info
	function userInfo($where){
           
            $req = $this->db->select('u.id,u.userName,u.fullName,u.email,u.userType,u.countryCode,u.contactNumber,u.address,u.authToken,u.status,u.createdOn,u.image, COALESCE(um.description, "") as description, COALESCE(um.currency_code, "") as currency_code, COALESCE(um.currency_symbol, "") as currency_symbol,  COALESCE(um.price, "") as price')->join(USER_META. ' as um', "u.id = um.user_id","left")->where($where)->get(USERS.' as u');
            $returnData = array();
            if($req->num_rows())
            {
                $result = $req->row();
                
                //for vendor return category
                if($result->userType == 'vendor'){
                    $result->category = $result->category_name = '';
                    //$cat_where = array('user_id'=>$result->id);
                    $cat_result = $this->common_model->get_user_category_details($result->id);
                    if(!empty($cat_result)){
                        $result->category_name = $cat_result->categoryName;
                        $result->category = $cat_result->catId;
                    }
                }
                
                if (!empty($result->image)) {
                    $image = $result->image;
                    //check if image consists url- happens in social login case
                    if (filter_var($result->image, FILTER_VALIDATE_URL)) { 
                        $result->thumbImage = $image;
                    }
                    else{
                    	$result->image = base_url().USER_AVATAR_PATH.$image;
                        $result->thumbImage = base_url().USER_AVATAR_PATH.$image;
                    }
                }
                else{
                    $result->thumbImage = base_url().USER_DEFAULT_AVATAR; //return default image if image is empty
                }

            } 	

		return $result;	
	} //End Function usersInfo

	function login($data,$authToken){
            $this->load->library('encrypt');
            $res = $this->db->select('*')->where(array('email'=>$data['email']))->get('users');
            if($res->num_rows()){
                $result = $res->row();
                if($result->status == 1)
                {
                    //check user type
                    $user_type = $result->userType;
                    if($user_type != $data['userType']){
                        return array('returnType'=>'IU'); // Invalid user
                    }

                    //verify password- It is good to use php's password hashing functions so we are using password_verify fn here
                    if(password_verify($data['password'], $result->password)){
                        $updateData = $this->updateDeviceIdToken($result->id,$data['deviceToken'],$authToken,$data['deviceType']);
                        if($updateData){
                            return array('returnType'=>'SL','userInfo'=>$this->userInfo(array('id'=>$result->id)));
                        }
                        else{
                            return FALSE;
                        }
                    }
                    else{
                        return array('returnType'=>'WP'); // Wrong Password
                    }
                }
                return array('returnType'=>'WS','userInfo'=>$this->userInfo(array('id'=>$result->id)));
                // InActive
            }
            else {
                return array('returnType'=>'WE'); // Wrong Email
            }
	}//End users Login
        
        

	function getPostlist()
	{
		$this->db->select('post.id, post.postType, post.title, post.postContent, post.crd, post.upd, users.fullName, users.image');
        $this->db->join('users', 'users.id  = post.userId');
        $sql = $this->db->get('post');
		if ($sql->num_rows() > 0)
        {
        	$data = $sql->result_array();

        	foreach ($data as $k => $v)
        	{
 				$id = $v['id'];
 				$image = $v['image'];
 				$url ="";
 				if(!empty($image)):
 					$url = base_url().'uploads/profile/thumb/'.$image;
 				endif;
        		$data[$k]['comment'] =$this->getCommnet($id);
        		$data[$k]['isLike'] =1;
        		$data[$k]['countLike'] =$this->countLike($id);
        		$data[$k]['countComment'] =$this->countComment($id);
        		$data[$k]['image'] = $url;
        		if($v['postType']=='image'){
        			$data[$k]['postContent'] = base_url().'uploads/'.$v['postContent'];
        			//$data[$k]['postContent'] = base_url().'uploads/post/thumb/'.$v['postContent'];

        		}
        	}
            return $data;
        }
        return false;
	} //End funtion

	function getCommnet($id)
	{ 
		$this->db->select('comment');
		$this->db->where('postId',$id);
		$result = $this->db->get('comment');
		$res = $result->result_array();
		return $res;
	} //End funtion

	function countLike($id)
	{
		$this->db->where('postId',$id);
		$this->db->from("like");
		return $this->db->count_all_results();
	} //End funtion
	
	function countComment($id)
	{
		$this->db->where('postId',$id);
		$this->db->from("comment");
		return $this->db->count_all_results();
	} //End funtion

	function about()
	{
		$this->db->select('*');
        $sql = $this->db->get('about');
		$data = $sql->row();
		$image =  $data->image;
		$data->image = base_url().'uploads/about/'.$image; 

		return $data;
	} //End funtion

	function image($data)
	{
		$this->db->insert('about', $data);
		$this->db->insert_id();
		return array('regType'=>'SL');
	} //End funtion

	function forgotPassword($email)
	{
		$sql = $this->db->select('id,fullName as name,email,password')->where(array('email'=>$email))->get('users');
		if($sql->num_rows())
		{
			$this->load->library('encrypt');
			$result = $sql->row();
			$useremail= $result->email;
			$password="Your Password is :-".$this->encrypt->decode( $result->password) ;
			$data['name'] = $result->name;
			$data['password'] = $password;
			$message  = $this->load->view('emails/forgot_password',$data,TRUE);
			print_r($message); die;
			$subject = " Forgot Password";
			//$forgot = send_email($useremail,$message,$subject); 
			return $this->emailSent($useremail,$message,$subject);
		}
		else
		{
			return false;
		}
	} //End funtion

	function emailSent($useremail,$message,$subject)
	{
		$this->load->library('email');

		$config = array();
		$config['useragent']  = "CodeIgniter";
		$config['mailpath']  = "/usr/sbin/sendmail"; 
		$config['protocol'] = "sendmail";
		$config['smtp_host']= "mindiii.com";
		$config['smtp_port'] = "25";
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$config['newline']  = "\r\n";
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		$this->email->from('noreply@mindiii.com', 'LightGeneration');
		$this->email->to($useremail);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send())
		{  
                    return  array('emailType'=>'ES','email'=>'Your password has been successfully sent to your email address!!' ); //ES emailSend
		}
		else
		{ 
                    return  array('emailType'=>'NS','email'=> 'Email is not Exist ') ; //NS NotSend
		}
	}//End function
        
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

        $this->db->where(array('att.reference_table'=>CATEGORIES, 'att.image_size'=>'large', 'p.status'=>1, 'usr.status'=>1));
        $this->db->group_by('p.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('p.updated_on', 'DESC');
        $result = $this->db->get();
        $res = $result->result_array();
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
    
     //get single post details
    function get_post_detail($where){
        
        $limit = 1; $offset =0;

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
            $is_exists = $this->common_model->is_data_exists(DOING_EVENT, array('post_id'=>$res->id, 'user_id'=>$this->authData->id));
            if($is_exists){
                $res->is_doing = 1;
            }
        }
        return $res;
    }
    
    //replace event placeholder name with event name
    function replace_event_placeholder_name($post_id, $body){
        $e_name = '';
        $event_res = $this->common_model->GetSingleJoinRecord(POSTS, 'event_type', EVENT_TYPE, 'id', 'event_name', array(POSTS.'.id'=>$post_id));
        if(!empty($event_res)){
            $e_name = $event_res->event_name;
        }
        $body = str_replace("[ENAME]", $e_name, $body);
        return $body;
    }
    
    //replace user placeholder name with user full name
    function replace_user_placeholder_name($user_id, $body){
        $u_name = '';
        $full_name = $this->common_model->get_field_value(USERS, array('id'=>$user_id), 'fullName');
        if($full_name){
            $u_name = $full_name;
        }
        $body = str_replace("[UNAME]", $u_name, $body);
        return $body;
    }

    function aboutUS()
	{
		$this->db->select('*');
		$this->db->where(array('content_type'=>'about_us'));
		$result = $this->db->get(CONTENT);
		$res = $result->row_array();
		return $res;
	} //End function
        
}//ENd Class
?>
