<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


	function getAllData($table)
	{
		$this->db->select('*');
		$sql = $this->db->get($table);
		$result = $sql->result_array();
		return $result;
	}

	/* Check user login and set session */
	function isLogin($data, $table)
	{
		$email      = $data['email'];
		$userType   = $data['userType'];
		// check if e-mail address is well-formed
		$where = array('email'=>$email,'userType'=>$userType);
		$sql = $this->db->select('*')->where($where)->get($table);

		if($sql->num_rows())
		{
			$user = $sql->row();
			//check user's status, if 1 then login successfully
			if($user->status == 1){
				//verify password
				if(password_verify($data['password'], $user->password))
				{	
					$this->common_model->updateFields($table,array('deviceToken' => 'system'), $where);
					$session_data['id']         = $user->id ;
					$session_data['fullName']   = $user->fullName ;
					$session_data['email']		= $user->email ;
					$session_data['image']      = make_user_img_url($user->image) ;
					$session_data['userType']   = $user->userType;
					$session_data['isLogin'] 	= TRUE ;
					
					$this->session->set_userdata($session_data);
					return array('status'=>1);
				}
				else
				{
					return array('status'=>2);
				}
			}
			return array('status'=>4);
		}
		return array('status'=>3);
	}//End Function


	

	function checkEmail($fullName,$email,$contactNumber){
		$where = array('email'=>$email);
		$sql = $this->db->select('*')->where($where)->get(USERS);
		if($sql->num_rows()){
			return 'This email already exists';
		}else{
			$where = array('contactNumber'=>$contactNumber);
			$sql = $this->db->select('*')->where($where)->get(USERS);
			if($sql->num_rows()){
				return 'This contact number already exists';
			}else{
				return 1;
			}
		}
	}


	function checkTypeFB($userId,$userType){
		$where = array('id'=>$userId,'userType'=>$userType);
		$sql = $this->db->select('*')->where($where)->get(USERS);
		if($sql->num_rows()){
			return 1;
		}else{
			return 0;
		}
	}


	function getAllEvent($userId){
		$where = array('user_id'=>$userId);
		$sql = $this->db->select('*')->where($where)->get('user_category_mapping');
		$catId = $sql->row_array();
		$categoryId = $catId['category_id'];

		$where = array('category_id'=>1);
		$sql1 = $this->db->select('*')->where($where)->join('posts','post_category_mapping.post_id = posts.id')->get('post_category_mapping');
		$result = $sql1->result_array();
		return $result;
	}





}