<?php
class Post_model extends CI_Model 
{
	function createPost($data_val)
	{
		$this->db->insert('post',$data_val);
		$this->db->insert_id();
		return array('regType'=>'SA');
	}
	
	function getPostlist($start,$limit)
	{
		//print_r("gfd00");die;
		$this->db->select('post.id, post.postType, post.title, post.postContent, post.crd, users.fullName, users.image as profileImage');
		$this->db->from('post');
        $this->db->join('users', 'users.id  = post.userId');
        $this->db->order_by('post.id','desc');
        $this->db->limit($limit,$start);
        $sql = $this->db->get();
       // echo $this->db->last_query();die;

		if ($sql->num_rows() > 0)
        {
        	$data = $sql->result_array();

        	foreach ($data as $k => $v)
        	{
 				$id = $v['id'];
 				$image = $v['profileImage'];
 				$url ="";
 				$urlT ="";
 				if(!empty($image)):
 					$url = base_url().'uploads/profile/thumb/'.$image;
 				endif;
 				$userId = (isset($this->authData->id) && !empty($this->authData->id)) ?$this->authData->id :0;
        		$data[$k]['isLike'] =$this->isLikeOur($userId,$id);
        		$data[$k]['countLike'] =$this->countLike($id);
        		$data[$k]['countComment'] =$this->countComment($id);
        		//$data[$k]['comment'] =$this->getCommnet($id);
        		$data[$k]['profileImage'] = $url;
        		$data[$k]['profileImageThumb'] = $url;
        		$data[$k]['postContentResize']="";
        		$data[$k]['postContentThumb']="";
        		$data[$k]['createTime']= $this->time_elapsed_string($v['crd']);
        		if($v['postType']=='image'){
        			$data[$k]['postContent'] 		= base_url().'uploads/post/'.$v['postContent'];
        			$data[$k]['postContentResize'] 	= base_url().'uploads/post/resize/'.$v['postContent'];
        			$data[$k]['postContentThumb'] 	= base_url().'uploads/post/thumb/'.$v['postContent'];
        		}
        	}
            return $data;
        }
        return false;
	}

	function getCommnet($id)
	{ 
		$this->db->select('comment.comment, comment.id, users.fullName as commentBy, users.image as profileImage, comment.crd, users.id');
		$this->db->join('users', 'users.id  = comment.userId');
		$this->db->where('comment.postId',$id);
		$sql = $this->db->get('comment');
		if ($sql->num_rows() > 0)
        {
        	$data = $sql->result_array();

        	foreach ($data as $k => $v)
        	{ 
 				$id = $v['id'];
 				$image = $v['profileImage']; 
 				$url ="";
 				if(!empty($image)):
 					$url = base_url().'uploads/profile/thumb/'.$image; 
 					$data[$k]['profileImage'] = $url;
 				endif;
 				$data[$k]['profileImage'] = $url;
        	}
            return $data;
        }
        return false;
		$result = $this->db->get('comment');
		$res = $result->result_array();
		return $res;
	}

	function countLike($id)
	{
		$this->db->where(array('postId'=>$id,'status'=>1));
		$this->db->from("like");
		return $this->db->count_all_results();
	}
	
	function addComment($data)
	{
		//print_r($data); die;
		$this->db->insert('comment',$data);
		$this->db->insert_id();
		return array('regType'=>'SA');
	}

	function countComment($id)
	{
		$this->db->where('postId',$id);
		$this->db->from("comment");
		return $this->db->count_all_results();
	}

	function postLike($data)
	{ 
		$this->db->select('status');  
	    $this->db->where(array('postId'=>$data['postId'],'userId'=>$data['userId']));
		$sql = $this->db->get('like');
		if($sql->num_rows() > 0)
		{
			$status = $sql->row();
			$res = ($status->status == 1) ? 0 : 1 ;
			$this->db->set('status', $res); 
			$this->db->where(array('postId'=>$data['postId'],'userId'=>$data['userId']));
			$update = $this->db->update('like');
			$msg = $res ?'like':'unLike';
			return array('regType'=>'SU','isLike'=>$msg);
		}
		else
		{
			$this->db->insert('like',$data);
			$i=$this->db->insert_id();
			$msg = $i ?'like':'unLike';
			return array('regType'=>'SL','isLike'=>$msg);
		}

		return true;
	}

	function getCommentList($data)
	{
		$this->db->select('comment.id as commentId,comment.comment, users.fullName as commentBy, users.image , comment.crd, users.id as userId')->from('comment');
		$this->db->join('users', 'users.id  = comment.userId');
		$this->db->where('comment.postId',$data['postId']);
		$sql = $this->db->get();
		if ($sql->num_rows() > 0)
        {
        	$data = $sql->result_array();

        	foreach ($data as $k => $v)
        	{ 
 				$id = $v['userId'];
 				$image = $v['image']; 
 				$url ="";
 				if(!empty($image)):
 					$url = base_url().'uploads/profile/thumb/'.$image; 
 					$data[$k]['image'] = $url;
 				endif;
 				$data[$k]['commentTime'] = $this->time_elapsed_string($v['crd']);
        	}
            return $data;
        }
        return false;
	} //End function

	function isLikeOur($userId=0, $postId)
	{
		$res=0;
		if($userId):
			$this->db->select('status');
			$this->db->where(array('postId'=>$postId,'userId'=>$userId));
			$sql = $this->db->get('like');
			if($sql->num_rows()):
				$status = $sql->row()->status;
				$res = $status ;
			endif;
		endif;
		return $res;
	}//End FUnction 
	function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}//End Function
	
}//ENd Class
